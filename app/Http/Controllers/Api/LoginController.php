<?php

namespace App\Http\Controllers\Api;

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\SendOtpMail;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);
    
        $fieldType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    
        if (Auth::attempt([$fieldType => $request->login, 'password' => $request->password])) {
            $user = Auth::user();
    
            // Generate OTP
            $otp = rand(100000, 999999);
            $user->otp_code = Hash::make($otp);
            $user->otp_expires_at = Carbon::now()->addMinutes(5); // OTP berlaku 5 menit
            $user->save();
    
            // Kirim OTP ke email
            Mail::to($user->email)->send(new SendOtpMail($otp));
    
            // 🚀 Opsi: Langsung verifikasi jika ingin login tanpa memasukkan OTP secara manual
            return $this->verifyOtpAuto($user, $otp);
        }
    
        return response()->json([
            'success' => false,
            'message' => 'Failed to authenticate.',
        ], 401);
    }
    
    /**
     * Verifikasi OTP otomatis setelah dikirim
     */
    private function verifyOtpAuto($user, $otp)
    {
        // Cek apakah OTP valid
        if (!Hash::check($otp, $user->otp_code)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP.'
            ], 400);
        }
    
        // Hapus OTP setelah diverifikasi
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();
    
        // Buat token Passport dengan waktu kedaluwarsa
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addHours(2); // Token berlaku 2 jam
        $token->save();
    
        // Ambil data lengkap user
        $userData = $user->only([
            'id', 'name', 'email', 'username', 'phone', 'address', 
            'role', 'created_at', 'updated_at'
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Login berhasil, OTP telah diverifikasi.',
            'user' => $userData,
            'token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => $token->expires_at->toDateTimeString(),
        ], 200);
    }
    

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out.'
        ]);
    }
}
