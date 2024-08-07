<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // Set validation
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        // If validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Get credentials from request
        $credentials = $request->only('username', 'password');

        // If auth failed
        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Username atau Password Anda salah'
            ], 401);
        }

        // If auth success
        $user = Auth::guard('api')->user();

        // Get user's roles' display names using Laratrust
        $roles = $user->roles->pluck('display_name')->first();

        // Prepare user data with latitude and longitude
        $userData = $user->toArray();
        $userData['roles'] = $roles;
        $userData['jabatan_name'] = $user->position ? $user->position->name : null;
        $userData['department_name'] = $user->department ? $user->department->name : null;
        $userData['cabang_name'] = $user->cabang ? $user->cabang->name : null;
        $userData['latitude'] = $user->cabang ? $user->cabang->latitude : null;
        $userData['longitude'] = $user->cabang ? $user->cabang->longitude : null;

        return response()->json([
            'success' => true,
            'user' => $userData,
            'token' => $token
        ], 200);
    }

}

