<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:191|unique:users',
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'whatshapp_no' => 'nullable|string|max:191',
            'channel_id' => 'nullable|string|max:191',
            'status' => 'required|in:y,n',
            'all_supplier' => 'required|in:y,n',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'whatshapp_no' => $request->whatshapp_no,
            'channel_id' => $request->channel_id,
            'status' => $request->status,
            'all_supplier' => $request->all_supplier,
        ]);

        // Optionally, log the user in after registration
        // Auth::login($user);

        return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
    }

    public function redirectToGoogle()
    {
        $driver = Socialite::driver('google');

        if (!$driver) {
            return response()->json(['error' => 'Google driver not configured properly.'], 500);
        }

        return $driver->redirect();
    }


    public function handleGoogleCallback()
    {
        try {

            // Retrieve the user from Google
            $googleUser = Socialite::driver('google')->user();
            // Check if the user already exists in the database
            $user = User::where('email', $googleUser->email)->first();
            if ($user) {
                // User exists, log them in
                Auth::login($user);
            } else {
                // User does not exist, create a new user
                $user = User::create([
                    'username' => $googleUser->getName(), // You can customize this
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->email,
                    'password' => bcrypt(12345678), // Generate a random password
                    'password_show' => 12345678, // Generate a random password
                    'photo' => $googleUser->getAvatar(), // Store the user's avatar
                    // Add any other fields you need to populate
                ]);


                // Log the new user in
                Auth::login($user);
            }

            // Redirect to the desired route after login
            return redirect()->route('home.index'); // Change 'dashboard' to your desired route
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            return redirect()->route('login.form')->withErrors(['msg' => 'Authentication failed. Please try again.']);
        }
    }
}
