<?php

namespace App\Http\Controllers;

use App\Models\Paguyuban;
use App\Models\Product;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\DB;

class PaguyubanPricingController extends Controller
{
    public function store(Request $request, Paguyuban $paguyuban)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric|min:0',
            'effective_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|after_or_equal:effective_date'
        ]);

        DB::beginTransaction();
        try {
            // Check for existing pricing
            if ($paguyuban->products()->where('product_id', $request->product_id)->exists()) {
                activity()
                    ->causedBy(auth()->user())
                    ->performedOn($paguyuban)
                    ->withProperties([
                        'product_id' => $request->product_id,
                        'attempted_price' => $request->price
                    ])
                    ->log('Duplicate pricing attempt');

                return back()->with('error', 'This product already has special pricing for this community.');
            }

            $product = Product::findOrFail($request->product_id);

            // Attach with all pivot data
            $paguyuban->products()->attach($request->product_id, [
                'price' => $request->price,
                'effective_date' => $request->effective_date,
                'expiry_date' => $request->expiry_date
            ]);

            // Log activity
            activity()
                ->causedBy(auth()->user())
                ->performedOn($paguyuban)
                ->withProperties([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'regular_price' => $product->price,
                    'special_price' => $request->price,
                    'effective_date' => $request->effective_date,
                    'expiry_date' => $request->expiry_date,
                    'discount_percentage' => $this->calculateDiscountPercentage($product->price, $request->price)
                ])
                ->log('Added special pricing');

            DB::commit();
            return redirect()->route('pos.community.show', $paguyuban)
                ->with('success', 'Special pricing added successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            activity()
                ->causedBy(auth()->user())
                ->performedOn($paguyuban)
                ->withProperties([
                    'error' => $e->getMessage(),
                    'product_id' => $request->product_id ?? null,
                    'price' => $request->price ?? null
                ])
                ->log('Pricing addition error');

            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Paguyuban $paguyuban, Product $product)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
            'effective_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|after_or_equal:effective_date'
        ]);

        DB::beginTransaction();
        try {
            $pivotData = $paguyuban->products()
                ->where('product_id', $product->id)
                ->first()->pivot;

            $oldPrice = $pivotData->price;
            $oldEffectiveDate = $pivotData->effective_date;
            $oldExpiryDate = $pivotData->expiry_date;

            // Update pivot data
            $paguyuban->products()->updateExistingPivot($product->id, [
                'price' => $request->price,
                'effective_date' => $request->effective_date,
                'expiry_date' => $request->expiry_date
            ]);

            // Log activity
            activity()
                ->causedBy(auth()->user())
                ->performedOn($paguyuban)
                ->withProperties([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'old_price' => $oldPrice,
                    'new_price' => $request->price,
                    'old_effective_date' => $oldEffectiveDate,
                    'new_effective_date' => $request->effective_date,
                    'old_expiry_date' => $oldExpiryDate,
                    'new_expiry_date' => $request->expiry_date,
                    'regular_price' => $product->price,
                    'price_change' => $request->price - $oldPrice,
                    'change_percentage' => $this->calculateDiscountPercentage($oldPrice, $request->price)
                ])
                ->log('Updated special pricing');

            DB::commit();
            return redirect()->route('pos.community.show', $paguyuban)
                ->with('success', 'Special pricing updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            activity()
                ->causedBy(auth()->user())
                ->performedOn($paguyuban)
                ->withProperties([
                    'error' => $e->getMessage(),
                    'product_id' => $product->id,
                    'price' => $request->price ?? null
                ])
                ->log('Pricing update error');

            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy(Paguyuban $paguyuban, Product $product)
    {
        DB::beginTransaction();
        try {
            $pivotData = $paguyuban->products()
                ->where('product_id', $product->id)
                ->first()->pivot;

            $oldPrice = $pivotData->price;
            $effectiveDate = $pivotData->effective_date;
            $expiryDate = $pivotData->expiry_date;

            $paguyuban->products()->detach($product->id);

            // Log activity
            activity()
                ->causedBy(auth()->user())
                ->performedOn($paguyuban)
                ->withProperties([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'removed_price' => $oldPrice,
                    'effective_date' => $effectiveDate,
                    'expiry_date' => $expiryDate,
                    'regular_price' => $product->price
                ])
                ->log('Removed special pricing');

            DB::commit();
            return redirect()->route('pos.community.show', $paguyuban)
                ->with('success', 'Special pricing removed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            activity()
                ->causedBy(auth()->user())
                ->performedOn($paguyuban)
                ->withProperties([
                    'error' => $e->getMessage(),
                    'product_id' => $product->id
                ])
                ->log('Pricing removal error');

            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function activityLog(Paguyuban $paguyuban)
    {
        $activities = Activity::where(function ($query) use ($paguyuban) {
            $query->where('subject_type', Paguyuban::class)
                ->where('subject_id', $paguyuban->id);
        })
            ->orWhere(function ($query) use ($paguyuban) {
                $query->where('subject_type', Product::class)
                    ->whereJsonContains('properties->paguyuban_id', $paguyuban->id);
            })
            ->with(['causer', 'subject'])
            ->latest()
            ->paginate(10);

        return response()->json([
            'paguyuban' => $paguyuban,
            'activities' => $activities
        ]);
    }

    public function batchUpdate(Request $request, Paguyuban $paguyuban)
    {
        dd($request->all());
        $request->validate([
            'updates' => 'required|array',
            'updates.*.product_id' => 'required|exists:products,id',
            'updates.*.price' => 'required|numeric|min:0',
            'updates.*.effective_date' => 'nullable|date',
            'updates.*.expiry_date' => 'nullable|date|after_or_equal:updates.*.effective_date'
        ]);
    
        DB::beginTransaction();
        try {
            $updatedCount = 0;
            $addedCount = 0;
            $productDetails = [];
            
            // Preload all products to minimize queries
            $products = Product::whereIn('id', collect($request->updates)->pluck('product_id'))
                ->get()
                ->keyBy('id');
    
            foreach ($request->updates as $update) {
                $product = $products[$update['product_id']] ?? null;
                if (!$product) continue;
    
                $isNew = !$paguyuban->products()->where('product_id', $update['product_id'])->exists();
                
                if ($isNew) {
                    // Add new pricing
                    $paguyuban->products()->attach($update['product_id'], [
                        'price' => $update['price'],
                        'effective_date' => $update['effective_date'],
                        'expiry_date' => $update['expiry_date']
                    ]);
                    $addedCount++;
                } else {
                    // Update existing pricing
                    $paguyuban->products()->updateExistingPivot($update['product_id'], [
                        'price' => $update['price'],
                        'effective_date' => $update['effective_date'],
                        'expiry_date' => $update['expiry_date']
                    ]);
                    $updatedCount++;
                }
    
                // Collect details for activity log
                $productDetails[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'regular_price' => $product->price,
                    'special_price' => $update['price'],
                    'effective_date' => $update['effective_date'],
                    'expiry_date' => $update['expiry_date'],
                    'action' => $isNew ? 'added' : 'updated'
                ];
            }
    
            // Log detailed batch activity
            activity()
                ->causedBy(auth()->user())
                ->performedOn($paguyuban)
                ->withProperties([
                    'added_count' => $addedCount,
                    'updated_count' => $updatedCount,
                    'total_processed' => count($request->updates),
                    'products' => $productDetails,
                    'discount_summary' => $this->calculateBatchDiscountSummary($productDetails)
                ])
                ->log('Batch updated special pricing');
    
            DB::commit();
            
            return response()->json([
                'success' => true,
                'added_count' => $addedCount,
                'updated_count' => $updatedCount,
                'message' => sprintf(
                    'Batch update completed: %d added, %d updated',
                    $addedCount,
                    $updatedCount
                )
            ]);
    
        } catch (\Exception $e) {
            DB::rollBack();
            
            activity()
                ->causedBy(auth()->user())
                ->performedOn($paguyuban)
                ->withProperties([
                    'error' => $e->getMessage(),
                    'updates' => $request->updates
                ])
                ->log('Batch pricing update error');
    
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during batch update: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Calculate summary statistics for the batch update
     */
    private function calculateBatchDiscountSummary(array $productDetails)
    {
        $totalRegular = 0;
        $totalSpecial = 0;
        $count = 0;
        
        foreach ($productDetails as $product) {
            $totalRegular += $product['regular_price'];
            $totalSpecial += $product['special_price'];
            $count++;
        }
        
        return [
            'average_discount' => $count > 0 ? round((($totalRegular - $totalSpecial) / $totalRegular * 100), 2) : 0,
            'total_savings' => $totalRegular - $totalSpecial,
            'product_count' => $count
        ];
    }

    /**
     * Calculate discount percentage
     */
    private function calculateDiscountPercentage($regularPrice, $specialPrice)
    {
        if ($regularPrice <= 0) return 0;
        return round((($regularPrice - $specialPrice) / $regularPrice * 100), 2);
    }
}
