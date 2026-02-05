<?php

namespace App\Http\Controllers;

use App\Models\PaMonitoring;
use App\Models\LogRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaMonitoringController extends Controller
{
    /**
     * Display a listing of monitoring logs.
     */
    public function index()
    {
        $logs = PaMonitoring::latest()->paginate(20);
        return view('monitoring.index', compact('logs'));
    }

    /**
     * Show the form for creating a new monitoring log.
     */
    public function create(Request $request)
    {
        $pa_code = $request->query('pa_code');
        $logRequest = null;
        
        if ($pa_code) {
            $logRequest = LogRequest::where('pa_code', $pa_code)->first();
        }

        return view('monitoring.create', compact('logRequest', 'pa_code'));
    }

    /**
     * Store a newly created monitoring log in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pa_code' => 'required|string|exists:log_requests,pa_code',
            'policy_no' => 'required|string',
            'full_name' => 'required|string',
            'phone_no' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'treatment_received' => 'nullable|string',
            'days_spent' => 'required|integer|min:0',
            'remarks' => 'nullable|string',
            'monitoring_status' => 'required|string',
            'file_upload' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120', // 5MB limit
        ]);

        if ($request->hasFile('file_upload')) {
            $path = $request->file('file_upload')->store('monitoring_docs', 'public');
            $validated['file_path'] = $path;
        }

        $monitoring = PaMonitoring::updateOrCreate(
            ['pa_code' => $validated['pa_code']],
            array_merge($validated, ['monitored_by' => auth()->id()])
        );

        return redirect()->route('monitoring.index')->with('success', 'Monitoring log updated successfully.');
    }

    /**
     * Display the specified monitoring log.
     */
    public function show($id)
    {
        $log = PaMonitoring::findOrFail($id);
        return view('monitoring.show', compact('log'));
    }

    /**
     * Show the form for editing the specified monitoring log.
     */
    public function edit($id)
    {
        $log = PaMonitoring::findOrFail($id);
        return view('monitoring.edit', compact('log'));
    }

    /**
     * Update the specified monitoring log in storage.
     */
    public function update(Request $request, $id)
    {
        $log = PaMonitoring::findOrFail($id);
        
        $validated = $request->validate([
            'diagnosis' => 'nullable|string',
            'treatment_received' => 'nullable|string',
            'days_spent' => 'required|integer|min:0',
            'remarks' => 'nullable|string',
            'monitoring_status' => 'required|string',
            'file_upload' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',
        ]);

        if ($request->hasFile('file_upload')) {
            // Delete old file if exists
            if ($log->file_path && Storage::disk('public')->exists($log->file_path)) {
                Storage::disk('public')->delete($log->file_path);
            }
            $path = $request->file('file_upload')->store('monitoring_docs', 'public');
            $validated['file_path'] = $path;
        }

        $log->update($validated);

        return redirect()->route('monitoring.index')->with('success', 'Monitoring log updated.');
    }

    /**
     * Remove the specified monitoring log from storage.
     */
    public function destroy($id)
    {
        $log = PaMonitoring::findOrFail($id);
        $log->delete();
        return redirect()->route('monitoring.index')->with('success', 'Monitoring log deleted.');
    }
}
