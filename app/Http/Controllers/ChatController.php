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
        $chats = DB::table('messages')
            ->select('sender_id', 'receiver_id')
            ->where('sender_id', $authUserId)
            ->orWhere('receiver_id', $authUserId)
            ->groupBy('sender_id', 'receiver_id')
            ->get();

        // Get all unique user IDs involved in chats with the authenticated user
        $userIds = $chats->flatMap(function ($chat) use ($authUserId) {
            return [$chat->sender_id, $chat->receiver_id];
        })->unique()->filter(function ($id) use ($authUserId) {
            return $id != $authUserId; // Exclude the authenticated user
        })->values();

        // Fetch the user details for these users, including active_status
        $users = User::whereIn('id', $userIds)->get();

        // Fetch the latest message for each user
        $latestMessages = [];
        foreach ($userIds as $userId) {
            $latestMessage = DB::table('messages')
                ->where(function ($query) use ($authUserId, $userId) {
                    $query->where('sender_id', $authUserId)
                        ->where('receiver_id', $userId);
                })
                ->orWhere(function ($query) use ($authUserId, $userId) {
                    $query->where('sender_id', $userId)
                        ->where('receiver_id', $authUserId);
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
                'active_status' => $user->active_status, // Add active_status
                'last_message' => $latestMessage ? $latestMessage->text : '',
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
            DB::table('messages')
            ->where('receiver_id', $authUserId)
            ->where('sender_id', $receiverId)
            ->where('status', '!=', 'read')
            ->update(['status' => 'read']);


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

            // Set the message status and other new fields
            $message->status = 'sent'; // Initially set to 'sent'
            $message->receiver_online = $this->isReceiverOnline($validatedData['user_id']); // Set online status
            $message->received = $message->receiver_online ? true : false; // If the receiver is online, mark as received
            $message->sent_at = now(); // Set the current timestamp as sent time

            // Save the message to the database
            $message->save();

            // Broadcast the event for real-time notification
            broadcast(new MessageSent($message))->toOthers();

            // Return a JSON response indicating success
            return response()->json([
                'success' => true,
                'status' => 'Message sent',
                'message' => $message // Include the saved message in the response
            ]);
        } catch (\Exception $e) {
            // Log the exception for debugging
            dd($e->getMessage());
            // Return a JSON response indicating failure
            return response()->json([
                'success' => false,
                'status' => 'Failed to send message'
            ], 500);
        }
    }

    /**
     * Check if the receiver is online
     *
     * @param int $userId
     * @return bool
     */
    private function isReceiverOnline($userId)
    {
        // Implement your logic to determine if the receiver is online.
        // This could be based on a field in the user's table or a cache entry.
        // For example, you could check if the user was active within the last few minutes.

        $user = User::find($userId);
        // Assuming you have a 'last_active_at' field in your users table:
        return $user && $user->last_active_at && $user->last_active_at->diffInMinutes(now()) <= 5;
    }


}
