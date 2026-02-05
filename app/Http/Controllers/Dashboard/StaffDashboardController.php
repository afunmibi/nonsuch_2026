<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StaffDashboardController extends Controller
{
    /**
     * Show Staff dashboard.
     */
    public function index()
    {
        // Staff specific stats
        $stats = [
            'my_log_requests' => \App\Models\LogRequest::where('created_by', auth()->id())->count(),
            'my_enrolments' => \App\Models\Enrolment::where('created_by', auth()->id())->count(),
            'total_packages' => \App\Models\Package::count(),
            'recent_activities' => 5, // Example count
        ];

        $myActivities = \App\Models\LogRequest::where('created_by', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        return view('dashboards.staff.index', compact('stats', 'myActivities'));
    }
}