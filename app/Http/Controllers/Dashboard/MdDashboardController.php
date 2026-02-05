<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MdDashboardController extends Controller
{
    /**
     * Show MD dashboard.
     */
    public function index()
    {
        // MD specific stats
        $stats = [
            'total_log_requests' => \App\Models\LogRequest::count(),
            'pending_approvals' => \App\Models\BillVetting::where('pa_code_status', 'pending')->count(),
            'approved_bills' => \App\Models\BillVetting::where('pa_code_status', 'approved')->count(),
            'total_enrolments' => \App\Models\Enrolment::count(),
        ];

        $recentBillVettings = \App\Models\BillVetting::latest()->take(5)->get();

        return view('dashboards.md.index', compact('stats', 'recentBillVettings'));
    }
}