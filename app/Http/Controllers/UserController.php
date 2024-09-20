<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

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

    public function userCount(){
        dd("masuk sini");
        $rolesWithUserCount = Cache::remember('rolesWithUserCount', now()->addMinutes(10), function () {
            return Role::select('id', 'name')->withCount('users')->get();
        });
        return response()->json($rolesWithUserCount);
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
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'old_password' => 'required',
            'password' => 'required|min:8', // Ensure the new password and confirmation match
        ]);

        try {
            $user = User::findOrFail($request->user_id);

            // Debugging: Output the hashed values for comparison
            $plainOldPassword = $request->old_password;
            $storedOldPassword = $user->password_show; // Assuming this is not hashed

            // Check if the old password is correct
            // if ($plainOldPassword !== $storedOldPassword) {
            //     return response()->json(['message' => 'The old password is incorrect.'], 400);
            // }

            // Check if the new password is the same as the old one
            if (Hash::check($request->password, $user->password)) {
                return response()->json(['message' => 'The new password cannot be the same as the old one.'], 400);
            }

            // Check if the new password has been used before
            if ($user->passwordHistories()->where('password', $request->password)->exists()) {
                return response()->json(['message' => 'The new password has been used before.'], 400);
            }

            // Save the old password to history
            $user->passwordHistories()->create([
                'password' => $user->password_show, // This should be the hashed password
            ]);

            // Update the password
            $user->password = bcrypt($request->password);
            $user->password_show = $request->password; // Update plain text password if needed
            $user->save();

            return response()->json(['message' => 'Password changed successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to change password: ' . $e->getMessage()], 500);
        }
    }




    public function store(Request $request)
    {
        // Validate the request data
        $rules = [
            'username' => 'required|string|max:255|unique:users,username,' . $request->id, // Unique for all except current user (update)
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . ($request->id ?? 'NULL'), // Unique for all except current user (update)
            'password' => $request->id ? 'nullable|min:8' : 'required|min:8', // Password is required for new user, optional for update
            'roles' => 'required|array',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate the profile picture
        ];

        // Validate the input
        $validated = $request->validate($rules);

        // Handle the profile picture upload
        if ($request->hasFile('profile_picture')) {
            $profilePicture = $request->file('profile_picture');
            $profilePicturePath = $profilePicture->store('profile_pictures', 'public');
        } else {
            $profilePicturePath = null;
        }

        if ($request->id === null) {
            // Create a new user
            $user = User::create([
                'username' => $validated['username'],
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'profile_picture' => $profilePicturePath,
            ]);
        } else {
            // Find the existing user
            $user = User::findOrFail($request->id);

            // Update the user data
            $user->update([
                'username' => $validated['username'],
                'name' => $validated['name'],
                'email' => $validated['email'],
                // Only update the password if it's provided
                'password' => $validated['password'] ? bcrypt($validated['password']) : $user->password,
                'profile_picture' => $profilePicturePath ?? $user->profile_picture, // Keep the old profile picture if no new one is uploaded
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
