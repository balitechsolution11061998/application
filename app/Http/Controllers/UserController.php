<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use App\Jobs\UsersImportJob;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Exception;
use Hashids\Hashids;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Activitylog\Models\Activity;

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

    public function deleteEmail(Request $request)
    {
        try {
            // Find the user by username, throw a 404 error if the user doesn't exist
            $user = User::where('username', $request->username)->first();

            // Check if the user was found
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            // Check if the email exists in the user's emails
            if ($user->userEmails()->where('email', $request->email)->exists()) {
                // Perform the delete operation
                $user->userEmails()->where('email', $request->email)->delete();

                // Return a success response
                return response()->json([
                    'success' => true,
                    'message'=> 'Email deleted successfully',
                ]);
            } else {
                // Return a 404 error if the email is not found
                return response()->json(['error' => 'Email not found'], 404);
            }
        } catch (\Exception $e) {
            // Log the exception message for debugging (optional)

            // Handle any unexpected exceptions and return a 500 error with the exception message
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }



    public function getUsersData(Request $request)
    {
        if ($request->ajax()) {
            // Query to get user data with roles and region
            $data = User::with(['roles', 'region', 'userEmails']) // Eager load roles, region, and userEmails
                ->select('id', 'profile_picture', 'username', 'name', 'email', 'password_show', 'region_id', 'created_at');

            return Datatables::of($data)
                ->addColumn('role_ids', function ($row) {
                    // Fetch and format role_ids
                    return $row->roles->pluck('id')->implode(', ');
                })
                ->addColumn('role_names', function ($row) {
                    // Fetch and format role_names
                    return $row->roles->pluck('name')->implode(', ');
                })
                ->addColumn('region', function ($row) {
                    // Fetch and format region name
                    return $row->region ? $row->region->id : 'N/A';
                })
                ->addColumn('userEmails', function ($row) {
                    // Fetch user's emails where status is 1
                    $emails = $row->userEmails->where('is_primary', 1)->pluck('email')->implode(', '); // Assuming 'is_primary' is the status
                    return $emails ?: 'No active emails'; // Display message if no emails found
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
            'new_password' => 'required|min:8', // Ensure confirmation password matches
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


    public function addEmail(Request $request)
    {
        // Validate the request inputs
        $request->validate([
            'email' => 'required|email',
            'username' => 'required|exists:users,username', // Ensure the username exists in the users table
        ]);

        try {
            // Check if the email already exists for the given username
            $existingEmail = DB::table('user_emails')
                ->where('username', $request->username)
                ->where('email', $request->email)
                ->first();

            if ($existingEmail) {
                return response()->json(['success' => false, 'message' => 'Email already exists for this user.']);
            }

            // Insert the new email for the user
            DB::table('user_emails')->insert([
                'username' => $request->username,
                'email' => $request->email,
            ]);

            // Log the action using Spatie activity log
            activity()
                ->causedBy(auth()->user()) // The user performing the action
                ->performedOn(User::where('username', $request->username)->first()) // Targeted user
                ->withProperties([
                    'username' => $request->username,
                    'email' => $request->email
                ]) // Additional data you want to log
                ->log('Added a new email to the user'); // The message you want to log

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Log the exception in Spatie activity log
            activity()
                ->causedBy(auth()->user()) // The user performing the action
                ->withProperties([
                    'error' => $e->getMessage(),
                    'username' => $request->username,
                    'email' => $request->email
                ])
                ->log('Failed to add a new email due to an error');

            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }





    public function store(Request $request)
    {
        dd($request->all());
        // Validate the request data
        $rules = [
            'username' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . ($request->id ?? 'NULL'),
            'password' => $request->id ? 'nullable|min:8|confirmed' : 'required|min:8|confirmed',
            'address' => 'nullable|string|max:255',
            'region_id' => 'required|integer',
            'roles' => 'required',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        // Validate the input
        $validated = $request->validate($rules);

        // Handle the profile picture upload
        $profilePicturePath = null; // Initialize profile picture path
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
        } elseif ($request->id) {
            // Set the profile picture path to the existing user's picture if updating
            $profilePicturePath = User::find($request->id)->profile_picture;
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
                'username' => $username,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'password_show' => $validated['password'],
                'address' => $validated['address'] ?? null, // Use null coalescing operator
                'region_id' => $validated['region_id'],
                'profile_picture' => $profilePicturePath,
            ]);
        } else {
            // Find the existing user
            $user = User::findOrFail($request->id);

            // Update the user data
            $user->update([
                'username' => $username,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'] ? bcrypt($validated['password']) : $user->password,
                'password_show' => $validated['password'],
                'address' => $validated['address'] ?? null, // Use null coalescing operator
                'region_id' => $validated['region_id'],
                'profile_picture' => $profilePicturePath,
            ]);
        }

        // Assign roles to the user
        $user->syncRoles((array) $validated['roles']); // Wrap roles in an array

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

    public function deleteRole(Request $request)
    {
        try {
            $user_id = $request->input('user_id');
            $user = User::find($user_id);
            $role = $request->input('role');


            if (!$user || !$role) {
                throw new Exception('Invalid user or role');
            }

            $user->roles()->detach($role);

            activity()
                ->performedOn($user)
                ->causedBy(auth()->user())
                ->withProperties([
                    'role' => $role,
                ])
                ->log('Role deleted');

            return response()->json(['message' => 'Role deleted successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
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
    public function addStore($encryptedUserId)
    {
        try {
            // Assuming you have some decryption mechanism, for example:
            $userId = $encryptedUserId; // Adjust this if needed.

            // Check if userId is valid
            if (!$userId) {
                throw new \Exception('Invalid encrypted user ID.');
            }

            // Fetch the user by ID with roles
            $user = User::with(['userStore', 'userEmails', 'roles'])->where('username', $userId)->first();

            $stores = DB::table('store')->get();

            // If the user does not exist, return error
            if (!$user) {
                throw new \Exception('User not found.');
            }

            // Fetch the roles from Laratrust
            $roles = $user->roles->pluck('name'); // Retrieves role names from Laratrust

            // Log activity using Laratrust
            activity()
                ->causedBy(auth()->user())
                ->performedOn($user)
                ->withProperties(['user_id' => $userId])
                ->log('Attempted to add store for user');

            // Return a view instead of a JSON response
            return view('management_user.users.show', [
                'user' => $user, // Pass the user data to the view
                'message' => 'Store added successfully.',
                'status' => 'addStore',
                'stores' => $stores,
                'roles' => $roles, // Pass the roles to the view
            ]);

        } catch (\Exception $e) {
            // Log the exception for error reporting
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['error' => $e->getMessage()])
                ->log('Failed to add store for user due to an error');

            // Redirect back with error message
            return redirect()->route('users.index')->with('error', $e->getMessage());
        }
    }

    public function formUser($encryptedUserId) {
        try {
            // Assuming you have some decryption mechanism, for example:
            $userId = $encryptedUserId; // Adjust this if needed.

            // Fetch the user by ID with roles
            $user = User::with(['userStore', 'userEmails', 'roles'])
                ->where('username', intval($userId)) // Assuming username is the identifier
                ->first();

            // Fetch the stores
            $stores = DB::table('store')->get();

            // Initialize roles and log user activity
            $roles = collect(); // Default to empty collection
            if ($user) {
                // Fetch the roles from Laratrust
                $roles = $user->roles->pluck('name'); // Retrieves role names from Laratrust

                // Log activity only if the user exists
                activity()
                    ->causedBy(auth()->user())
                    ->performedOn($user)
                    ->withProperties(['user_id' => $userId])
                    ->log('Attempted to add store for user');
            } else {
                // Log a different activity if the user was not found
                activity()
                    ->causedBy(auth()->user())
                    ->withProperties(['user_id' => $userId])
                    ->log('Attempted to add store for a non-existing user');
            }

            // Return the view with user data
            return view('management_user.users.show', [
                'user' => $user, // Pass the user data (new or existing)
                'message' => 'Store added successfully.',
                'status' => 'addStore',
                'stores' => $stores,
                'roles' => $roles, // Pass the roles to the view
            ]);

        } catch (\Exception $e) {
            // Log the exception for error reporting
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['error' => $e->getMessage()])
                ->log('Failed to add store for user due to an error');

            // Redirect back with error message
            return redirect()->route('users.index')->with('error', $e->getMessage());
        }
    }




    public function addEmailView($encryptedUserId)
    {
        try {
            // Assuming you have some decryption mechanism, for example:
            $userId = $encryptedUserId; // Adjust this if needed.

            // Check if userId is valid
            if (!$userId) {
                throw new \Exception('Invalid encrypted user ID.');
            }

            // Fetch the user by ID with roles
            $user = User::with(['userStore', 'userEmails', 'roles'])->where('username', $userId)->first();

            $stores = DB::table('store')->get();
            $region = DB::table('region')->get();

            // If the user does not exist, return error
            if (!$user) {
                throw new \Exception('User not found.');
            }

            // Fetch the roles from Laratrust
            $roles = $user->roles->pluck('name'); // Retrieves role names from Laratrust

            // Log activity using Laratrust
            activity()
                ->causedBy(auth()->user())
                ->performedOn($user)
                ->withProperties(['user_id' => $userId])
                ->log('Attempted to add email for user');

            // Return a view instead of a JSON response
            return view('management_user.users.show', [
                'user' => $user, // Pass the user data to the view
                'message' => 'Email added successfully.',
                'status' => 'addEmail',
                'region' => $region,
                'stores' => $stores,
                'roles' => $roles, // Pass the roles to the view
            ]);

        } catch (\Exception $e) {
            // Log the exception for error reporting
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['error' => $e->getMessage()])
                ->log('Failed to add email for user due to an error');

            // Redirect back with error message
            return redirect()->route('users.index')->with('error', $e->getMessage());
        }
    }




}
