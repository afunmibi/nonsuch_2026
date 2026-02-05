<?php

namespace App\Http\Controllers;

use App\Models\HcpBillUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HcpUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        
        // If user is linked to a specific hospital, show all bills for that hospital
        if ($user->hcp_id) {
            $uploads = HcpBillUpload::where('hcp_id', $user->hcp_id)
                ->latest()
                ->paginate(10);
        } else {
            // Fallback for independent users or old records
            $uploads = HcpBillUpload::where('user_id', $user->id)
                ->latest()
                ->paginate(10);
        }
            
        return view('hcp-uploads.index', compact('uploads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hcp-uploads.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'hcp_name' => 'required|string',
            'hcp_code' => 'nullable|string',
            'billing_month' => 'required|string', // Consider format validation like Y-m or Month Year
            'hmo_officer' => 'nullable|string',
            'amount_claimed' => 'required|numeric',
            'file_path' => 'required|file|mimes:pdf,jpeg,png,jpg,xls,xlsx,csv|max:10240', // 10MB max, allow docs/images
            'remarks' => 'nullable|string',
        ]);

        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $extension = $file->getClientOriginalExtension();
            
            // Create a clean filename: HospitalName_MonthYear.ext
            $safeHospitalName = str_replace(' ', '_', preg_replace('/[^A-Za-z0-9 ]/', '', $request->hcp_name));
            $safeMonth = str_replace(' ', '_', preg_replace('/[^A-Za-z0-9 ]/', '', $request->billing_month));
            
            $filename = $safeHospitalName . '_' . $safeMonth . '_' . time() . '.' . $extension;
            
            $path = $file->storeAs('hcp_bills', $filename, 'public');
            $validated['file_path'] = $path;
        }

        $validated['user_id'] = auth()->id();
        $validated['hcp_id'] = auth()->user()->hcp_id;
        $validated['status'] = 'Pending';

        HcpBillUpload::create($validated);

        return redirect()->route('hcp.dashboard')->with('success', 'Bill uploaded successfully.');
    }

    /**
     * Display a listing for administrative oversight.
     */
    public function adminIndex()
    {
        $uploads = HcpBillUpload::with('user')->latest()->paginate(15);
        return view('hcp-uploads.admin-index', compact('uploads'));
    }

    /**
     * Download the uploaded bill file.
     */
    public function download(HcpBillUpload $upload)
    {
        // Security: Only internal staff or the owner can download
        $isInternal = in_array(auth()->user()->role, ['admin', 'gm', 'md', 'cm', 'ud', 'staff', 'it', 'accounts']);
        $isOwner = $upload->user_id === auth()->id() || (auth()->user()->hcp_id && $upload->hcp_id === auth()->user()->hcp_id);

        if (!$isInternal && !$isOwner) {
            abort(403);
        }

        if (!Storage::disk('public')->exists($upload->file_path)) {
            return back()->with('error', 'File not found on server.');
        }

        return Storage::disk('public')->download($upload->file_path);
    }

    /**
     * Display the specified resource.
     */
    public function show(HcpBillUpload $hcp_upload)
    {
        $hcpBillUpload = $hcp_upload;
        // Allow internal roles or the owner
        $isInternal = in_array(auth()->user()->role, ['admin', 'gm', 'md', 'cm', 'ud', 'staff', 'it', 'accounts']);
        $isOwner = $hcpBillUpload->user_id === auth()->id() || (auth()->user()->hcp_id && $hcpBillUpload->hcp_id === auth()->user()->hcp_id);

        if (!$isInternal && !$isOwner) {
            abort(403);
        }
        
        return view('hcp-uploads.show', compact('hcpBillUpload'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HcpBillUpload $hcp_upload)
    {
        $hcpBillUpload = $hcp_upload;
        // Only Admin or the uploader can delete
        if (auth()->user()->role !== 'admin' && $hcpBillUpload->user_id !== auth()->id()) {
            abort(403);
        }
        
        if(Storage::disk('public')->exists($hcpBillUpload->file_path)){
             Storage::disk('public')->delete($hcpBillUpload->file_path);
        }

        $hcpBillUpload->delete();

        return back()->with('success', 'Upload record deleted.');
    }
}
