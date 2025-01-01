<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User; // Import the User model
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // For logging errors
use Spatie\Activitylog\Models\Activity; // For logging activities

class LoginController extends Controller
{
    /**
     * Handle user login and token generation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $user = null;  // Initialize user variable in case of error before user assignment

        try {
            // Validate the request
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            // Check credentials
            if (!Auth::attempt($request->only('email', 'password'))) {
                // Log failed login attempt to activity log
                activity()
                    ->withProperties(['ip' => $request->ip()])
                    ->log('Failed login attempt - Invalid email or password.');

                return response()->json([
                    'message' => 'Invalid email or password.',
                ], 401);
            }

            // Fetch the authenticated user
            $user = Auth::user();

            // Log the login activity using Spatie Activity Log
            activity()
                ->causedBy($user)
                ->withProperties(['ip' => $request->ip()])
                ->log('User logged in');

            // Generate a token
            $token = $user->createToken('Personal Access Token')->accessToken;

            // Log successful login to activity log
            activity()
                ->causedBy($user)
                ->withProperties(['ip' => $request->ip()])
                ->log('User successfully logged in and received token.');

            // Return success response
            return response()->json([
                'message' => 'Login successful.',
                'user' => $user,
                'token' => $token,
            ]);
        } catch (\Throwable $e) {
            // Log the error with Spatie Activity Log, only log error if user exists
            if ($user) {
                activity()
                    ->causedBy($user)
                    ->withProperties(['error' => $e->getMessage(), 'ip' => $request->ip()])
                    ->log('Login attempt failed.');
            }

            // Log the error with Spatie or default Laravel logging
            Log::error('Login error: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all(),
            ]);

            // Return a generic error response with the error message
            return response()->json([
                'message' => 'An error occurred during login. Please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
