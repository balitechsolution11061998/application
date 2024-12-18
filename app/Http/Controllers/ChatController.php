<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        // Validate input
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        try {
            // If receiver_id is 1 or 2, send message to all users with the corresponding role
            if (in_array($request->receiver_id, [1, 2])) {
                $role = $request->receiver_id == 1 ? 'it' : 'dc'; // Determine role based on receiver_id
                $users = User::whereHas('roles', function ($query) use ($role) {
                    $query->where('name', $role); // Get users based on role
                })->get();

                // Check if there are users with the specified role
                if ($users->isEmpty()) {
                    return response()->json(['success' => false, 'message' => "No users found with the role $role."], 404);
                }

                // Send message to each user with the corresponding role
                foreach ($users as $user) {
                    Message::create([
                        'sender_id' => auth()->id(), // Using authenticated user's ID
                        'receiver_id' => $user->id, // Send to user
                        'message' => $request->message,
                    ]);
                }

                // Log the activity
                activity()
                    ->causedBy(auth()->user())
                    ->withProperties(['role' => $role, 'message' => $request->message])
                    ->log("Message sent to all users with the role $role.");

                return response()->json(['success' => true, 'message' => "Message successfully sent to all users with the role $role."]);
            }

            // If not, send message to the specified receiver_id
            $receiver = User::find($request->receiver_id);
            if (!$receiver) {
                return response()->json(['success' => false, 'message' => "No user found with ID {$request->receiver_id}."], 404);
            }

            $message = Message::create([
                'sender_id' => auth()->id(), // Using authenticated user's ID
                'receiver_id' => $request->receiver_id,
                'message' => $request->message,
            ]);

            // Log the activity
            activity()
                . causedBy(auth()->user())
                ->withProperties(['receiver_id' => $request->receiver_id, 'message' => $request->message])
                ->log("Message sent to user ID {$request->receiver_id}.");

            return response()->json(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Message sending failed: ' . $e->getMessage());

            // Log the activity for the error
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['error' => $e->getMessage(), 'receiver_id' => $request->receiver_id])
                ->log("Failed to send message to user ID {$request->receiver_id}.");

            return response()->json(['success' => false, 'message' => 'An error occurred while sending the message.'], 500);
        }
    }



    public function fetchMessages($userId)
    {
        $messages = Message::where(function ($query) use ($userId) {
            $query->where('sender_id', auth()->id())
                ->where('receiver_id', Auth::user()->id);
        })->orWhere(function ($query) use ($userId) {
            $query->where('sender_id',  Auth::user()->id)
                ->where('receiver_id', auth()->id());
        })->orderBy('created_at', 'asc')->get();
        dd($messages);
        return response()->json($messages);
    }

    public function fetchContacts()
    {
        // Define the roles and their display names
        $roles = [
            'it' => 'IT',
            'md' => 'MD',
            'dc' => 'DC',
        ];

        // Fetch users with the specified roles
        $contacts = User::whereHas('roles', function ($query) use ($roles) {
            $query->whereIn('name', array_keys($roles)); // Get users with roles IT, MD, and DC
        })->get(['id', 'name']);

        // Map the contacts to include the display names
        $contacts = $contacts->map(function ($contact) use ($roles) {
            return [
                'id' => $contact->id,
                'name' => $roles[$contact->roles->first()->name] ?? $contact->name, // Set custom name based on role
                'profile_picture' => $roles[$contact->roles->first()->name] ?? $contact->profile_picture, // Set custom name based on role
            ];
        });

        return response()->json($contacts);
    }

}
