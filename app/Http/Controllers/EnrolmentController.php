<?php

namespace App\Http\Controllers;

use App\Models\Enrolment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EnrolmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $enrolments = Enrolment::when($search, function ($query, $search) {
            return $query->where('full_name', 'like', "%{$search}%")
                         ->orWhere('policy_no', 'like', "%{$search}%");
        })->get();

        return view('enrolments.index', compact('enrolments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $packages = \App\Models\Package::all();
        $hcps = \App\Models\Hcp_hospitals::all();
        return view('enrolments.create', compact('packages', 'hcps'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'organization_name' => 'required|string',
            'full_name' => 'required|string',
            'dob' => 'required|date',
            'phone_no' => 'required|string',
            'email' => 'required|email|unique:enrolments,email',
            'address' => 'required|string',
            'location' => 'required|string',
            'package_code' => 'required|string',
            'package_description' => 'required|string',
            'package_price' => 'required|numeric',
            'package_limit' => 'required|numeric',
            'pry_hcp' => 'required|string',
            'photograph' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            // Dependants validation
            'dependants_1_name' => 'nullable|string',
            'dependants_1_dob' => 'nullable|date',
            'dependants_1_status' => 'nullable|string',
            'dependants_1_photograph' => 'nullable|image|max:2048',
            'dependants_2_name' => 'nullable|string',
            'dependants_2_dob' => 'nullable|date',
            'dependants_2_status' => 'nullable|string',
            'dependants_2_photograph' => 'nullable|image|max:2048',
            'dependants_3_name' => 'nullable|string',
            'dependants_3_dob' => 'nullable|date',
            'dependants_3_status' => 'nullable|string',
            'dependants_3_photograph' => 'nullable|image|max:2048',
            'dependants_4_name' => 'nullable|string',
            'dependants_4_dob' => 'nullable|date',
            'dependants_4_status' => 'nullable|string',
            'dependants_4_photograph' => 'nullable|image|max:2048',
        ]);

        $month = date('m');
        $year = date('Y');
        $random_no = rand(100000, 999999);
        $policy_no = $validatedData['package_code'] . '/' . $month . '/' . $year . '/' . $random_no;

        $enrolment = new Enrolment();
        $enrolment->fill(collect($validatedData)->except(['photograph', 'dependants_1_photograph', 'dependants_2_photograph', 'dependants_3_photograph', 'dependants_4_photograph'])->toArray());
        $enrolment->policy_no = $policy_no;

        // Handle File Uploads
        $this->handleFileUploads($request, $enrolment);

        $enrolment->save();

        return redirect()->route('enrolments.index')->with('success', 'Enrolment created successfully! Policy: ' . $policy_no);
    }

    /**
     * Display the specified resource.
     */
    public function show(Enrolment $enrolment)
    {
        return view('enrolments.show', compact('enrolment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enrolment $enrolment)
    {
        $hcps = \App\Models\Hcp_hospitals::all();
        $packages = \App\Models\Package::all();
        return view('enrolments.edit', compact('enrolment', 'packages', 'hcps'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Enrolment $enrolment)
    {
        $request->validate([
            'full_name' => 'required|string',
            'dob' => 'required|date',
            'phone_no' => 'required|string',
            'email' => 'required|email|unique:enrolments,email,' . $enrolment->id,
            'address' => 'required|string',
            'location' => 'required|string',
            'photograph' => 'nullable|image|max:2048',
            'dependants_1_name' => 'nullable|string',
            'dependants_1_dob' => 'nullable|date',
            'dependants_1_status' => 'nullable|string',
            'dependants_1_photograph' => 'nullable|image|max:2048',
            'dependants_2_name' => 'nullable|string',
            'dependants_2_dob' => 'nullable|date',
            'dependants_2_status' => 'nullable|string',
            'dependants_2_photograph' => 'nullable|image|max:2048',
            'dependants_3_name' => 'nullable|string',
            'dependants_3_dob' => 'nullable|date',
            'dependants_3_status' => 'nullable|string',
            'dependants_3_photograph' => 'nullable|image|max:2048',
            'dependants_4_name' => 'nullable|string',
            'dependants_4_dob' => 'nullable|date',
            'dependants_4_status' => 'nullable|string',
            'dependants_4_photograph' => 'nullable|image|max:2048',
        ]);

        $enrolment->fill($request->except(['photograph', 'dependants_1_photograph', 'dependants_2_photograph', 'dependants_3_photograph', 'dependants_4_photograph']));
        
        $this->handleFileUploads($request, $enrolment);

        $enrolment->save();
        return redirect()->route('enrolments.index')->with('success', 'Enrolment updated successfully!');
    }

    /**
     * Helper to handle file uploads for principal and dependants.
     */
    private function handleFileUploads(Request $request, Enrolment $enrolment)
    {
        // Principal
        if ($request->hasFile('photograph')) {
            $enrolment->photograph = $request->file('photograph')->store('enrolments', 'public');
        }

        // Dependants 1-4
        for ($i = 1; $i <= 4; $i++) {
            $field = "dependants_{$i}_photograph";
            if ($request->hasFile($field)) {
                $enrolment->$field = $request->file($field)->store('enrolments', 'public');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enrolment $enrolment)
    {
        $enrolment->delete();
        return redirect()->route('enrolments.index')->with('success', 'Enrolment deleted successfully!');
    }

    /**
     * Handles autofill logRequest form after typing policy_no.
     * This method is called via API (fetch) from the Blade view.
     */
    public function getDetailsByPolicy($policy_no)
    {
        $enrolment = \App\Models\Enrolment::where('policy_no', $policy_no)->first();

        if (!$enrolment) {
            return response()->json(['message' => 'Member not found'], 404);
        }

        return response()->json([
            'full_name'     => $enrolment->full_name,
            'email'         => $enrolment->email,
            'phone_no'      => $enrolment->phone_no,
            // Put the formatted date here:
            'dob'           => \Carbon\Carbon::parse($enrolment->dob)->format('Y-m-d'),
            'package_code'  => $enrolment->package_code,
            'package_price' => $enrolment->package_price,
            'package_limit' => $enrolment->package_limit,
            'pry_hcp'       => $enrolment->pry_hcp,
            'sec_hcp'       => $enrolment->sec_hcp ?? null,
            'utilization_rate' => $enrolment->utilization_rate,
        ]);
    }

    public function idCard(Enrolment $enrolment)
    {
        return view('enrolments.id-card', compact('enrolment'));
    }
}
