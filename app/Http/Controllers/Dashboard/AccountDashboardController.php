<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountDashboardController extends Controller
{
    /**
     * Show Account dashboard.
     */
    public function index()
    {
        // Account specific stats
        $stats = [
            'pending_invoices' => \App\Models\BillVetting::where('payment_status', 'pending')->count(),
            'paid_this_month' => \App\Models\BillVetting::where('payment_status', 'paid')
                ->whereMonth('created_at', now()->month)
                ->sum('amount_due'),
            'total_hcps' => \App\Models\Hcp::count(),
            'active_contracts' => \App\Models\Package::count(),
        ];

        $recentInvoices = \App\Models\BillVetting::whereNotNull('payment_status')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboards.account.index', compact('stats', 'recentInvoices'));
    }
}