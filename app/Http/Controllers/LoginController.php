<?php

namespace App\Http\Controllers;

use App\Models\ErrorLog;
use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Laratrust\Models\Role;

class LoginController extends Controller
{
    protected $authService;
    public function _construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function index()
    {
        return view('auth.login');
    }

    // public function index()
    // {
    //     return view('auth.login1');
    // }



    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function loginWithQrCode(Request $request)
    {
        try {
            $qrCodeData = $request->input('qr_code_data');
            $user = User::where('qr_code_token', $qrCodeData)->first();

            if ($user) {
                Auth::login($user);
                $hashedId = Hash::make($user->id);
                return response()->json(['success' => true, 'id' => $hashedId]);
            } else {
                return response()->json(['success' => false, 'message' => 'Invalid QR code.']);
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred.']);
        }
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
            $findUser = User::where('google_id', $user->id)->first();

            if ($findUser) {
                Auth::login($findUser);
                return redirect()->intended('home');
            } else {
                // Membuat user baru
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'username' => $this->generateUniqueUsername($user->name),
                    'password' => Hash::make('123456dummy')
                ]);

                // Set role 'guest' menggunakan Laratrust
                $newUser->attachRole('guest');

                Auth::login($newUser);
                return redirect()->intended('home');
            }
        } catch (\Exception $e) {
            dd('Exception caught', $e->getMessage());
            return redirect()->route('login')->with('error', 'Something went wrong. Please try again.');
        }
    }



    public function check_login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $remember_me = $request->input('remember_me', false); // Default to false if not provided
        try {
            // Pass the "remember" parameter to the authService
            $result = $this->authService->checkLogin($username, $password, $remember_me);
            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'message' => "Success login, Welcome " . $username
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
