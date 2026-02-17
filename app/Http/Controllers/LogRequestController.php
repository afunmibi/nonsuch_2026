<?php

namespace App\Http\Controllers;

use id;
use App\Models\User;
use App\Models\Package;
use App\Models\LogRequest;
use Illuminate\Http\Request;
use App\Models\Hcp_hospitals;
use Illuminate\Support\Facades\Log;

class LogRequestController extends Controller
{
    /**
     * Display a listing of medical requests.
     */
    public function index()
    {
        // Using 'staff' and 'package' relationships defined in your model
        $logRequests = LogRequest::with(['staff', 'package'])->latest()->paginate(10);
        return view('logRequests.index', compact('logRequests'));
    }

    /**
     * Show the detailed clinical view of a specific request.
     */
    public function show(LogRequest $logRequest)
    {
        // Load relationships to show staff names and package details in the view
        $logRequest->load(['staff', 'package']);
        
        // Fetch enrolment for utilization checking
        $enrolment = \App\Models\Enrolment::where('policy_no', $logRequest->policy_no)->first();
        
        return view('logRequests.show', compact('logRequest', 'enrolment'));
    }

    /**
     * Show the form for creating a new request.
     */
    public function create()
    {
        return view('logRequests.create', [
            'packages'  => Package::all(),
            'hcps'      => Hcp_hospitals::all(),
            'diagnoses' => \App\Models\Diagnosis::all(),
        ]);
    }

    /**
     * Store a newly created medical request.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'policy_no'             => 'required|string',
            'full_name'             => 'required|string',
            'phone_no'              => 'required|string',
            'dob'                   => 'required|date',
            'pry_hcp'               => 'required|string',
            'pry_hcp_code'          => 'nullable|string',
            'sec_hcp'               => 'required|string',
            'sec_hcp_code'          => 'nullable|string',
            'package_code'          => 'required|string',
            'package_price'         => 'required|numeric',
            'package_limit'         => 'required|numeric',
            'package_description'   => 'required|string',
            'diagnosis'             => 'required|string',
            'diag_code'             => 'nullable|string',
            'treatment_plan'        => 'required|string',
            'further_investigation' => 'required|string',
        ]);

        try {
            $validated['staff_id'] = auth()->id();
            $validated['pa_code_status'] = 'pending';

            LogRequest::create($validated);

            return redirect()->route('logRequests.index')
                ->with('success', 'Medical request logged successfully!');

        } catch (\Exception $e) {
    // This will force the error to show on screen instead of redirecting
    dd($e->getMessage()); 
    
    Log::error("Medical Request Save Error: " . $e->getMessage());
    return back()->withInput()->with('error', 'Database Error: ' . $e->getMessage());
}
    }

    /**
     * Update an existing medical request.
     */
    public function update(Request $request, LogRequest $logRequest)
    {
        $validated = $request->validate([
            'full_name'             => 'required|string|max:255',
            'policy_no'             => 'required|string|max:255',
            'dob'                   => 'required|date',
            'phone_no'              => 'required|string|max:20',
            'pry_hcp'               => 'required|string',
            'sec_hcp'               => 'nullable|string',
            'package_code'          => 'required|string',
            'diagnosis'             => 'required|string',
            'treatment_plan'        => 'required|string',
            'further_investigation' => '|string',
            'pa_code_status'        => 'required|string|in:pending,approved,rejected',
        ]);

        $logRequest->update($validated);

        return redirect()->route('logRequests.index')
            ->with('success', 'Medical request updated successfully!');
    }

    /**
     * Remove the request from storage.
     */
    public function destroy(LogRequest $logRequest)
    {
        $logRequest->delete();
        return redirect()->route('logRequests.index')
            ->with('success', 'Medical request deleted successfully!');
    }

    /**
     * Approve the medical request.
     */
    public function approve(Request $request, $id)
    {
        $logRequest = LogRequest::findOrFail($id);
        
        $hmo_plan = 'PHIS';
        $hmo_code = '051';
        $random = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        
        // Use the diagnosis code already logged in this request, or 'GEN' as fallback
        $diagnosis_code = $logRequest->diag_code ?? 'GEN'; 
        
        // Generate a unique PA Code with correct concatenation
        $paCode = $hmo_code . '/' . 
                  $hmo_plan . '/' . 
                  $random . '/' . 
                  $diagnosis_code . '/' . 
                  date('Y') . '/' . 
                  strtoupper(date('M')) . '/' . 
                  str_pad($logRequest->id, 4, '0', STR_PAD_LEFT);

        // CRITICAL: Update both status AND the code
        $logRequest->update([
            'pa_code_status' => 'approved',
            'pa_code' => $paCode, 
            'pa_code_approved_by' => auth()->user()->name, 
        ]);

        return back()->with([
            'success' => 'Request approved successfully!',
            'pa_code' => $paCode
        ]);
    }

    /**
     * Reject the medical request with a reason.
     */
    public function reject(Request $request, LogRequest $logRequest)
    {
        $request->validate([
            'rejection_reason' => 'required|string|min:5',
        ]);

        $logRequest->update([
            'pa_code_status'           => 'rejected',
            'pa_code_rejection_reason' => $request->rejection_reason,
            'pa_code_rejected_by'      => auth()->id(),
        ]);

        return redirect()->route('logRequests.index')
            ->with('success', 'Medical request rejected successfully!');
    }
}