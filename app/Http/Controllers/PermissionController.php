<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PermissionController extends Controller
{
    //
    public function index()
    {
        $permissions = Permission::all();
        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('permissions.create');
    }
    public function data()
    {
        $permissions = Permission::select(['id', 'name','display_name','description', 'created_at'])->get(); // Ambil created_at
        return datatables()->of($permissions)
            ->addColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->diffForHumans(); // Format tanggal relatif (e.g., 2 days ago)
            })
            ->addColumn('actions', function ($row) {
                return '<div class="btn-group" role="group">
                            <button class="btn btn-sm btn-primary edit-btn" data-id="' . $row->id . '">Edit</button>
                            <button class="btn btn-sm btn-danger delete-btn" data-id="' . $row->id . '">Delete</button>
                        </div>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }



    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        Permission::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
        ]);
        return redirect()->route('permissions.index')->with('success', 'Permission created successfully');
    }

    public function edit($id)
    {
        // Find the permission by ID
        $permission = Permission::find($id);

        // Check if the permission exists
        if (!$permission) {
            return response()->json([
                'success' => false,
                'message' => 'Permission not found'
            ], 404); // Return a 404 response if not found
        }

        // Return the permission data as JSON
        return response()->json([
            'success' => true,
            'data' => $permission
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required']);
        $permission = Permission::find($id);
        $permission->update(
            [
                'name' => $request->name,
                'display_name' => $request->display_name,
                'description' => $request->description,
            ]
        );
        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully');
    }

    public function destroy($id)
    {
        // Find the permission by ID
        $permission = Permission::find($id);

        // Check if the permission exists
        if (!$permission) {
            return response()->json([
                'success' => false,
                'message' => 'Permission not found'
            ], 404); // Return a 404 status code if not found
        }

        // Delete the permission
        $permission->delete();

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Permission deleted successfully'
        ]);
    }

}
