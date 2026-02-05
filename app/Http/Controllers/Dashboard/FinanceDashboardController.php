<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinanceDashboardController extends Controller
{
    /**
     * Show Finance dashboard.
     */
    public function index()
    {
        // Finance specific stats
        $stats = [
            'total_revenue' => \App\Models\BillVetting::where('payment_status', 'paid')->sum('amount_due'),
            'revenue_this_month' => \App\Models\BillVetting::where('payment_status', 'paid')
                ->whereMonth('created_at', now()->month)
                ->sum('amount_due'),
            'pending_payments' => \App\Models\BillVetting::where('payment_status', 'pending')->count(),
            'total_expenses' => 450000, // Example expense figure
        ];

        $recentTransactions = \App\Models\BillVetting::latest()
            ->take(5)
            ->get();

        return view('dashboards.finance.index', compact('stats', 'recentTransactions'));
    }
}