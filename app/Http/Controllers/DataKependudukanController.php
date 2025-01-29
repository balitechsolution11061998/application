<?php

namespace App\Http\Controllers;

use App\Imports\DataKependudukanImport;
use App\Models\DataKependudukan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class DataKependudukanController extends Controller
{
    //
    public function index()
    {
        return view('data-kependudukan.index');
    }
    public function show($id)
    {
        // Fetch the data by ID
        $data = DataKependudukan::findOrFail($id);

        // Return a view or JSON response
        return view('data-kependudukan.show', compact('data'));
    }

    public function getData()
    {
        $data = DataKependudukan::query();

        return DataTables::of($data)
            ->filter(function ($query) {
                if (request()->has('search') && request()->get('search')['value']) {
                    $search = request()->get('search')['value'];
                    $query->where(function ($q) use ($search) {
                        $q->where('nama', 'like', '%' . $search . '%')
                          ->orWhere('nik', 'like', '%' . $search . '%')
                          ->orWhere('jenis_kelamin', 'like', '%' . $search . '%')
                          ->orWhere('tempat_lahir', 'like', '%' . $search . '%')
                          ->orWhere('tanggal_lahir', 'like', '%' . $search . '%')
                          ->orWhere('agama', 'like', '%' . $search . '%')
                          ->orWhere('no_kk', 'like', '%' . $search . '%')
                          ->orWhere('pendidikan', 'like', '%' . $search . '%')
                          ->orWhere('pekerjaan', 'like', '%' . $search . '%')
                          ->orWhere('golongan_darah', 'like', '%' . $search . '%')
                          ->orWhere('status_kawin', 'like', '%' . $search . '%')
                          ->orWhere('nama_ibu', 'like', '%' . $search . '%')
                          ->orWhere('nama_bapak', 'like', '%' . $search . '%')
                          ->orWhere('alamat', 'like', '%' . $search . '%')
                          ->orWhere('keterangan', 'like', '%' . $search . '%');
                    });
                }
            })
            ->addColumn('actions', function ($row) {
                $editUrl = route('data-kependudukan.edit', $row->id);
                $deleteUrl = route('data-kependudukan.destroy', $row->id);
                return view('data-kependudukan.actions', compact('editUrl', 'deleteUrl'))->render();
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function create()
    {
        return view('data-kependudukan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|unique:data_kependudukan|numeric|digits:16',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:50',
            'no_kk' => 'required|numeric|digits:16',
            'pendidikan' => 'nullable|string|max:100',
            'pekerjaan' => 'nullable|string|max:100',
            'golongan_darah' => 'nullable|string|max:3',
            'status_kawin' => 'required|in:KAWIN,BELUM KAWIN,KAWIN TERCATAT',
            'nama_ibu' => 'nullable|string|max:255',
            'nama_bapak' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'ktp_elektronik' => 'nullable|boolean',
            'keterangan' => 'nullable|string',
        ]);

        try {
            $data = DataKependudukan::create($request->all());

            // Log successful creation
            activity()
                ->causedBy(auth()->user())
                ->performedOn($data)
                ->withProperties([
                    'action' => 'create',
                    'data' => $data,
                ])
                ->log('Data successfully added to DataKependudukan table');

            return response()->json([
                'success' => true,
                'message' => 'Data successfully added!',
            ]);
        } catch (\Exception $e) {
            // Log the error
            activity()
                ->causedBy(auth()->user())
                ->withProperties([
                    'endpoint' => $request->url(),
                    'input' => $request->except(['_token']),
                    'error_message' => $e->getMessage(),
                    'error_trace' => $e->getTraceAsString(),
                ])
                ->log('Failed to store data in DataKependudukan table');

            return response()->json([
                'success' => false,
                'message' => 'Failed to add data, please try again.',
            ], 500);
        }
    }


    public function edit($id)
    {
        $data = DataKependudukan::findOrFail($id);
        return view('data-kependudukan.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = DataKependudukan::findOrFail($id);
        $data->update($request->all());
        return redirect()->route('data-kependudukan.index')->with('success', 'Data successfully updated!');
    }

    public function destroy($id)
    {
        $data = DataKependudukan::findOrFail($id);
        $data->delete();
        return redirect()->route('data-kependudukan.index')->with('success', 'Data successfully deleted!');
    }

    public function import()
    {
        return view('data-kependudukan.import');
    }

    public function importStore(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            Excel::import(new DataKependudukanImport, $request->file('file'));
            return redirect()->route('data-kependudukan.index')->with('success', 'Data imported successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to import data: ' . $e->getMessage());
        }
    }
}
