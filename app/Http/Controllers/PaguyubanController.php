<?php

namespace App\Http\Controllers;

use App\Models\Paguyuban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PaguyubanController extends Controller
{
    public function index()
    {
        $paguyubans = Paguyuban::latest()->paginate(10);
        return view('paguyubans.index', compact('paguyubans'));
    }

    public function create()
    {
        return view('paguyubans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'boolean'
        ]);

        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $filename = Str::slug($request->name) . '-' . time() . '.' . $logo->getClientOriginalExtension();
            $path = $logo->storeAs('public/paguyubans', $filename);
            $data['logo'] = $filename;
        }

        $data['is_active'] = $request->has('is_active');

        Paguyuban::create($data);

        return redirect()->route('paguyubans.index')->with('success', 'Paguyuban created successfully.');
    }

    public function show(Paguyuban $paguyuban)
    {
        $paguyuban->load('products');
        return view('paguyubans.show', compact('paguyuban'));
    }

    public function edit(Paguyuban $paguyuban)
    {
        return view('paguyubans.edit', compact('paguyuban'));
    }

    public function update(Request $request, Paguyuban $paguyuban)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'boolean'
        ]);

        $data = $request->except('logo');

        // Handle logo update
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($paguyuban->logo) {
                Storage::delete('public/paguyubans/' . $paguyuban->logo);
            }
            
            $logo = $request->file('logo');
            $filename = Str::slug($request->name) . '-' . time() . '.' . $logo->getClientOriginalExtension();
            $path = $logo->storeAs('public/paguyubans', $filename);
            $data['logo'] = $filename;
        }

        $data['is_active'] = $request->has('is_active');

        $paguyuban->update($data);

        return redirect()->route('paguyubans.index')->with('success', 'Paguyuban updated successfully.');
    }

    public function destroy(Paguyuban $paguyuban)
    {
        // Delete logo if exists
        if ($paguyuban->logo) {
            Storage::delete('public/paguyubans/' . $paguyuban->logo);
        }

        $paguyuban->delete();

        return redirect()->route('paguyubans.index')->with('success', 'Paguyuban deleted successfully.');
    }

    public function toggleStatus(Paguyuban $paguyuban)
    {
        $paguyuban->update(['is_active' => !$paguyuban->is_active]);
        return back()->with('success', 'Paguyuban status updated successfully.');
    }
}