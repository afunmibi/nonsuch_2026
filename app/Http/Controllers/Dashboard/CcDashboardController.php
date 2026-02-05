<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CcDashboardController extends Controller
{
    /**
     * Show CC dashboard.
     */
    public function index()
    {
        // CC specific stats
        $stats = [
            'my_tasks' => 12, // Example tasks count
            'completed_today' => 8, // Example completed tasks
            'pending_review' => \App\Models\BillVetting::where('pa_code_status', 'pending')->count(),
            'total_packages' => \App\Models\Package::count(),
        ];

        $recentTasks = collect(); // Placeholder for task logic

        return view('dashboards.cc.index', compact('stats', 'recentTasks'));
    }
}