<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use App\Jobs\UsersImportJob;
use App\Mail\AccountDetailsMail;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\SystemUsage;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Exception;
use Hashids\Hashids;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Str;

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

    public function addSuppliers(Request $request)
    {
        // Start measuring time and memory usage
        $startTime = microtime(true);
        $startMemory = memory_get_usage();

        // Validate the incoming request
        $request->validate([
            'userId' => 'required|integer|exists:users,id', // Ensure userId exists in users table
            'suppliers' => 'required|array', // Ensure suppliers is an array
            'suppliers.*' => 'string', // Each supplier should be a string
        ]);

        try {
            // Get the user ID and suppliers from the request
            $userId = $request->input('userId');
            $suppliers = $request->input('suppliers');

            // Convert the array of suppliers to a string, separated by commas
            $supplierIdsString = implode(',', $suppliers); // Join the supplier codes into a string
            $supplierNames = [];

            foreach ($suppliers as $supplier) {
                // Search for the supplier by supp_code
                $foundSupplier = Supplier::where('supp_code', $supplier)->first();

                if ($foundSupplier) {
                    // If supplier exists, add its name to the array
                    $supplierNames[] = $foundSupplier->supp_name; // Use the name from the found supplier
                } else {
                    // If supplier not found, return an error response
                    return response()->json(['success' => false, 'message' => 'Supplier with code ' . $supplier . ' not found.'], 404);
                }
            }

            // Convert the arrays to strings, separated by commas
            $supplierNamesString = implode(',', $supplierNames); // Join the supplier names into a string

            // Update the user with the supplier_ids string and additional properties
            $user = User::find($userId);
            $user->supplier_id = $supplierIdsString; // Set the supplier_id as a string
            $user->supplier_names = $supplierNamesString; // Set the supplier_names as a string
            $user->suppliers_added_at = now(); // Set the timestamp for when suppliers were added
            $user->save(); // Save the changes

            // Calculate processing time and memory usage
            $endTime = microtime(true);
            $endMemory = memory_get_usage();
            $executionTime = $endTime - $startTime; // Time in seconds
            $memoryUsed = $endMemory - $startMemory; // Memory used in bytes

            // Log the activity with additional information
            activity()
                ->performedOn($user)
                ->causedBy(Auth::user()) // Log the user who performed the action
                ->log('Subject: User ID ' . $userId . ' - Added suppliers: ' . $supplierIdsString . ' (Names: ' . $supplierNamesString . ') to user ID: ' . $userId .
                    '. Execution time: ' . round($executionTime, 2) . ' seconds. Memory used: ' . $memoryUsed . ' bytes.');

            return response()->json(['success' => true, 'message' => 'Suppliers added successfully.']);
        } catch (Exception $e) {
            // Log the error message

            // Log the activity for error
            activity()
                ->performedOn(User::find($userId))
                ->causedBy(Auth::user())
                ->log('Subject: User ID ' . $userId . ' - Error adding suppliers: ' . $e->getMessage());

            return response()->json(['success' => false, 'message' => 'Failed to add suppliers.'], 500);
        }
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
        // Generate a batch UUID
        $batchUuid = Str::uuid();

        // Start timing and memory tracking
        $startTime = microtime(true);
        $startMemory = memory_get_usage();

        try {
            // Fetch the authenticated user's details
            $user = auth()->user();

            if (!$user) {
                // Throw an exception if the user is not authenticated
                throw new \Exception('User is not authenticated.');
            }

            // Log the activity with a specific log name, event, properties, and subject type
            activity('User Profile') // Set the log_name
                ->causedBy($user)    // Set the authenticated user as the causer
                ->performedOn($user) // Set the subject as the authenticated user
                ->event('view')      // Set the event name
                ->withProperties([
                    'user_id' => $user->id,
                    'email'   => $user->email,
                    'action'  => 'Viewed their profile',
                ])
                ->log('Viewed their profile.');

            // End timing and memory tracking
            $endTime = microtime(true);
            $endMemory = memory_get_usage();

            // Calculate load time in milliseconds and memory usage in MB
            $loadTimeMs = round(($endTime - $startTime) * 1000);
            $ramUsageMb = round(($endMemory - $startMemory) / 1024 / 1024, 2);

            // Log system usage
            SystemUsage::create([
                'memory_usage_mb' => $ramUsageMb,
                'load_time_ms'    => $loadTimeMs,
                'accessed_at'     => now(),
                'function'        => 'profile',
            ]);

            // Return the profile view with the user's data
            return view('management_user.users.profile', compact('user'));
        } catch (\Exception $e) {
            // Log the error activity with a specific log name and properties
            activity('User Profile') // Set the log_name
                ->causedBy(auth()->user() ?? null) // Ensure a valid causer even if null
                ->event('error')      // Set the event name
                ->withProperties([
                    'error_message' => $e->getMessage(),
                    'action'        => 'Failed to load profile page',
                ])
                ->log('Failed to load the profile page: ' . $e->getMessage());

            // End timing and memory tracking in case of failure
            $endTime = microtime(true);
            $endMemory = memory_get_usage();

            // Calculate load time and memory usage
            $loadTimeMs = round(($endTime - $startTime) * 1000);
            $ramUsageMb = round(($endMemory - $startMemory) / 1024 / 1024, 2);

            // Log system usage
            SystemUsage::create([
                'memory_usage_mb' => $ramUsageMb,
                'load_time_ms'    => $loadTimeMs,
                'accessed_at'     => now(),
                'function'        => 'profile',

            ]);

            // Redirect the user to a fallback page or show an error message
            return redirect()->back()->with('error', 'Failed to load profile page.');
        }
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
                    'message' => 'Email deleted successfully',
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
        if (!$request->ajax()) {
            return response()->json(['error' => 'Invalid request type'], 400);
        }

        try {
            // Log user activity
            activity()
                ->causedBy(auth()->user())
                ->withProperties([
                    'ip' => $request->ip(),
                    'url' => $request->fullUrl(),
                    'action' => 'Accessed getUsersData function',
                ])
                ->log('User accessed the getUsersData function');

            // Start timing and memory tracking
            $startTime = microtime(true);
            $startMemory = memory_get_usage();

            // Fetch user data with relationships
            $data = User::with(['roles', 'region', 'userEmails'])
                ->select('id', 'profile_picture', 'username', 'name', 'email', 'password_show', 'region', 'created_at', 'supplier_id', 'supplier_names');

            $result = Datatables::of($data)
                // Render profile picture URL
                ->addColumn('profile_picture', function ($row) {
                    return $row->profile_picture ?
                        '<img src="' . $row->profile_picture . '" alt="Profile Picture" style="width:50px;height:50px;border-radius:50%;">' :
                        '<img src="' . "/img/logo/m-mart.svg" . '" alt="Default Profile Picture" style="width:50px;height:50px;border-radius:50%;">';
                })

                // Add role IDs and names
                ->addColumn('role_ids', fn($row) => $row->roles->pluck('id')->implode(', '))
                ->addColumn('role_names', fn($row) => $row->roles->pluck('name')->implode(', '))

                // Add userEmails column
                ->addColumn('userEmails', function ($row) {
                    $emails = $row->userEmails->where('is_primary', 1)->pluck('email')->implode(', ');
                    return $emails ?: 'No active emails';
                })

                // Add actions column
                ->addColumn('actions', function ($row) {
                    $userRoles = $row->roles->pluck('name')->toArray();
                    $isAdmin = in_array('superadministrator', $userRoles);

                    $actions = '';
                    $rowId = e($row->id); // Escape row ID

                    $actions .= '<button type="button" class="btn btn-sm btn-primary" onclick="editUser(' . $rowId . ')">
                                    <i class="fas fa-edit"></i> Edit
                                </button>';

                    if ($isAdmin) {
                        $actions .= '<button type="button" class="btn btn-sm btn-danger" onclick="deleteUser(' . $rowId . ')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                    <button type="button" class="btn btn-sm btn-warning" onclick="changePassword(' . $rowId . ')">
                                        <i class="fas fa-key"></i> Change Password
                                    </button>';
                    }

                    return $actions;
                })

                ->rawColumns(['profile_picture', 'actions']) // Specify raw HTML columns
                ->make(true);

            // End timing and memory tracking
            $endTime = microtime(true);
            $endMemory = memory_get_usage();

            $loadTimeMs = round(($endTime - $startTime) * 1000);
            $ramUsageMb = round(($endMemory - $startMemory) / 1024 / 1024, 2);

            SystemUsage::create([
                'memory_usage_mb' => $ramUsageMb,
                'load_time_ms' => $loadTimeMs,
                'accessed_at' => now(),
                'function' => 'data',
            ]);

            return $result;
        } catch (\Throwable $e) {


            activity()
                ->causedBy(auth()->user())
                ->withProperties([
                    'ip' => $request->ip(),
                    'url' => $request->fullUrl(),
                    'action' => 'Failed to access getUsersData function',
                    'error' => $e->getMessage(),
                ])
                ->log('Error occurred while accessing getUsersData function');

            return response()->json([
                'error' => 'An error occurred while fetching user data.',
                'message' => $e->getMessage(),
            ], 500);
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
        // Validate the request data
        $rules = [
            'username' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . ($request->id ?? 'NULL'),
            'password' => $request->id ? 'nullable|min:8|confirmed' : 'required|min:8|confirmed',
            'address' => 'nullable|string|max:255',
            'region_id' => 'required|integer',
            'roles' => 'required',
            'profile_picture' => 'nullable|string',
        ];
        // Validate the input
        $validated = $request->validate($rules);

        // Handle the profile picture upload
        $profilePicturePath = null; // Initialize profile picture path
        if ($request->profile_picture) {
            $profilePicturePath = $request->profile_picture;
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
                'region' => $validated['region_id'],
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
                'region' => $validated['region_id'],
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
                'region' => $user->region,
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

    public function formUser($encryptedUserId)
    {
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


    public function sendAccount(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'username' => 'required|integer',
        ]);

        // Retrieve the user by ID
        $user = User::where('username', (int)$request->username)->first();

        // Retrieve all emails associated with the username
        $userEmails = DB::table('user_emails')->where('username', (int)$request->username)->get();

        // Check if user exists
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        // Capture the start time
        $startTime = microtime(true);
        $initialMemory = memory_get_usage(); // Memory in bytes

        try {
            // Logic to send email to all retrieved emails
            foreach ($userEmails as $email) {
                Mail::to($email->email)->send(new AccountDetailsMail($user->username, $user->email, $user->password_show));
            }

            // Log success activity
            $executionTime = microtime(true) - $startTime; // Execution time in seconds
            $finalMemory = memory_get_usage(); // Final memory usage in bytes

            activity('Send Account') // Set the log_name
                ->performedOn($user)
                ->withProperties([
                    'event' => 'Account Details Sent',
                    'subject' => 'Account details sent via email',
                    'initial_memory' => round($initialMemory / 1024 / 1024, 2) . ' MB', // Convert to MB with text
                    'final_memory' => round($finalMemory / 1024 / 1024, 2) . ' MB', // Convert to MB with text
                    'execution_time' => round($executionTime, 2) . ' seconds', // Round to 2 decimal places with text
                ])
                ->log('Account details sent via email to all associated emails.');

            return response()->json(['success' => true]);
        } catch (Exception $e) {
            // Log error activity
            $executionTime = microtime(true) - $startTime; // Execution time in seconds
            $finalMemory = memory_get_usage(); // Final memory usage in bytes

            activity('Send Account')
                ->performedOn($user)
                ->withProperties([
                    'event' => 'Failed to Send Account Details',
                    'subject' => 'Failed to send account details via email',
                    'initial_memory' => round($initialMemory / 1024 / 1024, 2) . ' MB', // Convert to MB with text
                    'final_memory' => round($finalMemory / 1024 / 1024, 2) . ' MB', // Convert to MB with text
                    'execution_time' => round($executionTime, 2) . ' seconds', // Round to 2 decimal places with text
                    'error_message' => $e->getMessage(),
                ])
                ->log('Failed to send account details.');

            return response()->json(['success' => false, 'message' => 'Failed to send account details.'], 500);
        }
    }

    public function updateSupplierProfile(Request $request, Supplier $supplier)
    {
        dd($request->all());
        // Validate the incoming request
        $request->validate([
            'whatsapp' => 'required|string|max:15',
            'mobile' => 'required|string|max:15',
            'address1' => 'required|string|max:255',
            'address2' => 'nullable|string|max:255',
            'postcode' => 'required|string|max:10',
            'city' => 'required|string|max:100',
            'tax_no' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'country' => 'required|string|max:100',
            'state_region' => 'required|string|max:100',
        ]);

        // Update the supplier profile
        $supplier->update($request->all());

        return response()->json(['success' => true, 'message' => 'Profile updated successfully.']);
    }


    public function supplierProfile($supplier)
    {
        try {
            // Decode the supplier username if necessary
            $decodedSupplier = urldecode($supplier);

            // Fetch the supplier data from the database with a join to the users table
            $supplierData = Supplier::join('users', 'supplier.supp_code', '=', 'users.username') // Join on supp_code
                ->where('supplier.supp_code', $decodedSupplier)
                ->first(); // Use first() instead of firstOrFail()

            // Check if supplier data was found
            if (!$supplierData) {
                // Log the activity of trying to view a non-existent supplier profile
                activity()
                    ->causedBy(auth()->user()) // Log the user who performed the action
                    ->log('Attempted to view non-existent supplier profile: ' . $decodedSupplier); // Custom log message

                // Return the view with a message indicating no data found
                return view('frontend.profile.supplier', [
                    'supplierData' => null, // Pass null to indicate no data
                    'message' => 'Supplier profile not found.' // Custom message
                ]);
            }

            // Log the activity of viewing the supplier profile
            activity()
                ->performedOn($supplierData) // Log the action on the supplier data
                ->causedBy(auth()->user()) // Log the user who performed the action
                ->log('Viewed supplier profile'); // Custom log message

            // Return the view with the supplier data
            return view('frontend.profile.supplier', compact('supplierData'));
        } catch (Exception $e) {
            // Log the error message using Spatie Activity Log
            activity()
                ->causedBy(auth()->user()) // Log the user who caused the error
                ->log('Error fetching supplier profile: ' . $e->getMessage()); // Log the error message

            // Optionally, you can redirect back with an error message
            return redirect()->back()->with('error', 'Unable to fetch supplier profile. Please try again later.');
        }
    }


}
