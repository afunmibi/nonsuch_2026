<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CmDashboardController extends Controller
{
    /**
     * Show CM dashboard.
     */
    public function index()
    {
        // CM specific stats
        $stats = [
            'active_enrolments' => \App\Models\Enrolment::count(),
            'new_enrolments_today' => \App\Models\Enrolment::whereDate('created_at', today())->count(),
            'total_packages' => \App\Models\Package::count(),
            'pending_log_requests' => \App\Models\LogRequest::where('status', 'pending')->count(),
        ];

        $recentEnrolments = \App\Models\Enrolment::latest()->take(5)->get();

        return view('dashboards.cm.index', compact('stats', 'recentEnrolments'));
    }
}