<?php
// app/Http/Controllers/RoleController.php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Services\Role\RoleService; // Import the RoleService interface
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Traits\ActivityLogger; // Import the ActivityLogger trait
use App\Traits\TelegramNotificationTrait; // Import the TelegramNotificationTrait
use Illuminate\Database\Eloquent\ModelNotFoundException; // Import for handling not found exceptions
use Illuminate\Support\Facades\Auth; // Import for accessing the authenticated user

class RoleController extends Controller
{
    use ActivityLogger, TelegramNotificationTrait; // Use both traits

    protected $roleService;

    public function __construct(RoleService $roleService) // Use the RoleService interface
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        // Log the activity for accessing the index page
        $this->logActivity(
            'Accessed role index page',
            null,
            'role_index_accessed',
            request(),
            null,
            null,
            [
                'user_id' => Auth::id(), // Log the user ID
                'user_name' => Auth::user()->name, // Log the user name
            ]
        );

        return view('roles.index');
    }

    public function data()
    {
        // Log the activity for accessing the data
        $this->logActivity(
            'Requested role data',
            null,
            'role_data_requested',
            request(),
            null,
            null,
            [
                'user_id' => Auth::id(), // Log the user ID
                'user_name' => Auth::user()->name, // Log the user name
            ]
        );

        $roles = $this->roleService->getAllRoles();
        return DataTables::of($roles)
            ->addColumn('permissions', function ($role) {
                return $role->permissions->pluck('name')->toArray();
            })
            ->make(true);
    }

    public function create()
    {
        // Start measuring time and memory
        $startTime = microtime(true);
        $memoryBefore = memory_get_usage();

        try {
            // Fetch all permissions to pass to the view
            $permissions = Permission::all(); // Retrieve all permissions

            // Log the activity for accessing the create role page
            $this->logActivity(
                'Accessed create role page',
                null,
                'role_create_accessed',
                request(),
                $startTime,
                $memoryBefore,
                [
                    'user_id' => Auth::id(), // Log the user ID
                    'user_name' => Auth::user()->name, // Log the user name
                ]
            );

            return view('roles.create', compact('permissions')); // Pass permissions to the view
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error accessing create role page: ' . $e->getMessage());

            // Send Telegram notification
            $this->sendMessageToTelegram('Error accessing create role page: ' . $e->getMessage(), env('TELEGRAM_CHAT_ID'), request());

            // Log the activity for the error
            $this->logActivity(
                'Failed to access create role page: ' . $e->getMessage(),
                null,
                'role_create_access_failed',
                request(),
                $startTime,
                $memoryBefore,
                [
                    'error_message' => $e->getMessage(),
                    'user_id' => Auth::id(), // Log the user ID
                    'user_name' => Auth::user()->name, // Log the user name
                ]
            );

            return redirect()->route('roles.index')->with('error', 'Failed to access create role page. Please try again.');
        }
    }


    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name', // Ensure the role name is unique
            'permissions' => 'array',
        ]);

        // Start measuring time and memory
        $startTime = microtime(true);
        $memoryBefore = memory_get_usage();

        try {
            // Create the role
            $role = $this->roleService->createRole(['name' => $request->name]);
            $role->permissions()->sync($request->permissions);

            // Log the activity with properties
            $this->logActivity(
                'Role created: ' . $role->name,
                $role,
                'role_created',
                $request,
                $startTime,
                $memoryBefore,
                [
                    'inserted_properties' => [
                        'name' => $role->name,
                        'permissions' => $request->permissions,
                    ],
                    'user_id' => Auth::id(), // Log the user ID
                    'user_name' => Auth::user()->name, // Log the user name
                ]
            );

            // Send Telegram notification for successful role creation
            $this->sendMessageToTelegram(
                'Role created: ' . $role->name . ' by ' . Auth::user()->name,
                env('TELEGRAM_CHAT_ID'),
                $request
            );

            // Return JSON response
            return response()->json(['message' => 'Role created successfully.'], 201);
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error creating role: ' . $e->getMessage());

            // Send Telegram notification for the error
            $this->sendMessageToTelegram('Error creating role: ' . $e->getMessage(), env('TELEGRAM_CHAT_ID'), $request);

            // Log the activity for the error
            $this->logActivity(
                'Failed to create role: ' . $e->getMessage(),
                null,
                'role_creation_failed',
                $request,
                $startTime,
                $memoryBefore,
                [
                    'error_message' => $e->getMessage(),
                    'user_id' => Auth::id(), // Log the user ID
                    'user_name' => Auth::user()->name, // Log the user name
                ]
            );

            // Return JSON response with error message
            return response()->json(['message' => 'Failed to create role. Please try again.'], 500);
        }
    }




    public function edit(Role $role)
    {
        // Fetch all permissions to pass to the view
        $permissions = Permission::all(); // Retrieve all permissions
        return view('roles.edit', compact('role', 'permissions')); // Pass role and permissions to the view
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'array',
        ]);

        // Start measuring time and memory
        $startTime = microtime(true);
        $memoryBefore = memory_get_usage();

        try {
            $this->roleService->updateRole($role, ['name' => $request->name]);
            $role->permissions()->sync($request->permissions);

            // Log the activity with properties
            $this->logActivity(
                'Role updated: ' . $role->name,
                $role,
                'role_updated',
                $request,
                $startTime,
                $memoryBefore,
                [
                    'updated_properties' => [
                        'name' => $request->name,
                        'permissions' => $request->permissions,
                    ],
                    'user_id' => Auth::id(), // Log the user ID
                    'user_name' => Auth::user()->name, // Log the user name
                ]
            );

            return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
        } catch (ModelNotFoundException $e) {
            // Log the error
            \Log::error('Role not found: ' . $e->getMessage());

            // Send Telegram notification
            $this->sendMessageToTelegram('Role not found: ' . $e->getMessage(), env('TELEGRAM_CHAT_ID'), $request);

            // Log the activity for the error
            $this->logActivity(
                'Failed to update role: ' . $e->getMessage(),
                $role,
                'role_update_failed',
                $request,
                $startTime,
                $memoryBefore,
                [
                    'error_message' => $e->getMessage(),
                    'user_id' => Auth::id(), // Log the user ID
                    'user_name' => Auth::user()->name, // Log the user name
                ]
            );

            return redirect()->route('roles.index')->with('error', 'Role not found. Please try again.');
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error updating role: ' . $e->getMessage());

            // Send Telegram notification
            $this->sendMessageToTelegram('Error updating role: ' . $e->getMessage(), env('TELEGRAM_CHAT_ID'), $request);

            // Log the activity for the error
            $this->logActivity(
                'Failed to update role: ' . $e->getMessage(),
                $role,
                'role_update_failed',
                $request,
                $startTime,
                $memoryBefore,
                [
                    'error_message' => $e->getMessage(),
                    'user_id' => Auth::id(), // Log the user ID
                    'user_name' => Auth::user()->name, // Log the user name
                ]
            );

            return redirect()->route('roles.index')->with('error', 'Failed to update role. Please try again.');
        }
    }

    public function destroy(Role $role)
    {
        // Start measuring time and memory
        $startTime = microtime(true);
        $memoryBefore = memory_get_usage();

        try {
            $this->roleService->deleteRole($role);

            // Log the activity with properties
            $this->logActivity(
                'Role deleted: ' . $role->name,
                $role,
                'role_deleted',
                null,
                $startTime,
                $memoryBefore,
                [
                    'deleted_properties' => [
                        'name' => $role->name,
                    ],
                    'user_id' => Auth::id(), // Log the user ID
                    'user_name' => Auth::user()->name, // Log the user name
                ]
            );

            return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
        } catch (ModelNotFoundException $e) {
            // Log the error
            \Log::error('Role not found: ' . $e->getMessage());

            // Send Telegram notification
            $this->sendMessageToTelegram('Role not found: ' . $e->getMessage(), env('TELEGRAM_CHAT_ID'), $request);

            // Log the activity for the error
            $this->logActivity(
                'Failed to delete role: ' . $e->getMessage(),
                $role,
                'role_deletion_failed',
                null,
                $startTime,
                $memoryBefore,
                [
                    'error_message' => $e->getMessage(),
                    'user_id' => Auth::id(), // Log the user ID
                    'user_name' => Auth::user()->name, // Log the user name
                ]
            );

            return redirect()->route('roles.index')->with('error', 'Role not found. Please try again.');
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error deleting role: ' . $e->getMessage());

            // Send Telegram notification
            $this->sendMessageToTelegram('Error deleting role: ' . $e->getMessage(), env('TELEGRAM_CHAT_ID'), $request);

            // Log the activity for the error
            $this->logActivity(
                'Failed to delete role: ' . $e->getMessage(),
                $role,
                'role_deletion_failed',
                null,
                $startTime,
                $memoryBefore,
                [
                    'error_message' => $e->getMessage(),
                    'user_id' => Auth::id(), // Log the user ID
                    'user_name' => Auth::user()->name, // Log the user name
                ]
            );

            return redirect()->route('roles.index')->with('error', 'Failed to delete role. Please try again.');
        }
    }

    public function getRoles()
    {
        $roles = $this->roleService->getAllRoles();
        return $roles;
    }
}
