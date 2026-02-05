<?php

namespace App\Http\Controllers;

use App\Models\BillVetting;
use Illuminate\Http\Request;

class GmController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->filled('pa_code')) {
            $billvetting = collect(); 
        } else {
            // Fetch bills already processed by Staff
            $billvetting = BillVetting::where('pa_code', $request->pa_code)
                                       ->whereNotNull('checked_by') 
                                       ->get();
        }

        return view('bill-management.gm.index', compact('billvetting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bill-vetting.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        BillVetting::create($request->all());
        return redirect()->route('bill-vetting.index');

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $paCode = base64_decode($id);
        
        // Fetch the bill and its associations using the relationships defined in the Model
        // We use 'with' to pull data from vettedservice and vetterdrug tables automatically
        $log = BillVetting::with(['services', 'drugs'])
                            ->where('pa_code', $paCode)
                            ->firstOrFail();

        return view('bill-vetting.show', compact('log'));
    }

    /**
     * EDIT: Prepare Bill + Services + Drugs for modification
     */
    public function edit($encodedPaCode)
    {
        try {
            $paCode = base64_decode($encodedPaCode);

            // Fetch everything related to the PA Code
            $log = BillVetting::with(['services', 'drugs'])
                                ->where('pa_code', $paCode)
                                ->firstOrFail();

            return view('bill-management.gm.edit', compact('log'));
            
        } catch (\Exception $e) {
            return redirect()->route('bill-management.gm.index')
                ->with('error', 'Invalid Bill record or PA Code.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
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
                    're_checked_by'                     => auth()->user()->name,
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
                    're_checked_by'                    => auth()->user()->name,
                ]);
            }

            // Calculate Totals for fallback
            $totalClaimed = $request->hcp_amount_claimed_grandtotal ?? (
                collect($request->services)->sum(fn($s) => $s['total_hcp_amount_claimed'] ?? $s['claimed'] ?? 0) + 
                collect($request->drugs)->sum(fn($d) => $d['total_hcp_amount_claimed'] ?? $d['claimed'] ?? 0)
            );

            // 3. Update Master Record (billvetting table)
            $bill->update([
                'hcp_amount_due_grandtotal'     => $request->hcp_amount_due_grandtotal,
                'hcp_amount_claimed_grandtotal' => $totalClaimed,
                're_checked_by'                     => auth()->user()->name,
                'status'                        => 'vetted_gm',
                're_checked_at'                 => now(),
            ]);

            // 4. Update corresponding LogRequest
            if ($bill->logRequest) {
                $bill->logRequest->update([
                    're_checked_by'                 => auth()->user()->name,
                    'hcp_amount_due_grandtotal'     => $request->hcp_amount_due_grandtotal,
                    'hcp_amount_claimed_grandtotal' => $totalClaimed,
                ]);
            }
        });

        return response()->json([
            'success' => true,
            'redirect' => route('bill-management.gm.index'),
            'message' => 'Bill ' . $paCode . ' re-checked successfully.'
        ]);

    } catch (\Exception $e) {
        \Log::error("GM Re-Checking Error: " . $e->getMessage(), ['id' => $id]);
        return response()->json(['success' => false, 'message' => 'Re-checking failed: ' . $e->getMessage()], 500);
    }
}

}