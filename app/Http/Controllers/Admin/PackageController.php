<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = Package::latest()->get();
        return view('admin.packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.packages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'features' => 'required|array',
            'features.*' => 'string',
            'is_popular' => 'boolean',
        ]);

        $validated['features'] = json_encode($validated['features']);
        $validated['is_popular'] = $request->has('is_popular');

        Package::create($validated);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Paket pernikahan berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Package $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'features' => 'required|array',
            'features.*' => 'string',
            'is_popular' => 'boolean',
        ]);

        $validated['features'] = json_encode($validated['features']);
        $validated['is_popular'] = $request->has('is_popular');

        $package->update($validated);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Paket pernikahan berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->route('admin.packages.index')
            ->with('success', 'Paket pernikahan berhasil dihapus');
    }
}