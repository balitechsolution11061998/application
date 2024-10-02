<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
      // Display the list of roles
      public function index()
      {
          $roles = Role::all();
          return view('roles.index', compact('roles'));
      }

      public function data(){
        $roles = Role::with('permissions');

        return DataTables::of($roles)
            ->addColumn('permissions', function($role) {
                return $role->permissions->pluck('name')->toArray(); // Pass array of permission names
            })
            ->make(true);
      }

      // Show the form to create a new role
      public function create()
      {
          $permissions = Permission::all(); // Fetch all permissions
          return view('roles.create', compact('permissions'));
      }

      // Store a newly created role in the database
      public function store(Request $request)
      {
          $request->validate(['name' => 'required|unique:roles']);

          // Create the new role
          $role = Role::create([
              'name' => $request->name,
              'display_name' => $request->display_name, // Optional fields
              'description' => $request->description,
          ]);

          // Attach permissions to the role
          $role->syncPermissions($request->permissions);

          return redirect()->route('roles.index')->with('success', 'Role created successfully');
      }

      // Show the form to edit a role and its permissions
      public function edit($id)
      {
          $role = Role::findOrFail($id);
          $permissions = Permission::all();

          return view('roles.edit', compact('role', 'permissions'));
      }

      // Update the role and its permissions in the database
      public function update(Request $request, $id)
      {
          $request->validate(['name' => 'required|unique:roles,name,' . $id]);

          $role = Role::findOrFail($id);
          $role->update([
              'name' => $request->name,
              'display_name' => $request->display_name,
              'description' => $request->description,
          ]);

          // Sync permissions
          $role->syncPermissions($request->permissions);

          return redirect()->route('roles.index')->with('success', 'Role updated successfully');
      }

      // Delete a role from the database
      public function destroy($id)
      {
          $role = Role::findOrFail($id);
          $role->delete();

          return response()->json([
              'success' => true,
              'message' => 'Role deleted successfully'
          ]);
      }

      // Return JSON of roles for DataTables or other frontend needs
      public function getRoles()
      {
          $roles = Role::with('permissions')->get(); // Load roles with permissions

          return response()->json($roles);
      }
    //

}
