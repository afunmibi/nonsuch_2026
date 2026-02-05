<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrolment;
use App\Models\LogRequest;
use App\Models\BillVetting;
use App\Models\Package;

class GlobalSearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        if (empty($query)) {
            return redirect()->back()->with('error', 'Please enter a Policy Number or Name to search.');
        }

        // 1. Find the Enrolment/Patient
        // We prioritize exact Policy No match, then Name match
        $enrolment = Enrolment::where('policy_no', $query)
                              ->orWhere('full_name', 'LIKE', "%{$query}%")
                              ->first();

        if (!$enrolment) {
            return redirect()->back()->with('error', 'No records found for that Policy Number or Name.');
        }

        // 2. Get Package Details
        // We use the package_code from enrolment to find the strict Package definition
        // primarily to get 'package_name' (plan) if not in enrolment
        $package = Package::where('package_code', $enrolment->package_code)->first();

        // 3. Get Log Requests (History)
        $logRequests = LogRequest::where('policy_no', $enrolment->policy_no)
                                 ->latest()
                                 ->take(10) // Limit simple history
                                 ->get();

        // 4. Get Last 5 Visits (Paid Bills)
        // User asked for "hcp last five visits and amount paid"
        // We look for BillVetting records that are finalized (paid or approved)
        $recentVisits = BillVetting::where('policy_no', $enrolment->policy_no)
                                   ->whereIn('status', ['paid', 'approved', 'vetted_gm', 'vetted_ud']) // Show recent activity even if not fully paid? User said "amount paid", imply paid ones.
                                   ->whereNotNull('status') // Basic check
                                   ->latest('admission_date') // or created_at
                                   ->take(5)
                                   ->get();

        return view('global_search.results', compact('enrolment', 'package', 'logRequests', 'recentVisits', 'query'));
    }
}
