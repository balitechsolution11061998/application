<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        // Validasi input
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        // Jika receiver_id adalah 1 atau 2, kirim pesan ke semua pengguna dengan role yang sesuai
        if (in_array($request->receiver_id, [1, 2])) {
            $role = $request->receiver_id == 1 ? 'it' : 'dc'; // Tentukan role berdasarkan receiver_id
            $users = User::whereHas('roles', function($query) use ($role) {
                $query->where('name', $role); // Ambil pengguna berdasarkan role
            })->get();

            // Kirim pesan ke setiap pengguna dengan role yang sesuai
            foreach ($users as $user) {
                Message::create([
                    'sender_id' => auth()->id(), // Menggunakan ID pengguna yang terautentikasi
                    'receiver_id' => $user->id, // Kirim ke pengguna
                    'message' => $request->message,
                ]);
            }

            return response()->json(['success' => true, 'message' => "Pesan berhasil dikirim ke semua pengguna $role."]);
        }

        // Jika tidak, kirim pesan ke receiver_id yang ditentukan
        $message = Message::create([
            'sender_id' => auth()->id(), // Menggunakan ID pengguna yang terautentikasi
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return response()->json($message);
    }


    public function fetchMessages($userId)
    {
        $messages = Message::where(function ($query) use ($userId) {
            $query->where('sender_id', auth()->id())
                  ->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($userId) {
            $query->where('sender_id', $userId)
                  ->where('receiver_id', auth()->id());
        })->orderBy('created_at', 'asc')->get();

        return response()->json($messages);
    }
}
