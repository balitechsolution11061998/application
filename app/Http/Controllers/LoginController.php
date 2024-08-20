<?php

namespace App\Http\Controllers;

use App\Models\ErrorLog;
use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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

    public function redirectToGithub() {
        return Socialite::driver('github')->redirect();
    }

    public function handleGithubCallback()
    {
        try {
            // Attempt to retrieve the user from GitHub
            $githubUser = Socialite::driver('github')->user();

            // Generate a random password or use a predefined one
            $generatedPassword = '12345678'; // Example password, ideally you generate this

            // Insert or update the user data in the database
            $user = User::updateOrCreate(
                ['email' => $githubUser->getEmail()], // Use email as the unique identifier
                [
                    'username' => $githubUser->getNickname() ?? $githubUser->getName(),
                    'name' => $githubUser->getNickname() ?? $githubUser->getName(),
                    'email' => $githubUser->getEmail(),
                    'photo' => $githubUser->getAvatar(),
                    'password' => Hash::make($generatedPassword), // Store the hashed password
                    'status' => 'y', // Assuming 'y' means active, adjust as needed
                    'remember_token' => Str::random(10),
                ]
            );

            // Log in the user
            Auth::login($user, true);

            // If you need to return the password (not recommended)
            // return response()->json(['password' => $generatedPassword]);

            // Redirect to the desired page after login
            return redirect()->intended('/home');

        } catch (\Exception $e) {
            dd($e->getMessage());
            // Optionally, show a user-friendly error message or redirect to an error page
            return redirect()->route('login')->with('error', 'There was an issue logging in with GitHub. Please try again.');
        }
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

                Auth::login($newUser);
                return redirect()->intended('home');
            }
        } catch (\Exception $e) {
            dd('Exception caught', $e->getMessage());
            return redirect()->route('login')->with('error', 'Something went wrong. Please try again.');
        }
    }

    protected function generateUniqueUsername($name)
    {
        $username = Str::slug($name);
        $count = User::where('username', 'LIKE', "{$username}%")->count();
        return $count ? "{$username}-" . ($count + 1) : $username;
    }

    protected function register(Request $request)
    {
        try {
            // Validate the incoming request data
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'username' => 'required|string|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            // Generate a random 6-digit OTP code
            $otpCode = Str::random(6);

            // Create the user with default status 'n' (not active)
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'username' => $request->input('username'),
                'password' => Hash::make($request->input('password')),
                'otp_code' => $otpCode,
                'status' => 'n',
            ]);

            // Send OTP to the user via email, passing the user and OTP code
            Mail::send('emails.otp', ['user' => $user, 'otpCode' => $otpCode], function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Your OTP Code');
            });

            // Redirect to OTP verification page with a success message
            return redirect()->route('otp.verify')->with('message', 'User registered successfully. Please check your email for the OTP.');
        } catch (\Exception $e) {
            // Log the exception

            // Return a generic error message
            return redirect()->back()->withErrors(['error' => 'An error occurred during registration. Please try again later.']);
        }
    }

    public function showOtpVerificationForm()
    {
        // Show the OTP verification form
        return view('auth.otp-verify');
    }

    public function resendOtp(Request $request)
    {
        // Logic to resend the OTP, e.g., sending an SMS or email
        // ...

        return response()->json(['success' => true, 'message' => 'OTP resent successfully.']);
    }

    public function verifyOtp(Request $request)
    {
        // Validate the OTP
        $request->validate([
            'otp_code' => 'required|string|min:6|max:6',
        ]);

        // Find the user by the OTP code
        $user = User::where('otp_code', $request->input('otp_code'))->first();
        if ($user) {
            // Activate the user if the OTP matches
            $user->update([
                'status' => 'y',
                'otp_code' => null, // Clear the OTP code after verification
            ]);

            // Log the user in
            Auth::login($user);

            // Return a success response in JSON
            return response()->json([
                'success' => true,
                'message' => 'Your account has been activated.',
                'redirect_url' => route('home')
            ]);
        } else {
            // Return an error response in JSON
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP code. Please try again.'
            ], 422); // Unprocessable Entity status code
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
