<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    public function admin(): View 
    { 
        // 1. User & Enrolment Stats
        $totalUsers = \App\Models\User::count();
        $totalEnrolments = \App\Models\Enrolment::count();
        
        // 2. Bill Vetting Stats
        $totalBills = \App\Models\BillVetting::count();
        $paidBills = \App\Models\BillVetting::where('status', 'paid')->count();
        $outstandingBills = \App\Models\BillVetting::where('status', '!=', 'paid')->count();
        
        // 3. Financial Stats (Aggregated)
        $totalPaidAmount = \App\Models\BillVetting::where('status', 'paid')->sum('hcp_amount_due_grandtotal');
        $totalClaimedAmount = \App\Models\BillVetting::sum('hcp_amount_claimed_grandtotal');

        // 4. Recent Activity
        $recentBills = \App\Models\BillVetting::latest()->take(5)->get();

        return view('dashboards.Admin.index', compact(
            'totalUsers', 'totalEnrolments', 
            'totalBills', 'paidBills', 'outstandingBills', 
            'totalPaidAmount', 'totalClaimedAmount', 'recentBills'
        )); 
    }
    public function staff(): View { return view('dashboards.staff.index'); }
    public function cc(): View 
    { 
        $activeCases = \App\Models\PaMonitoring::where('monitoring_status', '!=', 'Discharged')->count();
        $totalCases = \App\Models\PaMonitoring::count();
        $recentLogs = \App\Models\PaMonitoring::with('logRequest')->latest()->take(5)->get();
        
        // Calculate Average Length of Stay (ALOS) for discharged patients
        $avgLos = \App\Models\PaMonitoring::where('monitoring_status', 'Discharged')->avg('days_spent') ?? 0;

        return view('dashboards.CC.index', compact('activeCases', 'totalCases', 'recentLogs', 'avgLos')); 
    }

    public function cm(): View 
    { 
        // CM Dashboard usually focuses on Case Management & Finance
        $totalBills = \App\Models\BillVetting::count();
        $outstandingBills = \App\Models\BillVetting::where('status', '!=', 'paid')->count();
        
        // Also relevant for CM to see active monitoring
        $activeCases = \App\Models\PaMonitoring::where('monitoring_status', '!=', 'Discharged')->count();
        
        return view('dashboards.CM.index', compact('totalBills', 'outstandingBills', 'activeCases')); 
    }
    public function ud(): View 
    { 
        // 1. UD Specific: Pending Bills for UD Review
        // Assuming 'vetted_ud' means they have done it, so we want bills that are awaiting UD action? 
        // Or if this is their dashboard, they might want to see what they HAVE done.
        // For now, let's show basic system stats similar to others but focused.
        
        $totalBills = \App\Models\BillVetting::count();
        $outstandingBills = \App\Models\BillVetting::where('status', '!=', 'paid')->count();
        // Maybe UD cares about bills assigned to them or generally waiting?
        // Let's stick to consistent high-level metrics for now.
        
        $recentBills = \App\Models\BillVetting::latest()->take(5)->get();

        return view('dashboards.UD.index', compact('totalBills', 'outstandingBills', 'recentBills')); 
    }
    public function hr(): View { return view('dashboards.hr.index'); }
    public function it(): View { return view('dashboards.it.index'); }
    public function md(): View 
    { 
        // Shared Analytics Logic (Replicated for MD)
        $totalUsers = \App\Models\User::count();
        $totalEnrolments = \App\Models\Enrolment::count();
        $totalBills = \App\Models\BillVetting::count();
        $paidBills = \App\Models\BillVetting::where('status', 'paid')->count();
        $outstandingBills = \App\Models\BillVetting::where('status', '!=', 'paid')->count();
        $totalPaidAmount = \App\Models\BillVetting::where('status', 'paid')->sum('hcp_amount_due_grandtotal');
        $totalClaimedAmount = \App\Models\BillVetting::sum('hcp_amount_claimed_grandtotal');
        $recentBills = \App\Models\BillVetting::latest()->take(5)->get();

        return view('dashboards.MD.index', compact(
            'totalUsers', 'totalEnrolments', 
            'totalBills', 'paidBills', 'outstandingBills', 
            'totalPaidAmount', 'totalClaimedAmount', 'recentBills'
        )); 
    }

    public function gm(): View 
    { 
        // Shared Analytics Logic (Replicated for GM)
        $totalUsers = \App\Models\User::count();
        $totalEnrolments = \App\Models\Enrolment::count();
        $totalBills = \App\Models\BillVetting::count();
        $paidBills = \App\Models\BillVetting::where('status', 'paid')->count();
        $outstandingBills = \App\Models\BillVetting::where('status', '!=', 'paid')->count();
        $totalPaidAmount = \App\Models\BillVetting::where('status', 'paid')->sum('hcp_amount_due_grandtotal');
        $totalClaimedAmount = \App\Models\BillVetting::sum('hcp_amount_claimed_grandtotal');
        $recentBills = \App\Models\BillVetting::latest()->take(5)->get();

        return view('dashboards.GM.index', compact(
            'totalUsers', 'totalEnrolments', 
            'totalBills', 'paidBills', 'outstandingBills', 
            'totalPaidAmount', 'totalClaimedAmount', 'recentBills'
        )); 
    }

    public function hcp(): View 
    {
        $user = auth()->user();
        $query = \App\Models\HcpBillUpload::query();

        if ($user->hcp_id) {
            $query->where('hcp_id', $user->hcp_id);
        } else {
            $query->where('user_id', $user->id);
        }

        $totalUploads = (clone $query)->count();
        $pendingUploads = (clone $query)->where('status', 'Pending')->count();
        $recentUploads = (clone $query)->latest()->take(5)->get();

        return view('dashboards.HCP.index', compact('totalUploads', 'pendingUploads', 'recentUploads'));
    }
    
    public function index(Request $request): RedirectResponse|View
    {
        $role = strtolower($request->user()->role);
        
        return match ($role) {
            'admin'    => redirect()->route('admin.dashboard'),
            'staff'    => redirect()->route('staff.dashboard'),
            'cc'       => redirect()->route('cc.dashboard'),
            'cm'       => redirect()->route('cm.dashboard'),
            'ud'       => redirect()->route('ud.dashboard'),
            'hr'       => redirect()->route('hr.dashboard'),
            'it'       => redirect()->route('it.dashboard'),
            'md'       => redirect()->route('md.dashboard'),
            'gm'       => redirect()->route('gm.dashboard'),
            'accounts' => redirect()->route('bill-management.accounts.index'),
            'hcp'      => redirect()->route('hcp.dashboard'),
            default    => view('dashboard'),
        };
    }
}
