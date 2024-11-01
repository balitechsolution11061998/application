<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Rcv\RcvService;

class RcvController extends Controller
{
    protected RcvService $rcvService;

    public function __construct(RcvService $rcvService)
    {
        $this->rcvService = $rcvService;
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

ba3919ffdf6e30
