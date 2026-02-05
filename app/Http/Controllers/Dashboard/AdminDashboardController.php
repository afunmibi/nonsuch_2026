<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index()
    {
        // Stats for admin dashboard
        $stats = [
            'total_users' => \App\Models\User::count(),
            'total_packages' => \App\Models\Package::count(),
            'total_log_requests' => \App\Models\LogRequest::count(),
            'total_enrolments' => \App\Models\Enrolment::count(),
            'pending_bills' => \App\Models\BillVetting::where('pa_code_status', 'pending')->count(),
            'total_hcps' => \App\Models\Hcp::count(),
        ];

        $recentActivity = [
            'latest_log_request' => \App\Models\LogRequest::latest()->first(),
            'latest_enrolment' => \App\Models\Enrolment::latest()->first(),
            'latest_bill_vetting' => \App\Models\BillVetting::latest()->first(),
        ];

        $users = \App\Models\User::with('roles')->latest()->take(5)->get();

        return view('dashboards.admin.index', compact('stats', 'recentActivity', 'users'));
    }
}