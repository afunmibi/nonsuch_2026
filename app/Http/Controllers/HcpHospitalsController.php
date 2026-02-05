<?php 
namespace App\Http\Controllers;

use App\Models\Hcp_hospitals;
use Illuminate\Http\Request;

class HcpHospitalsController extends Controller
{
    public function index()
    {
        $hcps = Hcp_hospitals::latest()->paginate(10); 
    return view('hcps.index', compact('hcps'));
    }

    public function create()
    {
        return view('hcps.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hcp_name' => 'required|string|max:255',
            // IMPORTANT: Ensure 'hcp_code' is the actual column name in your DB table
            'hcp_code' => 'required|string|max:100|unique:hcp_hospitals,hcp_code',
            'hcp_location' => 'required|string|max:255',
            'hcp_contact' => 'required|string|max:20',
            'hcp_email' => 'required|string|email|max:255|unique:hcp_hospitals,hcp_email',
            'hcp_account_number' => 'required|string|max:50|unique:hcp_hospitals,hcp_account_number',
            'hcp_account_name' => 'required|string|max:255',
            'hcp_bank_name' => 'required|string|max:255',
            'hcp_accreditation_status' => 'required|string|max:100',
        ]);

        Hcp_hospitals::create($validated);
        return redirect()->route('hcps.index')->with('success', 'HCP Hospital created successfully.');
    }

   
    public function show(Hcp_hospitals $hcp)
{

    return view('hcps.show', compact('hcp'));
}

public function edit(Hcp_hospitals $hcp)
{
    // Pass it as 'hcp' so $hcp exists in your Blade file
    return view('hcps.edit', compact('hcp'));
}

public function update(Request $request, Hcp_hospitals $hcp)
{
    $validated = $request->validate([
        'hcp_name' => 'required|string|max:255',
        'hcp_code' => 'required|string|max:100|unique:hcp_hospitals,hcp_code,'.$hcp->id,
        'hcp_location' => 'required|string|max:255',
        'hcp_contact' => 'required|string|max:20',
        'hcp_email' => 'required|string|email|max:255|unique:hcp_hospitals,hcp_email,'.$hcp->id,
        'hcp_account_number' => 'required|string|max:50|unique:hcp_hospitals,hcp_account_number,'.$hcp->id,
        'hcp_account_name' => 'required|string|max:255',
        'hcp_bank_name' => 'required|string|max:255',
        'hcp_accreditation_status' => 'required|string|max:100',
    ]);

    // 1. Save the changes to the database
    $hcp->update($validated);

    // 2. Redirect back to the list with a success message
    return redirect()->route('hcps.index')
                     ->with('success', 'HCP Hospital updated successfully.');
}

    public function destroy(Hcp_hospitals $hcp)
    {
        $hcp->delete();
        return redirect()->route('hcps.index')->with('success', 'HCP Hospital deleted successfully.');
    }
}