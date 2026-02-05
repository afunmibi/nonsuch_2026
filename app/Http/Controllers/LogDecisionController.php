<?php

namespace App\Http\Controllers;

use App\Models\LogRequest;
use Illuminate\Http\Request;

class LogDecisionController extends Controller
{
    /**
     * Handle Authorization Approval
     */
    public function approve(LogRequest $logRequest)
    {
        // Generation Logic
        $hmo_code = '051';
        $hmo_plan = 'PHIS';
        $random_number = mt_rand(100000, 999999);
        $month = date('m');
        $year = date('y');

        $pa_code = $hmo_code.'/'.$hmo_plan.'/'.$year.$month.'/'.$random_number.'/'.$logRequest->package_code.'/'.$logRequest->id;

        $logRequest->update([
            'pa_code_status' => 'approved',
            'pa_code' => $pa_code,
            'vetted_by' => auth()->user()->name,
        ]);

        return back()->with([
            'success' => 'Authorization Issued!',
            'pa_code' => $pa_code
        ]);
    }

    /**
     * Handle Authorization Rejection
     */
    public function reject(Request $request, LogRequest $logRequest)
    {
        $request->validate(['rejection_reason' => 'required|string']);

        $logRequest->update([
            'pa_code_status' => 'rejected',
            'pa_code_rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', 'Request has been rejected.');
    }
}