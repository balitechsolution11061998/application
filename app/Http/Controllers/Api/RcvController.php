<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RcvHead;
use Illuminate\Http\Request;
use App\Services\Rcv\RcvService;
use Illuminate\Support\Facades\Auth;

class RcvController extends Controller
{
    protected RcvService $rcvService;

    public function __construct(RcvService $rcvService)
    {
        $this->rcvService = $rcvService;
    }
    public function getData(Request $request)
    {
        try {
            $user = Auth::user();
            $receiveDate = $request->filterDate;
            $data = [];
            $count = 0;

            // Increase the chunk size for faster processing, adjust as needed
            $chunkSize = 1000;

            // Start time for monitoring
            $startTime = microtime(true);

            RcvHead::with(['details'])->where('receive_date', $receiveDate)
                ->chunk($chunkSize, function ($chunk) use (&$data, &$count, $startTime) {
                    foreach ($chunk as $rcvHead) {
                        $data[] = $rcvHead;
                        $count++;

                        // Check if we have reached 10,000 records or 10 seconds
                        if ($count >= 10000 || (microtime(true) - $startTime) >= 10) {
                            return false; // Stop chunking
                        }
                    }
                });

            return response()->json([
                'title' => 'Sync Rcv Successfully',
                'message' => 'Data Rcv Found',
                'data' => $data,
                'count' => $count,
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'title' => 'Error',
                'message' => 'Failed to load data order',
                'error' => $e->getMessage(),
                'success' => false
            ], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $this->rcvService->store($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Berhasil insert data',
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 409);
        }
    }
}
