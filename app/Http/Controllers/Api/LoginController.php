<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User; // Make sure to import the User model

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // Set validation
        $validator = Validator::make($request->all(), [
            'login'     => 'required', // Change to 'login' to accept either email or username
            'password'  => 'required'
        ]);

        // If validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Get credentials from request
        $loginField = $request->input('login'); // This can be either email or username
        $password = $request->input('password');

        // Find user by email or username
        $user = User::where('email', $loginField)->orWhere('username', $loginField)->first();

        // If user not found or password does not match
        if (!$user || !password_verify($password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Username atau Password Anda salah'
            ], 401);
        }

        // If auth success, generate token
        $token = auth()->guard('api')->login($user);

        return response()->json([
            'success' => true,
            'user'    => $user,
            'token'   => $token
        ], 200);
    }
}
