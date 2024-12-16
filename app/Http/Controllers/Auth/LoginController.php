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
        return view('auth.login');
    }

    public function showLoginFormKoperasi()
    {
        return view('auth.loginkoperasi');
    }

    public function login(Request $request)
    {
        try {
            $this->validateLogin($request);

            if ($this->attemptLogin($request)) {
                $user = Auth::user();
                $this->setUserLoggedIn($user, true);

                $this->logEvent($user, 'success', $request);

                return $this->redirectUser($user);
            }

            $this->logFailedLogin($request);

            return response()->json([
                'error' => 'Invalid credentials',
            ], 401);
        } catch (\Exception $e) {
            $this->logError($request, $e->getMessage());

            return response()->json([
                'error' => 'An error occurred during the login process. Please try again.',
            ], 500);
        }
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string|min:6',
        ]);
    }

    protected function attemptLogin(Request $request)
    {
        $login = $request->login;

        $user = User::where('email', $login)
            ->orWhere('username', $login)
            ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user, $request->has('remember'));
            return true;
        }

        return false;
    }

    protected function redirectUser(User $user)
    {
        if ($user->hasRole('supplier')) {
            return response()->json([
                'message' => 'Login successful',
                'success' => true,
                'user' => $user,
                'redirect' => route('home.supplier'),
            ], 200);
        }

        return response()->json([
            'message' => 'Login successful',
            'success' => true,
            'user' => $user,
            'redirect' => route('home.index'),
        ], 200);
    }



    protected function logFailedLogin(Request $request)
    {
        LoginLog::create([
            'email' => $request->login,
            'ip_address' => $request->ip(),
            'status' => 'failed', // Ensure this is included
            'logged_at' => now(),
        ]);
    }

    protected function logError(Request $request, $errorMessage)
    {
        LoginLog::create([
            'email' => $request->login,
            'ip_address' => $request->ip(),
            'status' => 'error', // Ensure this is included
            'logged_at' => now(),
            'error_message' => $errorMessage, // Optional: add this field to your LoginLog model
        ]);

        // Log the error using Spatie Activitylog
        activity('logerror')
            ->causedBy($request->user()) // Optional: associate the activity with the user
            ->log('Login error: ' . $request->login . ' - ' . $request->ip() . ' - Error: ' . $errorMessage);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            $this->setUserLoggedIn($user, false);
        }

        Auth::logout();

        return redirect('/login/form');
    }

    protected function setUserLoggedIn(User $user, $status)
    {
        $user->is_logged_in = $status;
        $user->save();
    }

    protected function logEvent(User $user, $event, Request $request)
    {
        LoginLog::create([
            'user_id' => $user->id,
            'event' => $event,
            'status'=>'success',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
    }
}
