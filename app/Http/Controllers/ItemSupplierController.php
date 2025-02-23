<?php

namespace App\Http\Controllers;

use App\Models\ItemSupplier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ItemSupplierController extends Controller
{
    public function index()
    {
        return view('item-supplier.index');
    }
    public function store(Request $request)
    {
        // Uncomment the line below for debugging
        // dd($request->all());

        try {
            $startTime = microtime(true);
            $datas = $request->all(); // Get all data from the request
            // Log the total number of items received

            // Process the data without chunking
            foreach ($datas as $data) {
                // Log each item being processed

                // Create or update the item supplier using Eloquent
                $itemSupplier = ItemSupplier::updateOrCreate(
                    [
                        'supplier' => $data['supplier'],
                        'sku' => $data['sku'],
                        'upc' => $data['upc'],
                    ],
                    [
                        'sup_name' => $data['sup_name'],
                        'sku_desc' => $data['sku_desc'],
                        'unit_cost' => $data['unit_cost'],
                        'create_id' => $data['create_id'],
                        'create_date' => $data['create_date'],
                        'last_update_id' => $data['last_update_id'],
                        'last_update_date' => $data['last_update_date'],
                        'vat_ind' => $data['vat_ind'],
                    ]
                );

                // Log the activity based on whether it was created or updated
                if ($itemSupplier->wasRecentlyCreated) {
                    activity()
                        ->performedOn($itemSupplier)
                        ->log('Inserted new item supplier: ' . $data['sku']);
                } else {
                    activity()
                        ->performedOn($itemSupplier)
                        ->log('Updated item supplier: ' . $data['sku']);
                }
            }

            return response()->json([
                'message' => 'Sukses insert item supplier',
                'success' => true,
            ]);
        } catch (\Throwable $th) {
            // Log the error activity
            \Log::error('Failed to insert item supplier: ' . $th->getMessage());

            return response()->json([
                'message' => 'Gagal insert item supplier: ' . $th->getMessage(),
                'success' => false,
            ]);
        }
    }


    public function data()
    {
        $query = ItemSupplier::select('supplier', 'sup_name', 'sku', 'sku_desc', 'upc', 'unit_cost', 'create_date', 'last_update_date','vat_ind');

        return DataTables::of($query)
            ->addIndexColumn()
            ->make(true);
    }
    public function selectData(Request $request): JsonResponse
    {
        try {
            // Get the search query from the request
            $searchQuery = $request->input('search', '');

            // Fetching data from the ItemSupplier model with filtering
            $query = ItemSupplier::select('supplier', 'sup_name', 'sku', 'sku_desc', 'upc', 'unit_cost', 'create_date', 'last_update_date', 'vat_ind')
                ->where(function($q) use ($searchQuery) {
                    $q->where('sku', 'LIKE', '%' . $searchQuery . '%')
                      ->orWhere('upc', 'LIKE', '%' . $searchQuery . '%');
                })
                ->get();

            // Return the data as a JSON response
            return response()->json($query);
        } catch (\Exception $e) {
            // Return a JSON response with an error message
            return response()->json([
                'error' => 'Unable to fetch data. Please try again later.'
            ], 500);
        }
    }

}
