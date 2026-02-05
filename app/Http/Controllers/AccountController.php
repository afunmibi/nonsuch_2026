<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\BillVetting;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    if ($request->filled('pa_code')) {
        // 1. Search Pending Payments
        $billvetting = BillVetting::where('pa_code', $request->pa_code)
                                   ->where('status', 'ready_for_payment') 
                                   ->get();

        // 2. Search Paid History
        $paidBills = BillVetting::where('status', 'paid')
                                ->where('pa_code', $request->pa_code)
                                ->get();
    } else {
        $billvetting = collect();

        // Default History: Last 20 Paid Bills
        $paidBills = BillVetting::where('status', 'paid')
                                ->orderBy('paid_at', 'desc')
                                ->take(20)
                                ->get();
    }

    return view('bill-management.accounts.index', compact('billvetting', 'paidBills'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Account $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Account $account)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        //
    }
    public function pay(Request $request, $pa_code)
{
    $bill = BillVetting::where('pa_code', $pa_code)->firstOrFail();

    $bill->update([
        'status' => 'paid',
        'paid_by' => auth()->user()->name,
        'paid_at' => now(),
    ]);

    return redirect()->route('bill-management.accounts.index')->with('success', 'Bill successfully marked as PAID.');
}

public function exportCsv()
{
    $fileName = 'HCP_Payments_' . date('Y-m-d') . '.csv';
    $period = request('period', 'today');
    $hcp = request('hcp');

    $query = BillVetting::where('status', 'paid');

    // Apply Time Filter based on 'paid_at'
    if ($period === 'today') {
        $query->whereDate('paid_at', \Carbon\Carbon::today());
    } elseif ($period === 'week') {
        $query->whereBetween('paid_at', [\Carbon\Carbon::now()->startOfWeek(), \Carbon\Carbon::now()->endOfWeek()]);
    } elseif ($period === 'month') {
        $query->whereMonth('paid_at', \Carbon\Carbon::now()->month)
              ->whereYear('paid_at', \Carbon\Carbon::now()->year);
    } elseif ($period === '3_months') {
        $query->where('paid_at', '>=', \Carbon\Carbon::now()->subMonths(3));
    } elseif ($period === '6_months') {
        $query->where('paid_at', '>=', \Carbon\Carbon::now()->subMonths(6));
    } elseif ($period === 'year') {
        $query->where('paid_at', '>=', \Carbon\Carbon::now()->subYear());
    }

    // Apply HCP Filter
    if ($hcp) {
        $query->where(function($q) use ($hcp) {
            $q->where('sec_hcp', 'like', "%{$hcp}%")
              ->orWhere('sec_hcp_code', 'like', "%{$hcp}%")
              ->orWhere('pry_hcp', 'like', "%{$hcp}%");
        });
    }

    $bills = $query->orderBy('paid_at', 'desc')->get();

    $headers = array(
        "Content-type"        => "text/csv",
        "Content-Disposition" => "attachment; filename=$fileName",
        "Pragma"              => "no-cache",
        "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        "Expires"             => "0"
    );

    $columns = array('Beneficiary Name', 'Account Number', 'Bank Name', 'Amount', 'PA Reference');

    $callback = function() use($bills, $columns) {
        $file = fopen('php://output', 'w');
        fputcsv($file, ['NONSUCH MEDICARE LIMITED']);
        fputcsv($file, ['HCP Payment Disbursement Schedule']);
        fputcsv($file, []); // Empty row
        fputcsv($file, $columns);

        foreach ($bills as $bill) {
            fputcsv($file, array(
                $bill->sec_hcp_account_name,
                $bill->sec_hcp_account_number,
                $bill->sec_hcp_bank_name,
                $bill->hcp_amount_due_grandtotal,
                $bill->pa_code
            ));
        }
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
public function generatePdf($pa_code)
{
    // 1. Get the main bill record
    $bill = \App\Models\BillVetting::where('pa_code', $pa_code)->firstOrFail();
    
    // 2. Get the initial log details (Diagnosis, Treatment plan etc.)
    // Note: Since you have log_request_id in billvetting, use that to link
    $logRequest = \App\Models\LogRequest::where('pa_code', $pa_code)->first();

    // 3. Fetch all itemized line items
    $services = \App\Models\VettedService::where('pa_code', $pa_code)->get();
    $drugs = \App\Models\VettedDrug::where('pa_code', $pa_code)->get();

    // 4. Data for the PDF
    $data = [
        'bill' => $bill,
        'log'  => $logRequest,
        'services' => $services,
        'drugs' => $drugs,
        'vetted_staff' => $bill->vetted_by,
        'ud_checker' => $bill->checked_by,
        'gm_rechecker' => $bill->re_checked_by,
        'md_authorizer' => $bill->approved_by, // Matching your migration column
        'cm_staff' => $bill->scheduled_for_payment_by,
        'accountant' => $bill->paid_by,
    ];

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('bill-management.pdf.invoice', $data)
             ->setPaper('a4', 'portrait');

    $safePaCode = str_replace(['/', '\\'], '_', $pa_code);
    return $pdf->stream("Voucher_{$safePaCode}.pdf");
}

public function generateSummaryPdf($pa_code)
{
    $bill = BillVetting::with(['services', 'drugs'])->where('pa_code', $pa_code)->firstOrFail();
    
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('bill-management.pdf.bill_summary', compact('bill'))
        ->setPaper('a4', 'portrait');
    
    $safePaCode = str_replace(['/', '\\'], '_', $pa_code);
    return $pdf->download("Bill_Summary_{$safePaCode}.pdf");
}

public function generateComprehensivePdf($pa_code)
{
    $bill = BillVetting::with(['services', 'drugs'])->where('pa_code', $pa_code)->firstOrFail();
    
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('bill-management.pdf.comprehensive_report', compact('bill'))
        ->setPaper('a4', 'portrait');
    
    $safePaCode = str_replace(['/', '\\'], '_', $pa_code);
    return $pdf->download("Comprehensive_Report_{$safePaCode}.pdf");
}
}