<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Auth, Log};
use App\Models\{VettedDrug, VettedService, BillVetting, LogRequest};
use Carbon\Carbon;

class BillVettingController extends Controller
{
    protected $viewPath = 'bill-vetting';

    public function index(Request $request)
    {
        if ($request->filled('pa_code')) {
            $encoded = base64_encode($request->pa_code);
            return redirect()->route('bill-vetting.edit', ['encoded_pa_code' => $encoded]);
        }

        // Show all requests that have a generated PA Code but haven't been vetted yet
        $logRequests = LogRequest::whereNotNull('pa_code')
            ->whereNull('vetted_by')
            ->latest()
            ->paginate(10);
            
        return view("{$this->viewPath}.index", compact('logRequests'));
    }

    /**
     * Show form for creating a new bill entry
     */
    public function create()
    {
        // Redirect to edit with 'new' parameter to show blank form
        return redirect()->route('bill-vetting.edit', ['encoded_pa_code' => 'new']);
    }

    /**
     * Search for PA Code and return patient data (API endpoint for prefetch)
     */
    public function searchPaCode($pa_code)
    {
        try {
            $patient = LogRequest::where('pa_code', $pa_code)->first();
            
            if ($patient) {
                $patient->load('monitoring');
                return response()->json([
                    'success' => true,
                    'data' => $patient
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'PA Code not found'
                ], 404);
            }
        } catch (\Exception $e) {
            Log::error("PA Code Search Error: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error searching for PA Code'
            ], 500);
        }
    }

   public function edit($encoded_pa_code = null)
{
    // NEW ENTRY MODE: Show blank form for manual data entry
    if (!$encoded_pa_code || $encoded_pa_code === '0' || $encoded_pa_code === 'new') {
        $billVetting = new \stdClass();
        $billVetting->pa_code = '';
        $billVetting->full_name = '';
        $billVetting->policy_no = '';
        $billVetting->dob = '';
        $billVetting->phone_no = '';
        $billVetting->package_code = '';
        $billVetting->package_description = '';
        $billVetting->package_price = 0;
        $billVetting->package_limit = 0;
        $billVetting->pry_hcp = '';
        $billVetting->pry_hcp_code = '';
        $billVetting->sec_hcp = '';
        $billVetting->sec_hcp_code = '';
        $billVetting->diagnosis = '';
        $billVetting->treatment_plan = '';
        $billVetting->further_investigation = '';
        $billVetting->billing_month = date('Y-m');
        $billVetting->admission_days = 0;
        
        return view("{$this->viewPath}.edit", [
            'billVetting' => $billVetting,
            'pa_code'     => '',
            'vettedServices' => collect(),
            'vettedDrugs'    => collect(),
            'history'        => collect()
        ]);
    }

    // EXISTING PA CODE MODE: Fetch and prefill from LogRequest
    try {
        $pa_code = base64_decode($encoded_pa_code);
        
        // Fetch from LogRequest (source of truth for patient data)
        $billVetting = LogRequest::with('monitoring')->where('pa_code', $pa_code)->first();
        
        // If not found in LogRequest, return error
        if (!$billVetting) {
            return redirect()->route('bill-vetting.index')
                           ->with('error', 'PA Code not found in system.');
        }

        // Fetch history based on policy number from BillVetting table
        $history = BillVetting::where('policy_no', $billVetting->policy_no)
            ->where('pa_code', '!=', $pa_code)
            ->latest()
            ->get();
        
        // Fetch existing vetted services and drugs (if re-vetting)
        $vettedServices = VettedService::where('pa_code', $pa_code)->get();
        $vettedDrugs = VettedDrug::where('pa_code', $pa_code)->get();

        // Return the view with all necessary data
        return view("{$this->viewPath}.edit", compact(
            'billVetting', 'pa_code', 'vettedServices', 'vettedDrugs', 'history'
        ));

    } catch (\Exception $e) {
        Log::error("Edit Error: " . $e->getMessage());
        return redirect()->route('bill-vetting.index')->with('error', 'Invalid PA Code format.');
    }
}


   public function store(Request $request)
{
    $data = $request->validate([
        // Patient and PA Information
        'pa_code'         => 'required|string',
        'full_name'       => 'required|string|max:255',
        'policy_no'       => 'required|string|max:255',
        'dob'             => 'required|date',
        'phone_no'        => 'required|string|max:20',
        
        // Package Information
        'package_code'    => 'required|string|max:50',
        'package_description' => 'nullable|string',
        'package_price'   => 'nullable|numeric',
        'package_limit'   => 'nullable|numeric',
        
        // HCP Information
        'pry_hcp'         => 'required|string|max:255',
        'pry_hcp_code'    => 'required|string|max:50',
        'sec_hcp'         => 'nullable|string|max:255',
        'sec_hcp_code'    => 'nullable|string|max:50',
        
        // Medical Information
        'diagnosis'       => 'required|string',
        'treatment_plan'  => 'required|string',
        'further_investigation' => 'nullable|string',
        
        // Billing Information
        'billing_month'   => 'required|string',
        'admission_date'  => 'nullable|date',
        'discharge_date'  => 'nullable|date',
        'admission_days'  => 'nullable|integer',
        
        // Services and Drugs
        'services'        => 'nullable|array',
        'services.*.service_name' => 'required_with:services',
        'services.*.tariff' => 'required|numeric',
        'services.*.qty' => 'required|integer|min:1',
        'services.*.total_hcp_amount_claimed' => 'nullable|numeric',
        'services.*.remarks' => 'nullable|string',
        'drugs'           => 'nullable|array',
        'drugs.*.drug_name' => 'required_with:drugs',
        'drugs.*.tariff' => 'required|numeric',
        'drugs.*.qty' => 'required|integer|min:1',
        'drugs.*.total_hcp_amount_claimed' => 'nullable|numeric',
        'drugs.*.remarks' => 'nullable|string',
    ]);

    try {
        return DB::transaction(function () use ($data) {
            $paCode = $data['pa_code'];
            $userName = Auth::user()->name ?? 'System';
            
            // Step 1: Check if LogRequest exists, create or update
            $log = LogRequest::where('pa_code', $paCode)->first();
            
            if ($log) {
                // Update existing LogRequest
                $log->update([
                    'full_name'       => $data['full_name'],
                    'policy_no'       => $data['policy_no'],
                    'dob'             => $data['dob'],
                    'phone_no'        => $data['phone_no'],
                    'package_code'    => $data['package_code'],
                    'package_description' => $data['package_description'] ?? null,
                    'package_price'   => $data['package_price'] ?? 0,
                    'package_limit'   => $data['package_limit'] ?? 0,
                    'pry_hcp'         => $data['pry_hcp'],
                    'pry_hcp_code'    => $data['pry_hcp_code'],
                    'sec_hcp'         => $data['sec_hcp'] ?? null,
                    'sec_hcp_code'    => $data['sec_hcp_code'] ?? null,
                    'diagnosis'       => $data['diagnosis'],
                    'treatment_plan'  => $data['treatment_plan'],
                    'further_investigation' => $data['further_investigation'] ?? null,
                    'vetted_by'       => $userName,
                    'pa_code_status'  => 'vetted'
                ]);
            } else {
                // Create new LogRequest
                $log = LogRequest::create([
                    'staff_id'        => Auth::id(),
                    'pa_code'         => $paCode,
                    'full_name'       => $data['full_name'],
                    'policy_no'       => $data['policy_no'],
                    'dob'             => $data['dob'],
                    'phone_no'        => $data['phone_no'],
                    'package_code'    => $data['package_code'],
                    'package_description' => $data['package_description'] ?? null,
                    'package_price'   => $data['package_price'] ?? 0,
                    'package_limit'   => $data['package_limit'] ?? 0,
                    'pry_hcp'         => $data['pry_hcp'],
                    'pry_hcp_code'    => $data['pry_hcp_code'],
                    'sec_hcp'         => $data['sec_hcp'] ?? null,
                    'sec_hcp_code'    => $data['sec_hcp_code'] ?? null,
                    'diagnosis'       => $data['diagnosis'],
                    'treatment_plan'  => $data['treatment_plan'],
                    'further_investigation' => $data['further_investigation'] ?? null,
                    'vetted_by'       => $userName,
                    'pa_code_status'  => 'vetted'
                ]);
            }

            // Step 2: Delete existing vetted services and drugs (for re-vetting or updates)
            VettedService::where('pa_code', $paCode)->delete();
            VettedDrug::where('pa_code', $paCode)->delete();

            // Initialize totals
            $serviceTotals = ['due' => 0, 'claimed' => 0];
            $drugTotals = ['due' => 0, 'claimed' => 0];

            // Step 3: Process and save services
            foreach ($data['services'] ?? [] as $s) {
                if (empty($s['service_name'])) continue;

                $totalDue = (float)($s['tariff'] ?? 0) * (int)($s['qty'] ?? 1);
                $claimedAmount = (float)($s['total_hcp_amount_claimed'] ?? 0);

                VettedService::create([
                    'pa_code'      => $paCode,
                    'service_name' => $s['service_name'],
                    'tariff'       => $s['tariff'],
                    'qty'          => $s['qty'],
                    'hcp_amount_due_total_services' => $totalDue,
                    'hcp_amount_claimed_total_services' => $claimedAmount,
                    'remarks'      => $s['remarks'] ?? null,
                    'vetted_by'    => $userName,
                ]);

                $serviceTotals['due'] += $totalDue;
                $serviceTotals['claimed'] += $claimedAmount;
            }

            // Step 4: Process and save drugs
            foreach ($data['drugs'] ?? [] as $d) {
                if (empty($d['drug_name'])) continue;

                $gross = (float)($d['tariff'] ?? 0) * (int)($d['qty'] ?? 1);
                $copayment = $gross * 0.10;
                $net = $gross - $copayment;
                $claimedAmount = (float)($d['total_hcp_amount_claimed'] ?? 0);

                VettedDrug::create([
                    'pa_code'      => $paCode,
                    'drug_name'    => $d['drug_name'],
                    'tariff'       => $d['tariff'],
                    'qty'          => $d['qty'],
                    'copayment_10' => $copayment,
                    'hcp_amount_due_total_drugs' => $net,
                    'hcp_amount_claimed_total_drugs' => $claimedAmount,
                    'remarks'      => $d['remarks'] ?? null,
                    'vetted_by'    => $userName,
                ]);

                $drugTotals['due'] += $net;
                $drugTotals['claimed'] += $claimedAmount;
            }

            // Step 5: Update or Create BillVetting entry
            BillVetting::updateOrCreate(
                ['pa_code' => $paCode],
                [
                    'full_name'      => $data['full_name'],
                    'policy_no'      => $data['policy_no'],
                    'dob'            => $data['dob'],
                    'phone_no'       => $data['phone_no'],
                    'package_code'   => $data['package_code'],
                    'package_price'  => $data['package_price'] ?? 0,
                    'package_limit'  => $data['package_limit'] ?? 0,
                    'pry_hcp'        => $data['pry_hcp'],
                    'pry_hcp_code'   => $data['pry_hcp_code'],
                    'sec_hcp'        => $data['sec_hcp'] ?? null,
                    'sec_hcp_code'   => $data['sec_hcp_code'] ?? null,
                    'diagnosis'      => $data['diagnosis'],
                    'treatment_plan' => $data['treatment_plan'],
                    'further_investigation' => $data['further_investigation'] ?? null,
                    'billing_month'  => $data['billing_month'],
                    'admission_date' => !empty($data['admission_date']) ? $data['admission_date'] : null,
                    'discharge_date' => !empty($data['discharge_date']) ? $data['discharge_date'] : null,
                    'admission_days' => $data['admission_days'] ?? 0,
                    'hcp_amount_due_grandtotal' => $serviceTotals['due'] + $drugTotals['due'],
                    'hcp_amount_claimed_grandtotal' => $serviceTotals['claimed'] + $drugTotals['claimed'],
                    'vetted_by'      => $userName,
                    'pa_code_approved_by' => $log->pa_code_approved_by,
                    'log_request_id' => $log->id,
                ]
            );

            // Step 6: Update corresponding LogRequest with vetted_by and grand totals
            $log->update([
                'vetted_by' => $userName,
                'hcp_amount_due_grandtotal' => $serviceTotals['due'] + $drugTotals['due'],
                'hcp_amount_claimed_grandtotal' => $serviceTotals['claimed'] + $drugTotals['claimed'],
            ]);

            return response()->json([
                'success' => true, 
                'message' => 'Bill vetting saved successfully to all tables',
                'redirect' => route('bill-vetting.index')
            ]);
        });
    } catch (\Exception $e) {
        Log::error("Vetting Store Error: " . $e->getMessage());
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}


   public function show($encoded_pa_code)
{
    try {
        // Decode the encoded PA code
        $pa_code = base64_decode($encoded_pa_code);
        
        // Fetch the BillVetting record with related services and drugs
        $billVetting = BillVetting::with(['services', 'drugs', 'monitoring'])->where('pa_code', $pa_code)->firstOrFail();
        
        // Retrieve vetted services and drugs
        $vettedServices = $billVetting->services;
        $vettedDrugs = $billVetting->drugs;

        // Check if vetted_by is empty for all three tables
        $isVettedByEmpty = is_null($billVetting->vetted_by) && 
                           $vettedServices->every(fn($service) => is_null($service->vetted_by)) &&
                           $vettedDrugs->every(fn($drug) => is_null($drug->vetted_by));

        // Return view with conditions (pass as 'log' for backward compatibility with view)
        $log = $billVetting;
        return view("{$this->viewPath}.show", compact('log', 'billVetting', 'vettedServices', 'vettedDrugs', 'isVettedByEmpty'));
        
    } catch (\Exception $e) {
        return redirect()->route('bill-vetting.index')->with('error', 'Record not found.');
    }
}


    public function destroy($encoded_pa_code)
    {
        try {
            $pa_code = base64_decode($encoded_pa_code);
            return DB::transaction(function () use ($pa_code) {
                BillVetting::where('pa_code', $pa_code)->delete();
                VettedService::where('pa_code', $pa_code)->delete();
                VettedDrug::where('pa_code', $pa_code)->delete();
                return redirect()->route('bill-vetting.index')->with('success', 'Deleted successfully.');
            });
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Delete failed: ' . $e->getMessage());
        }
    }
}