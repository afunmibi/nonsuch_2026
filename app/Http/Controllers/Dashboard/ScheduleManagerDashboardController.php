<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScheduleManagerDashboardController extends Controller
{
    /**
     * Show Schedule Manager dashboard.
     */
    public function index()
    {
        // Schedule Manager specific stats
        $stats = [
            'active_appointments' => 45, // Example count
            'scheduled_today' => 12,
            'pending_approvals' => \App\Models\BillVetting::where('pa_code_status', 'pending')->count(),
            'staff_schedules' => \App\Models\User::count() * 2, // Example calculation
        ];

        $todaySchedule = \App\Models\LogRequest::whereDate('created_at', today())
            ->latest()
            ->take(5)
            ->get();

        return view('dashboards.schedule_manager.index', compact('stats', 'todaySchedule'));
    }
}