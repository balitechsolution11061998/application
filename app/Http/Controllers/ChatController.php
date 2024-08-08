<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    //

    public function getExistingChats()
    {
        // Get the current authenticated user's ID
        $authUserId = auth()->id();

        // Fetch all unique users who have had conversations with the authenticated user
        $chats = DB::table('ch_messages')
            ->select('from_id', 'to_id')
            ->where('from_id', $authUserId)
            ->orWhere('to_id', $authUserId)
            ->groupBy('from_id', 'to_id')
            ->get();

        $userIds = $chats->flatMap(function ($chat) use ($authUserId) {
            return [$chat->from_id, $chat->to_id];
        })->unique()->filter(function ($id) use ($authUserId) {
            return $id != $authUserId; // Exclude the authenticated user
        })->values();

        // Fetch the user details for these users
        $users = User::whereIn('id', $userIds)->get();

        // Fetch the latest message for each user
        $latestMessages = [];
        foreach ($userIds as $userId) {
            $latestMessage = DB::table('ch_messages')
                ->where(function ($query) use ($authUserId, $userId) {
                    $query->where('from_id', $authUserId)
                        ->where('to_id', $userId);
                })
                ->orWhere(function ($query) use ($authUserId, $userId) {
                    $query->where('from_id', $userId)
                        ->where('to_id', $authUserId);
                })
                ->orderBy('created_at', 'desc')
                ->first();

            if ($latestMessage) {
                $latestMessages[$userId] = $latestMessage;
            }
        }

        // Prepare the response data
        $chatData = $users->map(function ($user) use ($latestMessages) {
            $latestMessage = $latestMessages[$user->id] ?? null;
            return [
                'id' => $user->id,
                'name' => $user->name,
                'photo' => $user->photo ? $user->photo : '/image/default-pic.jpg',
                'last_message' => $latestMessage ? $latestMessage->body : '',
                'last_message_time' => $latestMessage ? (new \Carbon\Carbon($latestMessage->created_at))->toDateTimeString() : '',
            ];
        });

        return response()->json([
            'data' => $chatData,
        ]);
    }


    public function searchUsers(Request $request)
    {
        $query = $request->input('query');
        $users = User::where('name', 'LIKE', "%$query%")
            ->take(5) // Limit to 5 results
            ->get();

        return response()->json(['data' => $users]);
    }

    public function getChat($userId)
    {
        // Validate the incoming request

        $authUserId = auth()->id();
        $receiverId = $userId;

        try {
            // Fetch messages where the user is either the sender or receiver
            $messages = DB::table('messages')
                ->where(function ($query) use ($authUserId, $receiverId) {
                    $query->where('sender_id', $authUserId)
                        ->where('receiver_id', $receiverId);
                })
                ->orWhere(function ($query) use ($authUserId, $receiverId) {
                    $query->where('sender_id', $receiverId)
                        ->where('receiver_id', $authUserId);
                })
                ->orderBy('created_at', 'asc') // Order by time
                ->get();

            return response()->json([
                'success' => true,
                'messages' => $messages
            ]);
        } catch (\Exception $e) {
            // Log the exception for debugging
            return response()->json([
                'success' => false,
                'status' => 'Failed to fetch messages'
            ], 500);
        }
    }


    // Send a message from the authenticated user to the selected user
    public function sendMessage(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id', // Ensure the user exists
                'message' => 'required|string|max:1000' // Ensure the message is a string with a max length
            ]);

            // Create a new message instance
            $message = new Message();
            $message->sender_id = auth()->id(); // Set the sender as the logged-in user
            $message->receiver_id = $validatedData['user_id']; // Set the receiver ID
            $message->text = $validatedData['message']; // Set the message text
            $message->save(); // Save the message to the database

            // Return a JSON response indicating success
            return response()->json([
                'success' => true,
                'status' => 'Message sent',
                'message' => $message // Optional: Include the saved message in the response
            ]);
        } catch (\Exception $e) {
            // Log the exception for debugging
            \Log::error('Message sending failed: ' . $e->getMessage());

            // Return a JSON response indicating failure
            return response()->json([
                'success' => false,
                'status' => 'Failed to send message'
            ], 500);
        }
    }

}
