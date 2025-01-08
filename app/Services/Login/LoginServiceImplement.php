<?php

namespace App\Services\Login;

use LaravelEasyRepository\ServiceApi;
use App\Repositories\Login\LoginRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class LoginServiceImplement extends ServiceApi implements LoginService
{
    protected string $title = "Login Service";

    protected LoginRepository $mainRepository;

    public function __construct(LoginRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    public function validateLogin(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string|min:6',
        ]);
    }

    public function attemptLogin(Request $request)
    {
        $login = $request->login;
        $remember = $request->has('remember'); // Check if remember me is checked

        $user = $this->mainRepository->findUserByLogin($login);

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user, $remember); // Pass the remember parameter
            return $user;
        }

        return null;
    }


    public function logFailedLogin(Request $request)
    {
        $this->mainRepository->createLoginLog([
            'email' => $request->login,
            'ip_address' => $request->ip(),
            'status' => 'failed',
            'logged_at' => now(),
        ]);
    }

    public function logEvent($user, $event, Request $request)
    {
        $this->mainRepository->createLoginLog([
            'user_id' => $user->id,
            'event' => $event,
            'status' => 'success',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
    }

    public function logError(Request $request, $errorMessage)
    {
        $this->mainRepository->createLoginLog([
            'email' => $request->login,
            'ip_address' => $request->ip(),
            'status' => 'error',
            'logged_at' => now(),
            'error_message' => $errorMessage,
        ]);
    }
}
