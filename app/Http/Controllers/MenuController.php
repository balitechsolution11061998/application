<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use DataTables;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Menu::whereNull('parent_id')->with('children')->get();
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-warning btn-sm edit" data-id="' . $row->id . '">Edit</button>
                            <button class="btn btn-danger btn-sm delete" data-id="' . $row->id . '">Delete</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('menu.index');
    }

    public function store(Request $request)
    {
        Menu::updateOrCreate(
            ['id' => $request->id],
            [
                'name' => $request->name,
                'url' => $request->url,
                'is_dropdown' => $request->is_dropdown ? 1 : 0,
                'parent_id' => $request->parent_id,
            ]
        );
        return response()->json(['success' => 'Menu saved successfully!']);
    }

    public function edit($id)
    {
        return response()->json(Menu::find($id));
    }

    public function destroy($id)
    {
        Menu::find($id)->delete();
        return response()->json(['success' => 'Menu deleted successfully!']);
    }
}
