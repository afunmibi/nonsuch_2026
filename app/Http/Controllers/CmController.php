<?php

namespace App\Http\Controllers;

use App\Models\BillVetting;
use App\Models\Hcp_hospitals;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

class CmController extends Controller
{
    public function index(Request $request)
    {
        if ($request->filled('pa_code')) {
            // 1. Search Pending Bills (Approved by MD, not yet processed by CM)
            $billvetting = BillVetting::where('pa_code', $request->pa_code)
                                       ->whereNotNull('approved_by')
                                       ->whereNotIn('status', ['ready_for_payment', 'paid'])
                                       ->get();

            // 2. Search History (Bills already processed by CM)
            $processedBills = BillVetting::whereNotNull('cm_processed_at')
                                         ->where('pa_code', $request->pa_code)
                                         ->get();
        } else {
            $billvetting = collect();

            // Default History: Last 20 bills processed by CM
            $processedBills = BillVetting::whereNotNull('cm_processed_at')
                                         ->orderBy('cm_processed_at', 'desc')
                                         ->take(20)
                                         ->get();
        }

        return view('bill-management.cm.index', compact('billvetting', 'processedBills'));
    }

    public function show($encoded_pa_code)
    {
        $pa_code = base64_decode($encoded_pa_code);
        $bill = BillVetting::with(['services', 'drugs'])->where('pa_code', $pa_code)->firstOrFail();
        return view('bill-management.cm.show', compact('bill'));
    }

    public function edit($encoded_pa_code)
    {
        try {
            $pa_code = base64_decode($encoded_pa_code);
            $log = BillVetting::with(['services', 'drugs'])->where('pa_code', $pa_code)->firstOrFail();
            $hcps = Hcp_hospitals::orderBy('hcp_name')->get();
            return view('bill-management.cm.edit', compact('log', 'hcps'));
        } catch (\Exception $e) {
            return redirect()->route('bill-management.cm.index')->with('error', 'Bill record not found.');
        }
    }

    public function update(Request $request, $id)
    {
        $paCode = base64_decode($id);
        $bill = BillVetting::where('pa_code', $paCode)->firstOrFail();

        try {
            \DB::transaction(function () use ($request, $bill, $paCode) {
                // Final action: Mark as scheduled for payment & capture settlement bank info
                $updateData = [
                    'status' => 'ready_for_payment',
                    'scheduled_for_payment_by' => auth()->user()->name,
                    'cm_processed_at' => now(),
                    'sec_hcp_bank_name' => $request->hcp_bank,
                    'sec_hcp_account_number' => $request->hcp_account,
                    'sec_hcp_account_name' => $request->hcp_account_name,
                ];

                // Safely add HCP contact if columns exist
                if (\Schema::hasColumn('billvetting', 'hcp_contact')) $updateData['hcp_contact'] = $request->hcp_phone;
                if (\Schema::hasColumn('billvetting', 'hcp_email')) $updateData['hcp_email'] = $request->hcp_email;

                $bill->update($updateData);

                // Update LogRequest status if linked (graceful handling)
                try {
                    $logRequest = \App\Models\LogRequest::where('pa_code', $paCode)->first();
                    if ($logRequest) {
                        $logUpdate = [
                            'pa_code_status' => 'scheduled_for_payment',
                            'scheduled_for_payment_by' => auth()->user()->name,
                            'hcp_amount_due_grandtotal' => $bill->hcp_amount_due_grandtotal,
                            'hcp_amount_claimed_grandtotal' => $bill->hcp_amount_claimed_grandtotal,
                        ];

                        if (\Schema::hasColumn('log_requests', 'hcp_contact')) $logUpdate['hcp_contact'] = $request->hcp_phone;
                        if (\Schema::hasColumn('log_requests', 'hcp_email')) $logUpdate['hcp_email'] = $request->hcp_email;

                        $logRequest->update($logUpdate);
                    }
                } catch (\Exception $logError) {
                    \Log::warning("LogRequest update failed for PA: {$paCode}", ['error' => $logError->getMessage()]);
                    // Continue anyway - LogRequest update is optional
                }
            });

            return response()->json([
                'success' => true,
                'redirect' => route('bill-management.cm.index'),
                'message' => 'Bill ' . $paCode . ' has been scheduled for payment.'
            ]);
        } catch (\Exception $e) {
            \Log::error("CM Payment Error: " . $e->getMessage(), [
                'id' => $id, 
                'pa_code' => $paCode,
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false, 
                'message' => 'Processing failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function finalClose(Request $request, $pa_code)
    {
        // ... preserved for backward compatibility or direct access if needed
    }

    public function getHcpDetails($id)
    {
        return response()->json(Hcp_hospitals::findOrFail($id));
    }

    public function generatePdf($encoded_pa_code)
    {
        $paCode = base64_decode($encoded_pa_code);
        $bill = BillVetting::with(['services', 'drugs'])->where('pa_code', $paCode)->firstOrFail();
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('bill-management.pdf.vetting_summary', compact('bill'));
        $safePaCode = str_replace(['/', '\\'], '_', $paCode);
        return $pdf->stream("Payment_Notification_{$safePaCode}.pdf");
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

    public function searchHcp(Request $request)
    {
        return view('hcp.search');
    }

    public function searchHcpApi(Request $request)
    {
        $query = $request->get('query');
        $hcps = Hcp_hospitals::where('hcp_name', 'like', "%{$query}%")
                           ->orWhere('hcp_code', 'like', "%{$query}%")
                           ->limit(10)
                           ->get();
                           
        return response()->json($hcps);
    }
    public function exportCsv(Request $request)
    {
        $period = $request->get('period'); // today, week, month
        $hcp = $request->get('hcp'); // name or code

        $query = BillVetting::where('status', 'paid');

        // Apply Time Filter based on 'paid_at'
        if ($period === 'today') {
            $query->whereDate('paid_at', Carbon::today());
        } elseif ($period === 'week') {
            $query->whereBetween('paid_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } elseif ($period === 'month') {
            $query->whereMonth('paid_at', Carbon::now()->month)
                  ->whereYear('paid_at', Carbon::now()->year);
        } elseif ($period === '3_months') {
            $query->where('paid_at', '>=', Carbon::now()->subMonths(3));
        } elseif ($period === '6_months') {
            $query->where('paid_at', '>=', Carbon::now()->subMonths(6));
        } elseif ($period === 'year') {
            $query->where('paid_at', '>=', Carbon::now()->subYear());
        }

        // Apply HCP Filter
        if ($hcp) {
            $query->where(function($q) use ($hcp) {
                $q->where('sec_hcp', 'like', "%{$hcp}%")
                  ->orWhere('sec_hcp_code', 'like', "%{$hcp}%")
                  ->orWhere('pry_hcp', 'like', "%{$hcp}%");
            });
        }

        // Get Results
        $bills = $query->orderBy('paid_at', 'desc')->get();

        // Generate CSV
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="settled_bills_report.csv"',
        ];

        $callback = function() use ($bills) {
            $file = fopen('php://output', 'w');

            // Add Company Name & Title
            fputcsv($file, ['NONSUCH MEDICARE LIMITED']);
            fputcsv($file, ['Settled Bills Report']);
            fputcsv($file, []); // Empty row

            // Add Headers
            fputcsv($file, [
                'PA Code', 
                'Patient Name', 
                'Policy No', 
                'HCP Name', 
                'HCP Code', 
                'Diagnosis',
                'Bank Name',
                'Account Name',
                'Account No',
                'Amount Paid', 
                'Paid Date',
                'Processed By'
            ]);

            // Add Data
            foreach ($bills as $bill) {
                fputcsv($file, [
                    $bill->pa_code,
                    $bill->full_name,
                    $bill->policy_no,
                    $bill->sec_hcp ?? $bill->pry_hcp,
                    $bill->sec_hcp_code ?? $bill->pry_hcp_code,
                    $bill->diagnosis,
                    $bill->hcp_bank_name,
                    $bill->hcp_account_name,
                    $bill->hcp_account_number,
                    $bill->hcp_amount_due_grandtotal,
                    $bill->paid_at,
                    $bill->paid_by
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}