<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = Package::all();
        return view('packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('packages.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_name' => 'required|string|max:255',
            'package_description' => 'required|string',
            'package_code' => 'required|string|max:100|unique:packages,package_code',
            'package_price' => 'required|numeric',
            'package_limit' => 'required|numeric',


        ]);

        Package::create($validated);

        return redirect()->route('packages.index')->with('success', 'Package created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Package $package)
    {
        return view('packages.show', compact('package'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Package $package)
    {
        return view('packages.edit', compact('package'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'package_name' => 'required|string|max:255',
            'package_description' => 'required|string',
            'package_code' => 'required|string|max:100|unique:packages,package_code,' . $package->id,
            'package_price' => 'required|numeric',
            'package_limit' => 'required|numeric',
        ]);

        $package->update($validated);

        return redirect()->route('packages.index')->with('success', 'Package updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        $package->delete();

        return redirect()->route('packages.index')->with('success', 'Package deleted successfully.');

    }
}
