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
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required', // Can be either email or username
            'password' => 'required',
        ]);
    
        // Check if input is an email or username
        $fieldType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    
        if (Auth::attempt([$fieldType => $request->login, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('appToken')->accessToken;
    
            return response()->json([
                'success' => true,
                'token' => $token,
                'user' => $user,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to authenticate.',
            ], 401);
        }
    }
    

}
