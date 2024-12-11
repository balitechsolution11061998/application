<?php

namespace App\Http\Controllers;

use App\Events\PriceChangeUpdated;
use App\Helpers\ResponseJson;
use App\Models\HistoryApprovalCostChange;
use App\Models\Items;
use App\Models\ItemSupplier;
use App\Models\Notification;
use App\Models\PriceChange;
use App\Models\PriceChangeDetail;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\LogsActivity;
use App\Traits\QueryPerformanceLoggingTrait;
use DateInterval;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Response;
use Pusher\Pusher;

class PriceChangeController extends Controller
{
    use LogsActivity, QueryPerformanceLoggingTrait;

    //
    public function index()
    {

        return view('price-change.index');
    }

    public function count(Request $request)
    {
        try {
            $userIp = $request->ip();

            // Log the activity of accessing the create page using the trait
            $this->logActivity('Accessed item supplier data', 'User accessed the item page');

            if ($request->ajax()) {
                // Start measuring query execution time
                $startTime = microtime(true);
                $startMemory = memory_get_usage();

                $query = PriceChange::with('suppliers', 'users');

                // Check if search parameter is provided
                if ($request->search != null) {
                    $searchTerm = $request->search;
                    $query->where(function ($query) use ($searchTerm) {
                        $query->where('supplier', 'like', '%' . $searchTerm . '%')
                            ->orWhere('sku', 'like', '%' . $searchTerm . '%');
                    });
                }

                // Get the count of records
                $count = $query->count();

                // Calculate query execution time
                $endTime = microtime(true);
                $endMemory = memory_get_usage();

                $executionTime = $endTime - $startTime;
                $executionTimeInSeconds = round($executionTime, 4);
                $memoryUsage = $endMemory - $startMemory;

                $this->logQueryPerformance('count_data_price_change', $request->search, $executionTimeInSeconds, $memoryUsage, $userIp);

                return response()->json(['count' => $count], 200);
            }
        } catch (\Exception $e) {
            // Log the error
            $this->logError('An error occurred while accessing the create page', $e);

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function data(Request $request)
    {
        try {
            $userIp = $request->ip();



            if ($request->ajax()) {
                // Start measuring query execution time and memory usage
                $startTime = microtime(true);
                $startMemory = memory_get_usage();

                // Build the base query
                $query = PriceChange::with('suppliers', 'users')->latest();

                // Apply role-based conditions
                if (Auth::user()->hasRole('supplier')) {
                    $query;
                } else {
                    $query->where('status', 'progress');
                }

                // Apply search filter if provided
                if ($request->filled('search')) {
                    $searchTerm = $request->search;
                    $query->where(function ($q) use ($searchTerm) {
                        $q->where('supplier', 'like', '%' . $searchTerm . '%')
                            ->orWhere('sku', 'like', '%' . $searchTerm . '%');
                    });
                }

                // Fetch results using chunking
                $results = [];
                $query->chunk(100, function ($items) use (&$results) {
                    foreach ($items as $item) {
                        $results[] = $item;
                    }
                });



                // Return DataTables response
                return DataTables::of($results)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        return '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">Edit</a>' .
                            '<a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
        } catch (\Exception $e) {
            // Log the error
            $this->logError('An error occurred while accessing the create page', $e);

            // Return error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    public function show($id)
    {
        try {
            // Fetch the PriceChange data along with its details
            $data = PriceChange::with('priceListDetails', 'history')->where('id', $id)->firstOrFail();

            // Get all permissions of the authenticated user
            $permissions = Auth::user()->allPermissions()->pluck('name');

            // Return the data along with permissions
            return response()->json([
                'message' => 'Found Data Price Change',
                'status' => 'success',
                'data' => [
                    'price_change' => $data,
                    'permissions' => $permissions
                ]
            ], 200);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error fetching price change data', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'price_change_id' => $id,
                'exception' => $e
            ]);

            // Return an error response
            return response()->json([
                'message' => 'An error occurred while fetching the data.',
                'status' => 'error',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function download()
    {
        try {
            DB::beginTransaction();

            // Query data from the Item and Supplier tables
            if (Auth::user()->hasRole('administrator')) {
                $data = Items::all();
            } else {
                $data = Items::where('supplier', Auth::user()->username)->get();
            }
            // dd($data);
            DB::commit();

            // Generate CSV content
            $csvContent = $this->generateCsv($data);

            // Define the CSV file name
            $fileName = 'pricelist_mm.csv';

            // Return the CSV file as a download response
            return Response::make($csvContent, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"'
            ]);
        } catch (\Exception $e) {
            // DB::rollBack();
            Log::error('File download failed: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while processing your request. Please contact support.'
            ], 500);
        }
    }

    private function generateCsv($data)
    {
        // Define the header for the CSV
        $header = ['Barcode', 'Item Desc', 'New Cost'];

        // Open memory as file
        $output = fopen('php://output', 'w');
        ob_start();

        // Write the header
        fputcsv($output, $header);

        // Write the data rows

        foreach ($data as $row) {
            // Format current date as "Example : 30/04/2023"
            $futureDate = date('d/m/Y');

            $csvRow = [
                sprintf('%d', $row->upc),
                $row->sku_desc,
                $row->unit_cost
            ];

            fputcsv($output, $csvRow);
        }


        // Get the CSV content
        fclose($output);
        return ob_get_clean();
    }

    public function approve(Request $request)
    {
        $priceListHead = PriceChange::find($request->id);

        // Update the fields
        $priceListHead->role_last_app = Auth::user()->roles[0]->id;
        // Make sure you are using the correct variable name here ^^^^^^^^^^^^
        $priceListHead->status = 'approve';
        // $roleNextApp = DB::table('mapping_app_pricelist')
        //     ->where('role_id', Auth::user()->roles[0]->id)
        //     ->where('region_id', Auth::user()->region)
        //     ->first()->position + 1;

        // $priceListHead->role_next_app = DB::table('mapping_app_pricelist')
        //     ->where('position', $roleNextApp)
        //     ->first()->role_id;

        $priceListHead->approval_id = Auth::user()->username;

        // Save the changes
        $priceListHead->save();

        $data = HistoryApprovalCostChange::create([
            'pricelist_id' => $request->id,
            'user_id' => Auth::user()->username,
            'role_id' => Auth::user()->roles[0]->id,
            'status' => 'approve'
        ]);

        $dataPengirim = User::where('username', Auth::user()->username)->first();
        $supplier = Supplier::where('supp_code', $priceListHead->supplier_id)->first();
        // event(new PriceChangeApprove($priceListHead,$dataPengirim,$supplier));


        return ResponseJson::response('Success approved data price change', 'success', array('data' => $data), 200);
    }

    public function reject(Request $request)
    {
        $priceListHead = PriceChange::find($request->id);

        // Update the fields
        $priceListHead->role_last_app = Auth::user()->roles[0]->id;
        // Make sure you are using the correct variable name here ^^^^^^^^^^^^
        $priceListHead->role_next_app = Auth::user()->roles[0]->id;

        $priceListHead->approval_id = Auth::user()->username;
        $priceListHead->status = 'reject';
        // Save the changes
        $priceListHead->save();



        $data = HistoryApprovalCostChange::create([
            'pricelist_id' => $request->id,
            'user_id' => Auth::user()->username,
            'role_id' => Auth::user()->roles[0]->id,
            'status' => 'reject',
            'reason' => $request->reason,
        ]);
        $dataPengirim = User::where('username', Auth::user()->username)->first();
        $supplier = Supplier::where('supp_code', $priceListHead->supplier_id)->first();
        // event(new PriceChangeApprove($priceListHead,$dataPengirim,$supplier));

        return ResponseJson::response('Success rejected data price change', 'success', array('data' => $data), 200);
    }


    // public function store(Request $request)
    // {
    //     try {
    //         $activeDate = $request->input('active_date');
    //         $pricelistDesc = $request->input('pricelist_desc');
    //         $lastNo = PriceChange::all()->max('pricelist_no');
    //         $number = $lastNo ? intval(substr($lastNo, 2)) + 1 : 1;
    //         $pricelistNo = 'PL' . str_pad($number, 3, '0', STR_PAD_LEFT);


    //         $barcode = $request->input('barcode');
    //         $item_desc = $request->input('item_desc');
    //         $oldCost = $request->input('old_cost');
    //         $newCost = $request->input('new_cost');

    //         $id = $request->input('id');

    //         if ($id) {
    //             // Fetch the existing PriceChange record for updating
    //             $pricelistHead = PriceChange::findOrFail($id);
    //         } else {
    //             // Create a new PriceChange record
    //             $pricelistHead = new PriceChange();
    //         }

    //         $pricelistHead->active_date = $activeDate;
    //         $pricelistHead->pricelist_no = $pricelistNo;
    //         $pricelistHead->pricelist_desc = $pricelistDesc;
    //         $pricelistHead->status = 'progress';
    //         $pricelistHead->supplier_id = Auth::user()->username;
    //         $pricelistHead->role_last_app = Auth::user()->roles[0]->id;

    //         if (Auth::user()->hasRole('supplier')) {
    //             $roleNextApp = DB::table('mapping_app_pricelist')
    //                 ->where('role_id', Auth::user()->roles[0]->id)
    //                 ->where('region_id', Auth::user()->region)
    //                 ->first()->position;
    //             $pricelistHead->role_next_app = $roleNextApp;
    //             $pricelistHead->save();
    //         } else {
    //             $pricelistHead->status = 'approve';
    //             $pricelistHead->approval_id = Auth::user()->username;
    //             $pricelistHead->save();

    //             $data = HistoryApprovalCostChange::create([
    //                 'pricelist_id' => $pricelistHead->id,
    //                 'user_id' => Auth::user()->username,
    //                 'role_id' => Auth::user()->roles[0]->id,
    //                 'status' => 'approve'
    //             ]);

    //             HistoryApprovalCostChange::create([
    //                 'pricelist_id' => $pricelistHead->id,
    //                 'user_id' => Auth::user()->username,
    //                 'role_id' => Auth::user()->roles[0]->id,
    //                 'status' => 'approve'
    //             ]);
    //         }

    //         // Save or update pricelistHead

    //         // Clear existing PriceChangeDetails if updating
    //         if ($id) {
    //             PriceChangeDetail::where('pricelist_head_id', $pricelistHead->id)->delete();
    //         }

    //         // Create new PriceChangeDetail records
    //         foreach ($barcode as $key => $code) {
    //             if ($code != "" && $item_desc[$key] != "" && $oldCost[$key] != "" && $newCost[$key] != "") {
    //                 PriceChangeDetail::create([
    //                     'pricelist_head_id' => $pricelistHead->id,
    //                     'barcode' => $code,
    //                     'item_desc' => $item_desc[$key],
    //                     'old_cost' => $oldCost[$key],
    //                     'new_cost' => str_replace('.', '', $newCost[$key]),
    //                     // Assuming you have other fields in pricelist_detail table
    //                 ]);
    //             }
    //         }

    //         $usersWithRole = User::whereHas('roles', function ($query) use ($pricelistHead) {
    //             $query->where('id', $pricelistHead->role_next_app);
    //         })->get();

    //         $supplier = Supplier::where('supp_code', Auth::user()->username)->first();
    //         // Push notification using Pusher
    //         $notificationData = [
    //             'title' => 'Price Change Created',
    //             'message' => 'A price change has been ' . ($id ? 'updated' : 'created') . ' by ' . ($supplier ? $supplier->name : 'unknown supplier') . '.',
    //             'price_change_id' => $pricelistHead->id,
    //             'supplier_name' => $supplier ? $supplier->name : 'unknown',
    //             'supplier_code' => $supplier ? $supplier->supp_code : 'unknown',
    //         ];
    //         Notification::create($notificationData);

    //         event(new PriceChangeUpdated($notificationData));

    //         return ResponseJson::response('Price change update successfully', 'success', [], 200);
    //     } catch (\Throwable $th) {
    //         return ResponseJson::response($th->getMessage(), 'error', [], 500);
    //     }
    // }

    public function store(Request $request)
{
    try {
        // Extracting request data
        $activeDate = $request->input('active_date');
        $pricelistDesc = $request->input('pricelist_desc');
        $lastNo = PriceChange::all()->max('pricelist_no');
        $number = $lastNo ? intval(substr($lastNo, 2)) + 1 : 1;
        $pricelistNo = 'PL' . str_pad($number, 3, '0', STR_PAD_LEFT);

        $barcode = $request->input('barcode');
        $item_desc = $request->input('item_desc');
        $oldCost = $request->input('old_cost');
        $newCost = $request->input('new_cost');

        $id = $request->input('id');

        // Fetch or create the PriceChange record
        if ($id) {
            $pricelistHead = PriceChange::findOrFail($id);
        } else {
            $pricelistHead = new PriceChange();
        }

        // Set fields on pricelistHead
        $pricelistHead->active_date = $activeDate;
        $pricelistHead->pricelist_no = $pricelistNo;
        $pricelistHead->pricelist_desc = $pricelistDesc;
        $pricelistHead->status = 'progress';
        $pricelistHead->supplier_id = Auth::user()->username;
        $pricelistHead->role_last_app = Auth::user()->roles[0]->id;

        if (Auth::user()->hasRole('supplier')) {
            $roleNextApp = DB::table('mapping_app_pricelist')
                ->where('role_id', Auth::user()->roles[0]->id)
                ->where('region_id', Auth::user()->region)
                ->first()->position;
            $pricelistHead->role_next_app = $roleNextApp;
            $pricelistHead->save();
        } else {
            $pricelistHead->status = 'approve';
            $pricelistHead->approval_id = Auth::user()->username;
            $pricelistHead->save();

            HistoryApprovalCostChange::create([
                'pricelist_id' => $pricelistHead->id,
                'user_id' => Auth::user()->username,
                'role_id' => Auth::user()->roles[0]->id,
                'status' => 'approve'
            ]);
        }

        // Clear existing PriceChangeDetails if updating
        if ($id) {
            PriceChangeDetail::where('pricelist_head_id', $pricelistHead->id)->delete();
        }

        // Create or update PriceChangeDetail records
        foreach ($barcode as $key => $code) {
            if ($code != "" && $item_desc[$key] != "" && $oldCost[$key] != "" && $newCost[$key] != "") {
                $priceChangeDetail = PriceChangeDetail::create([
                    'pricelist_head_id' => $pricelistHead->id,
                    'barcode' => $code,
                    'item_desc' => $item_desc[$key],
                    'old_cost' => $oldCost[$key],
                    'new_cost' => str_replace('.', '', $newCost[$key]),
                ]);
                // If the user is not a supplier, update the item_supplier table
                if (!Auth::user()->hasRole('supplier')) {
                    $itemSupplier = ItemSupplier::where([
                        'upc' => $code,
                    ])->first();

                    $itemSupplier->unit_cost = str_replace('.', '', $newCost[$key]);
                    $itemSupplier->last_update_id = Auth::user()->username;
                    $itemSupplier->last_update_date = now()->format('Y-m-d H:i:s');

                    if (!$itemSupplier->exists) {
                        $itemSupplier->create_id = Auth::user()->username;
                        $itemSupplier->create_date = now()->format('Y-m-d H:i:s');
                    }

                    $itemSupplier->save();
                }
            }
        }

        // Fetch users with the next approval role
        $usersWithRole = User::whereHas('roles', function ($query) use ($pricelistHead) {
            $query->where('id', $pricelistHead->role_next_app);
        })->get();

        $supplier = Supplier::where('supp_code', Auth::user()->username)->first();

        // Push notification using Pusher
        $notificationData = [
            'title' => 'Price Change Created',
            'message' => 'A price change has been ' . ($id ? 'updated' : 'created') . ' by ' . ($supplier ? $supplier->sup_name : 'unknown supplier') . '.',
            'price_change_id' => $pricelistHead->id,
            'supplier_name' => $supplier ? $supplier->sup_name : 'unknown',
            'supplier_code' => $supplier ? $supplier->supp_code : 'unknown',
        ];
        Notification::create($notificationData);

        event(new PriceChangeUpdated($notificationData));

        return ResponseJson::response('Price change update successfully', 'success', [], 200);
    } catch (\Exception $e) {
        dd($e->getMessage());
        return ResponseJson::response($th->getMessage(), 'error', [], 500);
    }
}





    public function upload(Request $request)
    {
        try {
            // Validate the uploaded file
            $request->validate([
                'file' => 'required|file|mimes:csv,txt', // Adjust the mime types as needed
            ]);

            // Get the file from the request
            $file = $request->file('file');

            // Start a database transaction
            DB::beginTransaction();

            // Initialize an array to collect validation errors
            $validationErrors = "";

            // Process the file data
            if ($file->isValid()) {
                // Get file path
                $filePath = $file->getPathname();

                // Read file contents
                $fileContents = file_get_contents($filePath);

                // Process file contents as needed
                $csvData = array_map('str_getcsv', explode("\n", $fileContents));
                // Iterate through each row of CSV data
                $pricelistHead = new PriceChange();

                $pricelistHead->status = 'temp';
                $pricelistHead->supplier_id = Auth::user()->username;
                $pricelistHead->role_last_app = Auth::user()->roles[0]->id;

                if (Auth::user()->hasRole('administrator')) {
                    $roleNextApp = DB::table('mapping_app_pricelist')
                        ->where('role_id', Auth::user()->roles[0]->id)
                        ->where('region_id', Auth::user()->region)
                        ->first()->position;
                } else {
                    $roleNextApp = DB::table('mapping_app_pricelist')
                        ->where('role_id', Auth::user()->roles[0]->id)
                        ->where('region_id', Auth::user()->region)
                        ->first()->position + 1;
                }
                $pricelistHead->role_next_app = $roleNextApp;
                $pricelistHead->save();

                for ($i = 1; $i < count($csvData); $i++) {
                    $column = $csvData[$i];
                    if (count($column) > 0) {
                        for ($j = 0; $j < count($column); $j++) {
                            if ($column[$j] != null) {
                                if ($column[$j] == "") {
                                    // Record the error: which column is missing or empty
                                    $validationErrors = "Ada column yang masih kosong";
                                }
                            } else {
                                $validationErrors = "";
                            }
                        }
                    } else {
                        $validationErrors = "";
                    }
                    if ($validationErrors != "") {
                        DB::rollBack();
                        return response()->json([
                            'title' => 'Error Upload.',
                            'message' => $validationErrors,
                            'icon' => 'warning',
                        ], 400);
                    }
                    if (isset($column)) {
                        // Process the row if it has enough elements


                        if (isset($column[0])) {
                            PriceChangeDetail::create([
                                'pricelist_head_id' => $pricelistHead->id,
                                'barcode' => intval($column[0]),
                                'item_desc' => $column[1],
                                'old_cost' => Items::where('upc', intval($column[0]))->first()->unit_cost,
                                'new_cost' => intval($column[2]),
                                // Add other fields as needed
                            ]);
                        }
                    }
                }

                // If there are validation errors, rollback transaction and return errors


                // Commit the transaction if successful
                DB::commit();

                // Return success response
                return response()->json([
                    'message' => 'File uploaded and processed successfully',
                    'data' => $pricelistHead->id,
                ], 200);
            }

            // Return a response if the file is not valid
            return response()->json(['error' => 'Invalid file'], 400);
        } catch (\Exception $e) {
            dd($e->getMessage());
            // Rollback the transaction and log the error
            DB::rollBack();
            Log::error('File upload failed: ' . $e->getMessage());
            return response()->json([
                'title' => 'Error Upload.',
                'message' => 'An error occurred while processing your request. Please contact support.',
                'icon'
            ], 500);
        }
    }
}

