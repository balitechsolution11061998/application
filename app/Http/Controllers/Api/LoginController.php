<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User; // Import the User model
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // For logging errors
use Spatie\Activitylog\Models\Activity; // For logging activities
use Carbon\Carbon; // For handling expiration dates

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
        try {
            // Validate the request
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            // Check credentials
            if (!Auth::attempt($request->only('email', 'password'))) {
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

            // Generate a token with an expiration time (e.g., 1 hour from now)
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->accessToken;

            // Set token expiration (1 hour from now)
            $expires_at = Carbon::now()->addHours(1);

            // Log successful login to activity log
            activity()
                ->causedBy($user)
                ->withProperties(['ip' => $request->ip()])
                ->log('User successfully logged in and received token.');

            // Return success response with token and expires_at
            return response()->json([
                'message' => 'Login successful.',
                'user' => $user,
                'token' => $token,
                'expires_at' => $expires_at->toDateTimeString(),
            ]);
        } catch (\Throwable $e) {
            // Log the error with Spatie Activity Log
            activity()
                ->causedBy($user ?? null)
                ->withProperties(['error' => $e->getMessage(), 'ip' => $request->ip()])
                ->log('Login attempt failed.');

            // Log the error with Spatie or default Laravel logging
            Log::error('Login error: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all(),
            ]);

            // Return a generic error response
            return response()->json([
                'message' => 'An error occurred during login. Please try again.',
            ], 500);
        }
    }
}
