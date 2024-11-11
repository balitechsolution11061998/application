<?php

namespace App\Http\Controllers;

use App\Helpers\SystemUsageHelper;
use App\Models\OrdHead;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('orders.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    public function data(Request $request)
    {
        if ($request->ajax()) {
            try {
                // Start timing and memory tracking
                $startTime = microtime(true);
                $startMemory = memory_get_usage();

                // Initialize an empty array to hold the results
                $result = collect();

                // Use chunking to process records in smaller batches
                OrdHead::with(['ordsku']) // Eager load necessary relationships
                    ->leftJoin('store', 'ordhead.ship_to', '=', 'store.store') // Join store table
                    ->leftJoin('supplier', 'ordhead.supplier', '=', 'supplier.supp_code') // Join supplier table
                    ->select(
                        'ordhead.*',
                        'store.store as store',
                        'store.store_name as store_name',
                        'supplier.supp_code as supp_code',
                        'supplier.supp_name as supp_name',
                        'ordhead.not_after_date as expired_date',
                        'ordhead.approval_date as approval_date'
                    )
                    ->chunk(1000, function ($chunk) use ($result) { // Process 1000 records at a time
                        foreach ($chunk as $row) {
                            $result->push($row); // Add each row to the result collection
                        }
                    });

                // Prepare the data for DataTables
                $datatableResult = DataTables::of($result)
                    ->addColumn('action', function ($row) {
                        return '<button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px" data-kt-docs-datatable-subtable="expand_row">
                                    <span class="svg-icon fs-3 m-0 toggle-off">...</span>
                                    <span class="svg-icon fs-3 m-0 toggle-on">...</span>
                                </button>';
                    })
                    ->editColumn('total_cost', function ($row) {
                        return '$' . number_format($row->total_cost, 2);
                    })
                    ->editColumn('total_retail', function ($row) {
                        return '$' . number_format($row->total_retail, 2);
                    })
                    ->editColumn('supp_name', function ($row) {
                        return $row->supp_name ?? 'Not Found';
                    })
                    ->rawColumns(['status', 'action']) // Allow HTML rendering
                    ->make(true);

                // Log memory usage and load time using the helper function
                SystemUsageHelper::logUsage($startTime, $startMemory);

                // Return the result to DataTables
                return $datatableResult;

            } catch (\Exception $e) {
                return response()->json(['error' => 'An error occurred while fetching data. ' . $e->getMessage()], 500);
            }
        }
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
