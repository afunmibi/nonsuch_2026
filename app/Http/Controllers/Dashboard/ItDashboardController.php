<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ItDashboardController extends Controller
{
    /**
     * Show IT dashboard.
     */
    public function index()
    {
        // IT specific stats
        $stats = [
            'total_users' => \App\Models\User::count(),
            'active_sessions' => 45, // Example count
            'system_health' => 'Good', // Example status
            'pending_tickets' => 8, // Example count
        ];

        $systemLogs = collect(); // Placeholder for system logs

        return view('dashboards.it.index', compact('stats', 'systemLogs'));
    }
}