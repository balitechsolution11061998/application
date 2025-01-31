<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\User;
use App\Models\UserStore;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Arr;

class StoreController extends Controller
{
    public function index()
    {
        return view('store.index');
    }

    public function edit(Request $request, $id)
    {
        try {
            // Find the model instance
            $model = Store::findOrFail($id);

            // Perform your edit logic here (e.g., updating fields)
            $model->update($request->all());

            // Log the successful edit activity
            activity()
                ->performedOn($model)
                ->log('Edited the model with ID: ' . $id);

            return response()->json(['success' => true, 'message' => 'Model updated successfully.']);
        } catch (\Exception $e) {
            // Log the failed activity
            activity()
                ->performedOn($model ?? new Store()) // Log on the model if found, else a new instance
                ->log('Failed to edit the model with ID: ' . $id . ' - Error: ' . $e->getMessage());

            return response()->json(['success' => false, 'message' => 'Failed to update model.'], 500);
        }
    }

    public function getStores(Request $request)
    {
        try {
            // Start building the query
            $query = Store::select('store.store', 'store.store_name')
                ->leftJoin('user_store', 'store.store', '=', 'user_store.store_id');

            // Get the authenticated user
            $user = auth()->user();

            // If the user has a specific role (e.g., 'store'), filter by user_store
            if ($user->hasRole('store')) { // Adjust the role name as necessary
                // Get the store IDs associated with the user
                $storeIds = $user->userStore->pluck('store_id'); // Assuming userStore is a relationship that returns a collection

                // Use whereIn to filter stores based on the user's associated store IDs
                $query->whereIn('user_store.store_id', $storeIds);
            }

            // Check if there is a search term in the request
            if ($request->has('search') && !empty($request->search)) {
                $searchTerm = $request->search;
                // Apply a where clause to filter stores based on the search term
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('stores.store', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('stores.store_name', 'LIKE', "%{$searchTerm}%");
                });
            }

            // Fetch stores from the database
            $stores = $query->get();

            // Return the stores as a JSON response
            return response()->json($stores);
        } catch (ModelNotFoundException $e) {
            // Handle the case where no stores are found
            return response()->json(['error' => 'No stores found.'], 404);
        } catch (\Exception $e) {
            // Handle any other exceptions
            return response()->json(['error' => 'An error occurred while fetching stores: ' . $e->getMessage()], 500);
        }
    }



    public function store(Request $request)
    {
        // Debugging: Uncomment the line below to see the incoming request data
        // dd($request->all());

        $totalData = 0;
        $successCount = 0;
        $failureCount = 0;

        try {
            $data = $request->data; // Get all request data
            $totalData = count($data); // Total number of records

            foreach ($data as $record) {
                try {
                    // Validate the record data
                    // You can add validation logic here if needed

                    // Use updateOrCreate to insert or update the store record
                    $newStore = Store::updateOrCreate(
                        ['store' => (int) Arr::get($record, 'store', 0)], // Unique identifier for the record
                        [
                            'store_name' => Arr::get($record, 'store_name', ''),
                            'store_add1' => Arr::get($record, 'store_add1', ''),
                            'store_add2' => Arr::get($record, 'store_add2', ''),
                            'store_city' => Arr::get($record, 'store_city', ''),
                            'region' => (int) Arr::get($record, 'region', 0), // Ensure 'region' is an integer
                            // Add more fields if needed
                        ]
                    );

                    $successCount++;

                    // Log successful activity
                    activity('StoreRecordAction')
                        ->performedOn($newStore)
                        ->event('api_store_insert')
                        ->causedBy(auth()->user())
                        ->withProperties(['record' => $record])
                        ->log('Store record inserted/updated successfully: ' . Arr::get($record, 'store_name'));
                } catch (\Exception $e) {
                    // Increment failure count if there's an issue inserting/updating this record
                    $failureCount++;

                    // Log failed activity
                    activity('StoreRecordAction')
                        ->performedOn(new Store())
                        ->event('api_store_insert')
                        ->causedBy(auth()->user())
                        ->withProperties(['record' => $record, 'error' => $e->getMessage()])
                        ->log('Failed to insert/update store record: ' . Arr::get($record, 'store_name') . ' - Error: ' . $e->getMessage());
                }
            }

            // Return a success response with the counts
            return response()->json([
                'message' => 'Data processed successfully',
                'success' => true,
                'total_data' => $totalData,
                'success_count' => $successCount,
                'failure_count' => $failureCount,
            ], 200);
        } catch (\Exception $e) {
            // Handle the exception, log it, and return an error response
            activity()
                ->event('api_store_insert')
                ->causedBy(auth()->user())
                ->withProperties(['error' => $e->getMessage()])
                ->log('An error occurred while processing data: ' . $e->getMessage());

            return response()->json([
                'message' => 'An error occurred while processing data',
                'error' => $e->getMessage(),
                'total_data' => $totalData,
                'success_count' => $successCount,
                'failure_count' => $failureCount,
            ], 500);
        }
    }


    // Validation method


    public function data(Request $request)
    {
        // Query the suppliers table
        $stores = DB::table('store')
            ->join('region', 'region.id', '=', 'store.region')
            ->select('store.*', 'region.name as region_name', 'region.region_code');

        // Use DataTables to handle server-side processing
        return DataTables::of($stores)
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

    //
    public function storeUser(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'username' => 'required|exists:users,username', // Ensure the username exists in the users table
                'store_id' => 'required', // Ensure the store_id exists in the stores table
            ]);

            // Find the user by username
            $user = User::where('username', $request->input('username'))->first();

            // Check if the user-store relationship already exists
            $userStore = UserStore::where('user_id', $user->username) // Use user ID for the relationship
                ->where('store_id', $request->input('store_id'))
                ->first();
            if ($userStore) {
                // If it exists, update the record if needed
                $userStore->updated_at = now(); // Update timestamp
                $userStore->save();

                // Return the existing user store data
                return response()->json([
                    'success' => true,
                    'message' => 'User  store updated successfully',
                    'userStoreId' => $userStore->id,
                ], 200);
            } else {
                // If it does not exist, create a new record
                $userStore = UserStore::create([
                    'user_id' => $user->username, // Use the user's ID
                    'store_id' => $request->input('store_id'),
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'User  store created successfully',
                    'userStoreId' => $userStore->id,
                ], 201);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error creating/updating user store: ' . $e->getMessage()], 500);
        }
    }

    public function deleteStoreUser(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'store_id' => 'required|integer', // Ensure the store ID exists
            'username' => 'required|string|max:255', // Validate the username
        ]);

        try {
            // Find the store by userStoreId
            $userStore = UserStore::findOrFail($request->input('store_id'));



            // Delete the store
            $userStore->delete();

            // Return a success response
            return response()->json(['success' => true, 'message' => 'Store deleted successfully.']);
        } catch (\Exception $e) {
            // Handle any errors that may occur
            return response()->json(['success' => false, 'message' => 'An error occurred while deleting the store.'], 500);
        }
    }
}
