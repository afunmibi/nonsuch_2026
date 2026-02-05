<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UdDashboardController extends Controller
{
    /**
     * Show UD dashboard.
     */
    public function index()
    {
        // UD specific stats
        $stats = [
            'pending_log_requests' => \App\Models\LogRequest::where('status', 'pending')->count(),
            'my_enrolments' => \App\Models\Enrolment::where('created_by', auth()->id())->count(),
            'total_packages' => \App\Models\Package::count(),
        ];

        $recentLogRequests = \App\Models\LogRequest::latest()->take(5)->get();

        return view('dashboards.ud.index', compact('stats', 'recentLogRequests'));
    }
}