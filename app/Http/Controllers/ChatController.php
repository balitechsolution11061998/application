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
            $message = new Message();
            $message->sender_id = auth()->id();
            $message->receiver_id = $request->input('user_id');
            $message->text = $request->input('message');
            $message->save();

            return response()->json([
                'success' => true,
                'status' => 'Message sent'
            ]);
        } catch (\Exception $e) {
            // Log the exception for debugging
            \Log::error('Message sending failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'status' => 'Failed to send message'
            ], 500);
        }
    }
}
