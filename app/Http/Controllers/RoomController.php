<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\QueryException;

class RoomController extends Controller
{
    // Display a listing of the rooms
    public function index()
    {
        return view('rooms.index');
    }

    // Store a new room
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:rooms',
                'description' => 'nullable|string',
            ]);

            $room = Room::create($request->all());

            return response()->json($room, 201);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Could not create room: ' . $e->getMessage()], 500);
        }
    }

    // Display a specific room
    public function show($id)
    {
        try {
            $room = Room::findOrFail($id);
            return response()->json($room);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Room not found'], 404);
        }
    }

    // Update a specific room
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:rooms,name,' . $id,
                'description' => 'nullable|string',
            ]);

            $room = Room::findOrFail($id);
            $room->update($request->all());

            return response()->json($room);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Could not update room: ' . $e->getMessage()], 500);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Room not found'], 404);
        }
    }

    // Soft delete a room
    public function destroy($id)
    {
        try {
            $room = Room::findOrFail($id);
            $room->delete();

            return response()->json(['message' => 'Room deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Room not found'], 404);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Could not delete room: ' . $e->getMessage()], 500);
        }
    }

    // Data for DataTable
    public function data(Request $request)
    {
        $rooms = Room::select(['id', 'name', 'description', 'created_by'])
            ->when($request->input('search.value'), function ($query, $search) {
                $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return DataTables::of($rooms)
            ->addColumn('actions', function ($room) {
                return `
                    <a href="/rooms/${room->id}/edit" class="btn btn-warning btn-sm">Edit</a>
                    <form action="/rooms/${room->id}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                `;
            })
            ->make(true);
    }
}
