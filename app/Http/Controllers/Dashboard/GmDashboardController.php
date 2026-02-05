<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GmDashboardController extends Controller
{
    /**
     * Show GM dashboard.
     */
    public function index()
    {
        // GM specific stats
        $stats = [
            'total_users' => \App\Models\User::count(),
            'total_hcps' => \App\Models\Hcp::count(),
            'total_packages' => \App\Models\Package::count(),
            'total_revenue' => \App\Models\BillVetting::where('pa_code_status', 'approved')->sum('amount_due'),
        ];

        $recentUsers = \App\Models\User::with('roles')->latest()->take(5)->get();
        $monthlyStats = \App\Models\BillVetting::where('pa_code_status', 'approved')
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('amount_due');

        return view('dashboards.gm.index', compact('stats', 'recentUsers', 'monthlyStats'));
    }
}