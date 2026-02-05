<?php

namespace App\Http\Controllers;

use App\Models\BillVetting;
use App\Models\VettedService;
use App\Models\VettedDrug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MdController extends Controller
{
    /**
     * Search and List Bills for MD Review
     */
    public function index(Request $request)
    {
        if (!$request->filled('pa_code')) {
            $billvetting = collect(); 
        } else {
            // MD filters for bills that passed GM review (re_checked_by is not null)
            $billvetting = BillVetting::where('pa_code', $request->pa_code)
                                       ->whereNotNull('re_checked_by') 
                                       ->get();
        }

        return view('bill-management.md.index', compact('billvetting'));
    }

    /**
     * Show Bill details to MD for Final Approval
     */
    public function show($encoded_pa_code)
    {
        try {
            $pa_code = base64_decode($encoded_pa_code);
            
            // Fetch main bill with all line items
            $bill = BillVetting::with(['services', 'drugs'])
                                ->where('pa_code', $pa_code)
                                ->firstOrFail();

            return view('bill-management.md.show', compact('bill'));
        } catch (\Exception $e) {
            return redirect()->route('bill-management.md.index')
                             ->with('error', 'Bill record not found.');
        }
    }

    /**
     * Final MD Approval Action (Direct from show page if no changes needed)
     */
    public function approve(Request $request, $pa_code)
    {
        try {
            $bill = BillVetting::where('pa_code', $pa_code)->firstOrFail();

            $bill->update([
                'approved_by' => auth()->user()->name,
                'status'      => 'approved',
                'authorized_at' => now(),
            ]);

            // Update corresponding LogRequest
            if ($bill->logRequest) {
                $bill->logRequest->update([
                    'approved_by' => auth()->user()->name,
                    'pa_code_status' => 'approved',
                    'hcp_amount_due_grandtotal' => $bill->hcp_amount_due_grandtotal,
                    'hcp_amount_claimed_grandtotal' => $bill->hcp_amount_claimed_grandtotal,
                ]);
            }

            return redirect()->route('bill-management.md.index')
                ->with('success', "Bill {$pa_code} has been approved. It is now with the Case Manager (CM).");
                
        } catch (\Exception $e) {
            return back()->with('error', 'Approval failed: ' . $e->getMessage());
        }
    }

    public function edit($encodedPaCode)
    {
        try {
            $paCode = base64_decode($encodedPaCode);
            $log = BillVetting::with(['services', 'drugs'])
                                ->where('pa_code', $paCode)
                                ->firstOrFail();

            return view('bill-management.md.edit', compact('log'));
        } catch (\Exception $e) {
            return redirect()->route('bill-management.md.index')->with('error', 'Bill record not found.');
        }
    }

    public function update(Request $request, $id)
    {
        $paCode = base64_decode($id);
        $bill = BillVetting::where('pa_code', $paCode)->firstOrFail();

        $request->validate([
            'services' => 'present|array',
            'drugs' => 'present|array',
            'hcp_amount_due_grandtotal' => 'required|numeric'
        ]);

        try {
            \DB::transaction(function () use ($request, $bill, $paCode) {
                // 1. Refresh Services
                $bill->services()->delete();
                foreach ($request->services as $s) {
                    $bill->services()->create([
                        'pa_code'                       => $paCode,
                        'service_name'                  => $s['service_name'],
                        'tariff'                        => $s['tariff'],
                        'qty'                           => $s['qty'],
                        'hcp_amount_due_total_services' => $s['tariff'] * $s['qty'],
                        'hcp_amount_claimed_total_services' => $s['total_hcp_amount_claimed'] ?? $s['claimed'] ?? 0,
                        'remarks'                       => $s['remarks'] ?? null,
                        'vetted_by'                     => $bill->vetted_by,
                        'checked_by'                    => $bill->checked_by,
                        're_checked_by'                 => $bill->re_checked_by,
                        'approved_by'                   => auth()->user()->name,
                    ]);
                }

                // 2. Refresh Drugs
                $bill->drugs()->delete();
                foreach ($request->drugs as $d) {
                    $tariffTotal = $d['tariff'] * $d['qty'];
                    $bill->drugs()->create([
                        'pa_code'                      => $paCode,
                        'drug_name'                    => $d['drug_name'],
                        'tariff'                       => $d['tariff'],
                        'qty'                          => $d['qty'],
                        'copayment_10'                 => $tariffTotal * 0.1,
                        'hcp_amount_due_total_drugs'   => $tariffTotal * 0.9,
                        'hcp_amount_claimed_total_drugs' => $d['total_hcp_amount_claimed'] ?? $d['claimed'] ?? 0,
                        'remarks'                      => $d['remarks'] ?? null,
                        'vetted_by'                     => $bill->vetted_by,
                        'checked_by'                    => $bill->checked_by,
                        're_checked_by'                 => $bill->re_checked_by,
                        'approved_by'                  => auth()->user()->name,
                    ]);
                }

                // Calculate Totals for fallback
                $totalClaimed = $request->hcp_amount_claimed_grandtotal ?? (
                    collect($request->services)->sum(fn($s) => $s['total_hcp_amount_claimed'] ?? $s['claimed'] ?? 0) + 
                    collect($request->drugs)->sum(fn($d) => $d['total_hcp_amount_claimed'] ?? $d['claimed'] ?? 0)
                );

                // 3. Update Master Record
                $bill->update([
                    'hcp_amount_due_grandtotal'     => $request->hcp_amount_due_grandtotal,
                    'hcp_amount_claimed_grandtotal' => $totalClaimed,
                    'approved_by'                   => auth()->user()->name,
                    'status'                        => 'approved',
                    'authorized_at'                 => now()
                ]);

                // 4. Update LogRequest
                if ($bill->logRequest) {
                    $bill->logRequest->update([
                        'approved_by' => auth()->user()->name,
                        'pa_code_status' => 'approved',
                        'hcp_amount_due_grandtotal'     => $request->hcp_amount_due_grandtotal,
                        'hcp_amount_claimed_grandtotal' => $totalClaimed,
                    ]);
                }
            });

            return response()->json([
                'success' => true,
                'redirect' => route('bill-management.md.index'),
                'message' => 'Bill ' . $paCode . ' approved successfully.'
            ]);
        } catch (\Exception $e) {
            Log::error("MD Approval Error: " . $e->getMessage(), [
                'pa_code' => $paCode,
                'user' => auth()->user()->name,
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['success' => false, 'message' => 'Approval failed: ' . $e->getMessage()], 500);
        }
    }
}