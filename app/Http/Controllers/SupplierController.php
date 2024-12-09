<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Activitylog\Facades\Activity; // Import the Activity facade

class SupplierController extends Controller
{
    //
    public function index()
    {
        return view('supplier.index');
    }
    //
    public function store(Request $request)
    {
        $data = $request->data;
        $response = [];
        $overallStatus = true; // Initialize overall status

        try {
            foreach ($data as $key => $value) {
                // Check if the supplier already exists
                $cekDataSupplier = DB::table('supplier')->where('supp_code', $value['supp_code'])->first();

                // Prepare the data to be inserted/updated
                $dataInsert = [
                    'supp_name' => $value['supp_name'],
                    'terms' => $value['terms'],
                    'contact_name' => $value['contact_name'],
                    'contact_phone' => $value['contact_phone'],
                    'contact_fax' => $value['contact_fax'],
                    'address_1' => $value['address_1'],
                    'address_2' => $value['address_2'],
                    'city' => $value['city'],
                    'tax_ind' => $value['tax_ind'],
                    'consig_ind' => $value['consig_ind'],
                    'status' => $value['status'],
                ];

                // Handle optional fields
                $dataInsert['post_code'] = ($value['post_code'] != '-----') ? $value['post_code'] : null;
                $dataInsert['tax_no'] = (!empty($value['collect_tax_no'])) ? $value['collect_tax_no'] : "N";

                if ($cekDataSupplier != null) {
                    // Update existing supplier
                    DB::table('supplier')
                        ->where('id', $cekDataSupplier->id)
                        ->update($dataInsert);

                    // Log the update activity with user context
                    activity()
                        ->causedBy($request->user()) // Log the user who caused the action
                        ->log('Updated supplier: ' . $value['supp_code']); // Log the update message

                    $response[] = [
                        'message' => 'Supplier berhasil diperbaharui',
                    ];
                } else {
                    // Insert new supplier
                    $dataInsert['supp_code'] = $value['supp_code']; // Only set supp_code for new records
                    DB::table('supplier')->insert($dataInsert);

                    // Log the insert activity with user context
                    activity()
                        ->causedBy($request->user()) // Log the user who caused the action
                        ->log('Added new supplier: ' . $value['supp_code']); // Log the insert message

                    $response[] = [
                        'message' => 'Sukses menambahkan supplier',
                    ];
                }
            }
        } catch (\Exception $e) {
            // Log the error with user context
            activity()
                ->causedBy($request->user()) // Log the user who caused the error
                ->log('Error processing supplier data: ' . $e->getMessage()); // Log the error message

            // Set overall status to false
            $overallStatus = false;

            // Return an error response with the error message
            $response[] = [
                'message' => 'Error processing supplier data: ' . $e->getMessage(),
            ];
        }

        return response()->json([
            'status' => $overallStatus, // Return overall status
            'data' => $response // Return the response messages
        ]);
    }




    public function selectData(): JsonResponse
    {
        try {
            $suppliers = [];
            // Fetch suppliers in chunks
            Supplier::select('supp_code', 'supp_name')->chunk(100, function ($chunk) use (&$suppliers) {
                foreach ($chunk as $supplier) {
                    $suppliers[] = [
                        'supp_code' => $supplier->supp_code,
                        'supp_name' => $supplier->supp_name,
                    ];
                }
            });

            // Log the successful retrieval of suppliers
            activity()
                ->performedOn(new Supplier())
                ->log('Fetched all suppliers successfully.');

            // Return the suppliers as a JSON response
            return response()->json(['suppliers' => $suppliers]);
        } catch (Exception $e) {
            // Log the error message

            // Log the activity for error
            activity()
                ->performedOn(new Supplier())
                ->log('Error fetching suppliers: ' . $e->getMessage());

            // Return a JSON response with an error message
            return response()->json(['error' => 'Failed to fetch suppliers.'], 500);
        }
    }

    public function data(Request $request)
    {
        // Query the suppliers table
        $query = DB::table('supplier');

        // Use DataTables to handle server-side processing
        return DataTables::of($query)
            ->addIndexColumn() // Add an index column for row numbering

            ->addColumn('actions', function ($supplier) {
                $editUrl = route('suppliers.edit', $supplier->id);
                $deleteUrl = route('suppliers.destroy', $supplier->id);

                return '
                <a href="' . $editUrl . '" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="' . $deleteUrl . '" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure?\');">
                    ' . csrf_field() . '
                    ' . method_field('DELETE') . '
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            ';
            })
            ->rawColumns(['actions']) // Allow HTML in the actions column
            ->make(true);
    }
}
