<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\LoginLog;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // Points to your custom login form
    }

    public function showLoginFormKoperasi()
    {
        return view('auth.loginkoperasi'); // Points to your custom login form
    }
    public function login(Request $request)
    {
        try {
            $this->validateLogin($request);

            if ($this->attemptLogin($request)) {
                $user = Auth::user();
                $user->is_logged_in = true;
                $user->save();

                // Log the successful login
                LoginLog::create([
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'ip_address' => $request->ip(),
                    'status' => 'success',
                    'logged_at' => now(),
                ]);

                return response()->json([
                    'message' => 'Login successful',
                    'success' => true,
                    'user' => $user,
                ], 200);
            }

            // Log failed login attempt
            LoginLog::create([
                'email' => $request->login, // Adjusted to match the login field
                'ip_address' => $request->ip(),
                'status' => 'failed',
                'logged_at' => now(),
            ]);

            return response()->json([
                'error' => 'Invalid credentials',
            ], 401);
        } catch (\Exception $e) {
            LoginLog::create([
                'email' => $request->login,
                'ip_address' => $request->ip(),
                'status' => 'error',
                'logged_at' => now(),
            ]);

            return response()->json([
                'error' => 'An error occurred during the login process. Please try again.',
            ], 500);
        }
    }

    protected function validateLogin(Request $request)
    {
        // Validate the login request
        $request->validate([
            'login' => 'required|string', // Adjusted to accept the login field
            'password' => 'required|string|min:6',
        ]);
    }

    protected function attemptLogin(Request $request)
    {
        $login = $request->login;

        // Attempt login with email or username
        $user = User::where('email', $login)
            ->orWhere('username', $login)
            ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Log the user in manually
            Auth::login($user, $request->has('remember'));
            return true;
        }

        return false;
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'login' => [trans('auth.failed')],
        ]);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            // Log the logout event
            $user->is_logged_in = false;
            $user->save();
        }

        Auth::logout();

        return redirect('/login/form');
    }

    // Log login or logout event to the database
    protected function logEvent(User $user, $event, Request $request)
    {
        LoginLog::create([
            'user_id' => $user->id,
            'event' => $event,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
    }
}
