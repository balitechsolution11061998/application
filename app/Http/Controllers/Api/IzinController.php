<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Izin;
use App\Http\Controllers\Controller;
use App\Models\Cuti;
use App\Models\User;
use App\Notifications\IzinNotification;
use Carbon\Carbon;

class IzinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $nik = $request->input('nik');

            if ($nik) {
                // Get the izin records for the given nik
                $izins = Izin::where('nik', $nik)->where('kode_izin', '!=', null)->get();
            } else {
                // Get all izin records
                $izins = Izin::where('kode_izin', '!=', null)->get();
            }

            // Format dates and prepare data
            $formattedIzins = $izins->map(function ($izin) {
                return [
                    'id' => $izin->id,
                    'kode_izin' => $izin->kode_izin,
                    'nik' => $izin->nik,
                    'tgl_izin_dari' => Carbon::parse($izin->tgl_izin_dari)->format('d M Y H:i'),
                    'tgl_izin_sampai' => Carbon::parse($izin->tgl_izin_sampai)->format('d M Y H:i'),
                    'status' => $izin->status,
                    'kode_cuti' => $izin->kode_cuti,
                    'keterangan' => $izin->keterangan,
                    'doc_sid' => $izin->doc_sid,
                    'status_approved' => $izin->status_approved,
                    'created_at' => Carbon::parse($izin->created_at)->format('d M Y H:i'),
                    'updated_at' => Carbon::parse($izin->updated_at)->format('d M Y H:i'),
                ];
            });

            // Calculate jumlah_izin
            $jumlah_izin = $izins->count();

            // Return response with jumlah_izin and formatted data
            return response()->json([
                'jumlah_izin' => $jumlah_izin,
                'data' => $formattedIzins
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error retrieving izin data: ' . $e->getMessage()], 500);
        }
    }

    public function indexCuti(Request $request)
    {
        try {
            $nik = $request->input('nik');

            if ($nik) {
                // Get the izin records for the given nik
                $cuti = Izin::where('nik', $nik)->where('kode_cuti','!=',null)->get();
                // Calculate the jumlah_izin
                $jumlah_cuti = $cuti->count();
            } else {
                // Get all izin records
                $cuti = Izin::where('kode_cuti','!=',null)->get();
                // Calculate the jumlah_izin
                $jumlah_cuti = $cuti->count();
            }

            // Return response with jumlah_izin
            return response()->json([
                'jumlah_cuti' => $jumlah_cuti,
                'data' => $cuti
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error retrieving izin data: ' . $e->getMessage()], 500);
        }
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function store(Request $request)
     {
         try {
             // Validate the request
            //  $request->validate([
            //      'kode_izin' => 'required|string',
            //      'nik' => 'required|string',
            //      'tgl_izin_dari' => 'required|date',
            //      'tgl_izin_sampai' => 'required|date',
            //      'keterangan' => 'required|string',
            //      'doc_sid' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048', // Validate file (adjust types and size as needed)
            //  ]);

             // Create a new Izin instance
             $izin = new Izin();
             $izin->kode_izin = $request->input('kode_izin');
             $izin->nik = $request->input('nik');
             $izin->tgl_izin_dari = $request->input('tgl_izin_dari');
             $izin->tgl_izin_sampai = $request->input('tgl_izin_sampai');
             $izin->status = "Progress";
             $izin->keterangan = $request->input('keterangan');

             // Handle file upload
             if ($request->hasFile('doc_sid')) {
                 $file = $request->file('doc_sid');
                 $filePath = $file->store('public/izin_files'); // Save file to storage/app/public/izin_files
                 $izin->doc_sid = $filePath; // Save the file path to the database
             }

             $izin->status_approved = "Progress";
             $izin->save();

             // Find the user to notify
             $user = User::where('nik', $izin->nik)->first();

             // Send notification
             if ($user) {
                 $user->notify(new IzinNotification($izin));
             }

             return response()->json($izin, 201);

         } catch (\Illuminate\Validation\ValidationException $e) {
             // Handle validation errors
             return response()->json([
                 'error' => 'Validation Error',
                 'message' => $e->getMessage(),
                 'errors' => $e->errors()
             ], 422);

         } catch (\Exception $e) {
             // Handle general errors
             return response()->json([
                 'error' => 'Internal Server Error',
                 'message' => 'An unexpected error occurred.',
                 'details' => $e->getMessage()
             ], 500);
         }
     }


    public function storeCuti(Request $request)
    {
        $izin = new Izin();
        $izin->kode_cuti = $request->input('kode_cuti');
        $izin->nik = $request->input('nik');
        $izin->tgl_izin_dari = $request->input('tgl_izin_dari');
        $izin->tgl_izin_sampai = $request->input('tgl_izin_sampai');
        $izin->status = "Progress";
        $izin->keterangan = $request->input('keterangan');
        $izin->doc_sid = $request->input('doc_sid');
        $izin->status_approved = "Progress";
        $izin->save();
        return response()->json($izin, 201);
    }

    public function getData(){
        $cuti = Cuti::all(); // Assuming you have a model named JenisIzin
        return response()->json($cuti);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $izin = Izin::find($id);
        if (!$izin) {
            return response()->json(['error' => 'Izin not found'], 404);
        }
        return response()->json($izin);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $izin = Izin::find($id);
        if (!$izin) {
            return response()->json(['error' => 'Izin not found'], 404);
        }
        $izin->kode_izin = $request->input('kode_izin');
        $izin->nik = $request->input('nik');
        $izin->tgl_izin_dari = $request->input('tgl_izin_dari');
        $izin->tgl_izin_sampai = $request->input('tgl_izin_sampai');
        $izin->status = $request->input('status');
        $izin->kode_cuti = $request->input('kode_cuti');
        $izin->keterangan = $request->input('keterangan');
        $izin->doc_sid = $request->input('doc_sid');
        $izin->status_approved = $request->input('status_approved');
        $izin->save();
        return response()->json($izin);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $izin = Izin::find($id);
        if (!$izin) {
            return response()->json(['error' => 'Izin not found'], 404);
        }
        $izin->delete();
        return response()->json(['message' => 'Izin deleted successfully']);
    }
}
