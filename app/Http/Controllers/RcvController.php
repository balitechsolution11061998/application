<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessRcvJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class RcvController extends Controller
{
    //
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->data;

            if (!empty($data)) {
                // Perform any synchronous database operations here if necessary

                // Dispatch the job with data
                ProcessRcvJob::dispatch($data);

                // Commit the transaction if everything is successful
                DB::commit();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Data upload has started',
                ]);
            } else {
                // Roll back the transaction if no data to process
                DB::rollBack();
                return response()->json(['status' => 'error', 'message' => 'No data to process!'], 400);
            }
        } catch (\Exception $e) {
            // Roll back the transaction if there is an exception
            DB::rollBack();

            // Optionally, log the error or perform additional error handling
            // Log::error('Error in store method: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getProgress()
    {
        $progress = Cache::get('sync_progress_receiving', [
            'total_count' => 0,
            'processed_count' => 0,
            'success_count' => 0,
            'fail_count' => 0,
            'errors' => []
        ]);
        return response()->json($progress);
    }

}
