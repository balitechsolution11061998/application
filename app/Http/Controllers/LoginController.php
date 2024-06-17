<?php

namespace App\Http\Controllers;

use App\Models\ErrorLog;
use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $authService;
    public function _construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function index()
    {
        return view('login');
    }

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function check_login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        try {
            $result = $this->authService->checkLogin($username, $password);

            if ($result['success']) {
                return response()->json([
                    'success' => true
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $result['message']
                ], 401);
            }
        } catch (\Exception $e) {
            // Log the error to the database
            ErrorLog::create([
                'username' => $username,
                'error_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server. Silakan coba lagi nanti.'
            ], 500);
        }
    }

}
