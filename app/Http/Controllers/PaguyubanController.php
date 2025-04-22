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
        $paguyubans = Paguyuban::orderBy('name')->paginate(10);
        return view('paguyuban.index', compact('paguyubans'));
    }

    public function create()
    {
        return view('paguyuban.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        $data = $request->except('logo');
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('logo')) {
            $filename = 'paguyuban-'.Str::slug($request->name).'-'.time().'.'.$request->logo->extension();
            $path = $request->logo->storeAs('paguyubans', $filename, 'public');
            $data['logo'] = $path;
        }

        Paguyuban::create($data);

        return redirect()->route('pos.community.index')
            ->with('success', 'Paguyuban created successfully!');
    }

    public function show(Paguyuban $paguyuban)
    {
        return view('paguyuban.show', compact('paguyuban'));
    }

    public function edit(Paguyuban $paguyuban)
    {
        return view('paguyuban.edit', compact('paguyuban'));
    }

    public function update(Request $request, Paguyuban $paguyuban)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        $data = $request->except('logo');
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($paguyuban->logo) {
                Storage::disk('public')->delete($paguyuban->logo);
            }
            
            $filename = 'paguyuban-'.Str::slug($request->name).'-'.time().'.'.$request->logo->extension();
            $path = $request->logo->storeAs('paguyubans', $filename, 'public');
            $data['logo'] = $path;
        }

        $paguyuban->update($data);

        return redirect()->route('pos.community.index')
            ->with('success', 'Paguyuban updated successfully!');
    }

    public function destroy(Paguyuban $paguyuban)
    {
        if ($paguyuban->logo) {
            Storage::disk('public')->delete($paguyuban->logo);
        }

        $paguyuban->delete();

        return redirect()->route('pos.community.index')
            ->with('success', 'Paguyuban deleted successfully!');
    }
}