<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        $roles = Role::all();
        return view('auth.register', compact('roles'));
    }

    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Buat pengguna baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Cari role berdasarkan nama dan berikan ke pengguna
        $role = Role::where('name', $request->role)->first();
        if ($role) {
            // Menggunakan syncRoles() untuk sinkronisasi role
            $user->syncRoles([$role->name]);
        }

        // Login otomatis setelah register
        Auth::login($user);

        return redirect()->route('home'); // Redirect ke halaman home setelah login
    }

}
