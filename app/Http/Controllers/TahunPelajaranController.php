<?php

namespace App\Http\Controllers;

use App\Models\TahunPelajaran;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Facades\LogActivity;

class TahunPelajaranController extends Controller
{
    public function __construct()
    {
        // Optionally add permissions check if needed
        // $this->middleware('can:manage_years');
    }

    public function index()
    {
        try {
            return view('tahun-pelajaran.index');
        } catch (\Exception $e) {
            activity()->causedBy(auth()->user())->log("Failed to load Tahun Pelajaran index page: " . $e->getMessage());
            return redirect()->back()->withErrors('An error occurred while loading the page.');
        }
    }

    public function create()
    {
        try {
            return view('tahun-pelajaran.create');
        } catch (\Exception $e) {
            activity()->causedBy(auth()->user())->log("Failed to load Tahun Pelajaran create page: " . $e->getMessage());
            return redirect()->back()->withErrors('An error occurred while loading the page.');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'tahun_ajaran' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^\d{4}-\d{4}$/', // Enforces the format YYYY-YYYY
                ],
            ]);

            TahunPelajaran::create($request->all());

            // Log success activity
            activity()
                ->causedBy(auth()->user())
                ->log("Tahun Pelajaran created successfully: {$request->tahun_ajaran}");

            // Return JSON success response
            return response()->json([
                'success' => true,
                'message' => 'Tahun Pelajaran created successfully',
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return JSON with validation error messages
            return response()->json([
                'success' => false,
                'errors' => $e->errors(), // Array of specific validation errors
                'message' => 'Validation failed',
            ], 422);
        } catch (\Exception $e) {
            // Log and return general error message
            activity()
                ->causedBy(auth()->user())
                ->log("Failed to create Tahun Pelajaran: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving the data. ' . $e->getMessage(),
            ], 500);
        }
    }




    public function show($id)
    {
        try {
            $tahunPelajaran = TahunPelajaran::query();
            return DataTables::eloquent($tahunPelajaran)
                ->addColumn('action', function ($row) {
                    return '
                        <a href="' . route('tahun-pelajaran.edit', $row->id) . '" class="btn btn-warning btn-sm">Edit</a>
                        <form action="' . route('tahun-pelajaran.destroy', $row->id) . '" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure?\');">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        } catch (\Exception $e) {
            activity()->causedBy(auth()->user())->log("Failed to fetch Tahun Pelajaran data: " . $e->getMessage());
            return response()->json(['error' => 'An error occurred while fetching data.'], 500);
        }
    }

    public function edit($id)
    {
        try {
            $tahunPelajaran = TahunPelajaran::findOrFail($id);
            return view('tahun-pelajaran.edit', compact('tahunPelajaran'));
        } catch (\Exception $e) {
            activity()->causedBy(auth()->user())->log("Failed to load Tahun Pelajaran edit page for ID {$id}: " . $e->getMessage());
            return redirect()->back()->withErrors('An error occurred while loading the page.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'tahun_ajaran' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^\d{4}-\d{4}$/', // Enforces the format YYYY-YYYY
                ],
            ]);

            $tahunPelajaran = TahunPelajaran::findOrFail($id);
            $tahunPelajaran->update($request->all());

            return redirect()->route('tahun-pelajaran.index')->with('success', 'Tahun Pelajaran updated successfully');
        } catch (\Exception $e) {
            activity()->causedBy(auth()->user())->log("Failed to update Tahun Pelajaran for ID {$id}: " . $e->getMessage());
            return redirect()->back()->withErrors('An error occurred while updating the data.');
        }
    }

    public function destroy($id)
    {
        try {
            $tahunPelajaran = TahunPelajaran::findOrFail($id);
            $tahunPelajaran->delete();

            return redirect()->route('tahun-pelajaran.index')->with('success', 'Tahun Pelajaran deleted successfully');
        } catch (\Exception $e) {
            activity()->causedBy(auth()->user())->log("Failed to delete Tahun Pelajaran for ID {$id}: " . $e->getMessage());
            return redirect()->back()->withErrors('An error occurred while deleting the data.');
        }
    }

    public function getData()
    {
        try {
            $tahunPelajaran = TahunPelajaran::query();
            return DataTables::eloquent($tahunPelajaran)
                ->addColumn('action', function ($row) {
                    return '
                        <a href="' . route('tahun-pelajaran.edit', $row->id) . '" class="btn btn-warning btn-sm">Edit</a>
                        <form action="' . route('tahun-pelajaran.destroy', $row->id) . '" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure?\');">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        } catch (\Exception $e) {
            activity()->causedBy(auth()->user())->log("Failed to fetch Tahun Pelajaran data for DataTables: " . $e->getMessage());
            return response()->json(['error' => 'An error occurred while fetching data.'], 500);
        }
    }
}
