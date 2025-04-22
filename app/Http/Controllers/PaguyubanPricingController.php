<?php

namespace App\Http\Controllers;

use App\Models\Paguyuban;
use App\Models\Product;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class PaguyubanPricingController extends Controller
{
    public function store(Request $request, Paguyuban $paguyuban)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric|min:0'
        ]);

        // Check if pricing already exists
        if ($paguyuban->products()->where('product_id', $request->product_id)->exists()) {
            activity()
                ->causedBy(auth()->user())
                ->performedOn($paguyuban)
                ->withProperties([
                    'product_id' => $request->product_id,
                    'attempted_price' => $request->price
                ])
                ->log('Failed to add special pricing - product already exists');

            return back()->with('error', 'This product already has special pricing for this community.');
        }

        $product = Product::find($request->product_id);
        
        $paguyuban->products()->attach($request->product_id, ['price' => $request->price]);

        // Log the activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($paguyuban)
            ->withProperties([
                'product_id' => $product->id,
                'product_name' => $product->name,
                'regular_price' => $product->price,
                'special_price' => $request->price,
                'discount_percentage' => round((($product->price - $request->price) / $product->price) * 100, 2)
            ])
            ->log('Added special pricing for product');

        return redirect()->route('pos.community.show', $paguyuban)
            ->with('success', 'Special pricing added successfully!');
    }

    public function update(Request $request, Paguyuban $paguyuban, Product $product)
    {
        $request->validate([
            'price' => 'required|numeric|min:0'
        ]);

        // Get old price before update
        $oldPrice = $paguyuban->products()->where('product_id', $product->id)->first()->pivot->price;

        // Update the pivot table
        $paguyuban->products()->updateExistingPivot($product->id, ['price' => $request->price]);

        // Log the activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($paguyuban)
            ->withProperties([
                'product_id' => $product->id,
                'product_name' => $product->name,
                'old_price' => $oldPrice,
                'new_price' => $request->price,
                'price_change' => $request->price - $oldPrice,
                'regular_price' => $product->price,
                'change_percentage' => round((($request->price - $oldPrice) / $oldPrice) * 100, 2)
            ])
            ->log('Updated special pricing for product');

        return redirect()->route('pos.community.show', $paguyuban)
            ->with('success', 'Special pricing updated successfully!');
    }

    public function destroy(Paguyuban $paguyuban, Product $product)
    {
        // Get the price before detaching
        $oldPrice = $paguyuban->products()->where('product_id', $product->id)->first()->pivot->price;

        $paguyuban->products()->detach($product->id);

        // Log the activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($paguyuban)
            ->withProperties([
                'product_id' => $product->id,
                'product_name' => $product->name,
                'removed_price' => $oldPrice,
                'regular_price' => $product->price
            ])
            ->log('Removed special pricing for product');

        return redirect()->route('pos.community.show', $paguyuban)
            ->with('success', 'Special pricing removed successfully!');
    }

    public function activityLog(Paguyuban $paguyuban)
    {
        $activities = Activity::where('subject_type', Paguyuban::class)
            ->where('subject_id', $paguyuban->id)
            ->orWhere(function($query) use ($paguyuban) {
                $query->where('subject_type', Product::class)
                    ->where('properties->paguyuban_id', $paguyuban->id);
            })
            ->with(['causer', 'subject'])
            ->latest()
            ->paginate(10);
    
        // Return JSON response
        return response()->json([
            'paguyuban' => $paguyuban,
            'activities' => $activities
        ]);
    }
    
}