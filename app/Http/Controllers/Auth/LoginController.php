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

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            // Log the login event
            $user = Auth::user();
            $user->is_logged_in = true;
            $user->save();

            $this->logEvent($user, 'login', $request);

            // Redirect to intended location or dashboard
            return redirect()->intended('/home');
        }

        // If login fails, return with error
        return $this->sendFailedLoginResponse($request);
    }

    protected function validateLogin(Request $request)
    {
        // Validate the login request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
    }

    protected function attemptLogin(Request $request)
    {
        $user = User::where('email', $request->email)->first();

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
            'email' => [trans('auth.failed')],
        ]);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            // Log the logout event
            $user->is_logged_in = false;
            $user->save();

            $this->logEvent($user, 'logout', $request);
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
