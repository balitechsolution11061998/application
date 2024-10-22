<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserStore;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    //
    public function storeUser  (Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'username' => 'required|exists:users,username', // Ensure the username exists in the users table
                'store_id' => 'required|exists:store,id', // Ensure the store_id exists in the stores table
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
                    'store_name' => $userStore->store->store_name, // Assuming you have a relationship to get the store name
                    'store' => $userStore->store->id, // Assuming you want to return the store ID
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
                    'store_name' => $userStore->store->store_name, // Assuming you have a relationship to get the store name
                    'store' => $userStore->store->id, // Assuming you want to return the store ID
                ], 201);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error creating/updating user store: ' . $e->getMessage()], 500);
        }
    }

    public function deleteStoreUser (Request $request)
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
