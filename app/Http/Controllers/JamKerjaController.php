<?php

namespace App\Http\Controllers;

use App\Models\JamKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;

class JamKerjaController extends Controller
{
    //
    public function index(){
        return view('jam_kerja.index');
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data = JamKerja::select(['id', 'kode_jk', 'nama_jk', 'awal_jam_masuk', 'jam_masuk', 'akhir_jam_masuk', 'jam_pulang', 'lintas_hari']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $editBtn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>';
                    $deleteBtn = ' <a href="javascript:void(0)" class="delete btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>';
                    return $editBtn . $deleteBtn;
                })
                ->editColumn('lintas_hari', function($row) {
                    return $row->lintas_hari == 1 ? 'Yes' : 'No';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

    }

    public function store(Request $request)
    {
        $request->validate([
            'kodeJamKerja' => 'required|string|max:255',
            'namaJamKerja' => 'required|string|max:255',
            'awalJamMasuk' => 'required|date_format:H:i',
            'jamMasuk' => 'required|date_format:H:i|after:awalJamMasuk',
            'akhirJamMasuk' => 'required|date_format:H:i|after:jamMasuk',
            'jamPulang' => 'required|date_format:H:i',
            'lintasHari' => 'required|boolean'
        ]);

        DB::beginTransaction();

        try {
            $startTime = microtime(true);

            $jamKerja = new JamKerja();
            $jamKerja->kode_jk = $request->kodeJamKerja;
            $jamKerja->nama_jk = $request->namaJamKerja;
            $jamKerja->awal_jam_masuk = $request->awalJamMasuk;
            $jamKerja->jam_masuk = $request->jamMasuk;
            $jamKerja->akhir_jam_masuk = $request->akhirJamMasuk;
            $jamKerja->jam_pulang = $request->jamPulang;
            $jamKerja->lintas_hari = $request->lintasHari;
            $jamKerja->save();

            $executionTime = microtime(true) - $startTime;

            // Log query and execution time to the database
            foreach (DB::getQueryLog() as $query) {
                QueryLog::create([
                    'sql' => $query['query'],
                    'bindings' => json_encode($query['bindings']),
                    'time' => $query['time'],
                ]);
            }

            DB::commit();

            return response()->json(['success' => 'Data has been successfully submitted!']);

        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }
}
