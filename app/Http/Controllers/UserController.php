<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use App\Jobs\UsersImportJob;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    //
    public function index()
    {
        // Use select() to reduce the columns fetched and withCount() to fetch the user count efficiently
        $rolesWithUserCount = Role::select('id', 'name')->withCount('users')->get();

        // Optionally, cache the results to avoid hitting the database repeatedly
        $rolesWithUserCount = Cache::remember('rolesWithUserCount', now()->addMinutes(10), function () {
            return Role::select('id', 'name')->withCount('users')->get();
        });

        return view('management_user.users.index', compact('rolesWithUserCount'));
    }

    // Method to handle user import
    public function import(Request $request)
    {
        // Validate the file input
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:xlsx,csv', // Validate Excel or CSV file
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        // Handle the Excel file and import data
        try {
            // Store the uploaded file in a temporary location
            $filePath = $request->file('file')->store('imports');

            // Dispatch the job, passing the stored file path
            dispatch(new UsersImportJob($filePath)); // Pass file path, not the file object

            return response()->json(['success' => true, 'message' => 'Users imported successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error importing data: ' . $e->getMessage()]);
        }
    }


    public function profile()
    {
        // Fetch the authenticated user's details
        $user = auth()->user();
        // Return the profile view with the user's data
        return view('management_user.users.profile', compact('user'));
    }

    public function getUsersData(Request $request)
    {
        if ($request->ajax()) {
            // Query to get user data with roles and region
            $data = User::with(['roles', 'region']) // Eager load roles and region
                        ->select('id', 'profile_picture', 'username', 'name', 'email', 'password_show', 'region_id', 'created_at');

            return Datatables::of($data)
                ->addColumn('roles', function ($row) {
                    // Fetch and format roles
                    return $row->roles->pluck('name')->implode(', ');
                })
                ->addColumn('region', function ($row) {
                    // Fetch and format region name
                    return $row->region ? $row->region->name : 'N/A';
                })
                ->addColumn('actions', function ($row) {
                    // Fetch roles for the current user
                    $userRoles = $row->roles->pluck('name')->toArray();
                    $isAdmin = in_array('superadministrator', $userRoles); // Assuming 'superadministrator' role can perform all actions

                    // Return a set of buttons for each action: Edit, Delete, and Change Password, with Font Awesome icons
                    $actions = '';

                    if ($isAdmin) {
                        $actions .= '
                            <button type="button" class="btn btn-sm btn-primary" onclick="editUser(' . $row->id . ')">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteUser(' . $row->id . ')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                            <button type="button" class="btn btn-sm btn-warning" onclick="changePassword(' . $row->id . ')">
                                <i class="fas fa-key"></i> Change Password
                            </button>
                        ';
                    } else {
                        $actions .= '
                            <button type="button" class="btn btn-sm btn-primary" onclick="editUser(' . $row->id . ')">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                        ';
                    }

                    return $actions;
                })
                ->rawColumns(['actions']) // Important for rendering HTML in the actions column
                ->make(true);
        }
    }



    public function changePassword(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed', // Ensure confirmation password matches
        ]);

        try {
            // Find the user by ID
            $user = User::findOrFail($request->user_id);

            // Verify the old (current) password
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'errors' => [
                        'current_password' => ['The current password is incorrect.']
                    ]
                ], 400);
            }

            // Prevent using the same password as the old one
            if (Hash::check($request->new_password, $user->password)) {
                return response()->json([
                    'errors' => [
                        'new_password' => ['The new password cannot be the same as the current password.']
                    ]
                ], 400);
            }

            // Optional: Save old password in password history table (if applicable)
            $user->passwordHistories()->create([
                'password' => $user->password, // Save the current hashed password
            ]);

            // Update the password with a new hash
            $user->password = bcrypt($request->new_password);
            $user->password_show = $request->new_password; // Store plain text password if necessary
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Password changed successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to change password: ' . $e->getMessage()
            ], 500);
        }
    }






    public function store(Request $request)
    {
        // Validate the request data
        $rules = [
            'username' => 'required|string|max:255', // Removed the unique validation for username
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . ($request->id ?? 'NULL'), // Unique for all except current user (update)
            'password' => $request->id ? 'nullable|min:8|confirmed' : 'required|min:8|confirmed', // Password is required for new user, optional for update
            'address' => 'required|string|max:255',
            'region_id' => 'required|integer',
            'roles' => 'required|array',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        // Validate the input
        $validated = $request->validate($rules);

        // Handle the profile picture upload
        if ($request->hasFile('profile_picture')) {
            $profilePicture = $request->file('profile_picture');
            $profilePicturePath = $profilePicture->store('profile_pictures', 'public');

            // If updating, delete the old picture
            if ($request->id) {
                $existingUser = User::find($request->id);
                if ($existingUser && $existingUser->profile_picture && Storage::disk('public')->exists($existingUser->profile_picture)) {
                    Storage::disk('public')->delete($existingUser->profile_picture);
                }
            }
        } else {
            $profilePicturePath = $request->id ? User::find($request->id)->profile_picture : null;
        }

        // Generate a unique username if necessary
        $username = $validated['username'];
        $counter = 1;

        // Check if username exists and generate a unique one
        while (User::where('username', $username)->where('id', '!=', $request->id)->exists()) {
            $username = $validated['username'] . $counter; // Append a number to the username
            $counter++;
        }

        if ($request->id === null) {
            // Create a new user
            $user = User::create([
                'username' => $username, // Use generated unique username
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'address' => $validated['address'],
                'region_id' => $validated['region_id'],
                'profile_picture' => $profilePicturePath,
            ]);
        } else {
            // Find the existing user
            $user = User::findOrFail($request->id);

            // Update the user data
            $user->update([
                'username' => $username, // Use generated unique username
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'] ? bcrypt($validated['password']) : $user->password,
                'address' => $validated['address'],
                'region_id' => $validated['region_id'],
                'profile_picture' => $profilePicturePath,
            ]);
        }

        // Assign roles to the user
        $user->syncRoles($validated['roles']);

        // Return a success response
        return response()->json(['message' => 'User saved successfully'], 200);
    }






    public function verifySuperadminPassword(Request $request)
    {
        // Assuming 'superadministrator_password' is stored securely in the environment or database
        if ($request->password == "Superman2000@") {
            // Fetch the user's actual password from the database based on the selected row ID
            $user = User::find($request->user_id);

            if ($user) {
                return response()->json(['success' => true, 'password' => $user->password_show]);
            } else {
                return response()->json(['success' => false, 'message' => 'User not found.']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Incorrect password.']);
        }
    }

    public function edit($id)
    {
        // Fetch the user by ID
        $user = User::with('roles')->find($id);

        if ($user) {
            // Return user data along with assigned roles in JSON format
            return response()->json([
                'id' => $user->id,
                'username' => $user->username,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->roles->pluck('name'), // Assuming roles are fetched by name
                'address' => $user->address,
                'region' => $user->region_id,
            ]);
        }

        // If user is not found, return an error response
        return response()->json(['error' => 'User not found'], 404);
    }

    public function destroy($id)
    {
        try {
            // Find the user and delete
            $user = User::findOrFail($id);
            $user->delete();

            // Return a success response
            return response()->json(['message' => 'User deleted successfully'], 200);
        } catch (\Exception $e) {
            // Return an error response if the deletion fails
            return response()->json(['message' => 'Failed to delete user: ' . $e->getMessage()], 500);
        }
    }
}
