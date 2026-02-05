<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use Illuminate\Http\Request;

class DiagnosisController extends Controller
{
    public function index()
    {
        $diagnoses = Diagnosis::latest()->paginate(10);
        return view('diagnoses.index', compact('diagnoses'));
    }

    public function create()
    {
        return view('diagnoses.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'diag_code'      => 'required|string|unique:diagnosis,diag_code',
            'diagnosis'      => 'required|string|max:255',
            'treatment_plan' => 'required|string',
            'cost'           => 'required|numeric|min:0',
        ]);

        Diagnosis::create($data);

        return redirect()->route('diagnoses.index')->with('success', 'Diagnosis added successfully!');
    }

    public function edit($id)
    {
        $diagnosis = Diagnosis::findOrFail($id);
        $diagnoses = Diagnosis::latest()->paginate(10);
        return view('diagnoses.index', compact('diagnosis', 'diagnoses'));
    }

    public function update(Request $request, $id)
    {
        $diagnosis = Diagnosis::findOrFail($id);
        
        $data = $request->validate([
            'diag_code'      => 'required|string|unique:diagnosis,diag_code,' . $id,
            'diagnosis'      => 'required|string|max:255',
            'treatment_plan' => 'required|string',
            'cost'           => 'required|numeric|min:0',
        ]);

        $diagnosis->update($data);

        return redirect()->route('diagnoses.index')->with('success', 'Diagnosis updated successfully!');
    }

    public function destroy($id)
    {
        Diagnosis::findOrFail($id)->delete();
        return redirect()->route('diagnoses.index')->with('success', 'Diagnosis deleted successfully!');
    }
}
