<?php

namespace App\Http\Controllers;

use App\Services\Permission\PermissionService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PermissionController extends Controller
{
    protected PermissionService $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index()
    {
        $permissions = $this->permissionService->all();
        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function data()
    {
        $permissions = $this->permissionService->getAllForDataTable();
        return datatables()->of($permissions)
            ->addColumn('created_at', fn($row) => Carbon::parse($row->created_at)->diffForHumans())
            ->addColumn('actions', fn($row) => '<div class="btn-group" role="group">
                <button class="btn btn-sm btn-primary edit-btn" data-id="' . $row->id . '">Edit</button>
                <button class="btn btn-sm btn-danger delete-btn" data-id="' . $row->id . '">Delete</button>
            </div>')
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        $this->permissionService->create($request->only(['name', 'display_name', 'description']));
        return redirect()->route('permissions.index')->with('success', 'Permission created successfully');
    }

    public function edit($id)
    {
        dd($id);
        $permission = $this->permissionService->find($id);
        return $permission
            ? response()->json(['success' => true, 'data' => $permission])
            : response()->json(['success' => false, 'message' => 'Permission not found'], 404);
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required']);
        $this->permissionService->update($id, $request->only(['name', 'display_name', 'description']));
        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully');
    }

    public function destroy($id)
    {
        $result = $this->permissionService->delete($id);
        return $result
            ? response()->json(['success' => true, 'message' => 'Permission deleted successfully'])
            : response()->json(['success' => false, 'message' => 'Permission not found'], 404);
    }
}
