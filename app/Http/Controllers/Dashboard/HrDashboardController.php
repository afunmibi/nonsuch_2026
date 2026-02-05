<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HrDashboardController extends Controller
{
    /**
     * Show HR dashboard.
     */
    public function index()
    {
        // HR specific stats
        $stats = [
            'total_employees' => \App\Models\User::count(),
            'new_hires_month' => \App\Models\User::whereMonth('created_at', now()->month)->count(),
            'pending_leave_requests' => 3, // Example count
            'active_users' => \App\Models\User::whereNotNull('email_verified_at')->count(),
        ];

        $recentEmployees = \App\Models\User::latest()->take(5)->get();

        return view('dashboards.hr.index', compact('stats', 'recentEmployees'));
    }
}