<?php

namespace App\Http\Controllers;

use App\Models\Paguyuban;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            $filename = 'paguyuban-' . Str::slug($request->name) . '-' . time() . '.' . $request->logo->extension();
            $path = $request->logo->storeAs('paguyubans', $filename, 'public');
            $data['logo'] = $path;
        }

        Paguyuban::create($data);

        return redirect()->route('pos.community.index')
            ->with('success', 'Paguyuban created successfully!');
    }

    // In your PaguyubanController or relevant controller
    public function show(Paguyuban $paguyuban)
    {
        // Get products not already associated with this paguyuban
        $availableProducts = Product::whereDoesntHave('paguyubans', function ($query) use ($paguyuban) {
            $query->where('paguyuban_id', $paguyuban->id);
        })->get();

        return view('paguyuban.show', compact('paguyuban', 'availableProducts'));
    }

    public function addPricing(Request $request, Paguyuban $paguyuban)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric|min:0'
        ]);

        // Check if this product already has pricing for this paguyuban
        if ($paguyuban->products()->where('product_id', $request->product_id)->exists()) {
            return back()->with('error', 'This product already has special pricing for this community.');
        }

        // Attach the product with special price
        $paguyuban->products()->attach($request->product_id, [
            'price' => $request->price
        ]);

        return redirect()->route('pos.community.show', $paguyuban)
            ->with('success', 'Special pricing added successfully!');
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

            $filename = 'paguyuban-' . Str::slug($request->name) . '-' . time() . '.' . $request->logo->extension();
            $path = $request->logo->storeAs('paguyubans', $filename, 'public');
            $data['logo'] = $path;
        }

        $paguyuban->update($data);

        return redirect()->route('pos.community.index')
            ->with('success', 'Paguyuban updated successfully!');
    }

    // In your controller's destroy method
    public function destroy(Paguyuban $paguyuban)
    {
        DB::transaction(function () use ($paguyuban) {
            // First delete all related products
            $paguyuban->products()->detach();

            // Then delete the paguyuban
            $paguyuban->delete();
        });

        return redirect()->route('pos.community.index')
            ->with('success', 'Paguyuban deleted successfully');
    }
}
