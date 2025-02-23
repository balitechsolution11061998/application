<?php

namespace App\Http\Controllers;

use App\Mail\SendEmailOtp;
use App\Models\Message;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
                    // Send message to Telegram
                    $this->sendMessageToTelegram($user->channel_id, $request->message);
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
                'receiver_id' => $receiver->id,
                'message' => $request->message,
            ]);

            // Send message to Telegram
            $this->sendMessageToTelegram($receiver->telegram_id, $request->message);

            // Log the activity
            activity()->causedBy(auth()->user())
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

    private function sendMessageToTelegram($telegramId, $message)
    {
        $botToken = env('TELEGRAM_BOT_TOKEN'); // Get the bot token from the environment
        $url = "https://api.telegram.org/bot{$botToken}/sendMessage";

        $data = [
            'chat_id' => $telegramId,
            'text' => $message,
            'parse_mode' => 'HTML', // Optional: Use HTML formatting
        ];

        try {
            // Send the message to Telegram
            $response = Http::post($url, $data);

            // Check if the message was sent successfully
            if (!$response->successful()) {
                Log::error('Failed to send message to Telegram: ' . $response->body());

                // Log the activity for the error
                activity()
                    ->causedBy(auth()->user())
                    ->withProperties(['telegram_id' => $telegramId, 'message' => $message, 'error' => $response->body()])
                    ->log("Failed to send message to Telegram for user ID {$telegramId}.");
            }
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Exception occurred while sending message to Telegram: ' . $e->getMessage());

            // Log the activity for the exception
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['telegram_id' => $telegramId, 'message' => $message, 'error' => $e->getMessage()])
                ->log("Exception occurred while sending message to Telegram for user ID {$telegramId}.");
        }
    }

    public function fetchMessages($userId)
    {
        $messages = Message::where(function ($query) use ($userId) {
            $query->where('sender_id', auth()->id());
        })->orWhere(function ($query) use ($userId) {
            $query->where('receiver_id', auth()->id());
        })->orderBy('created_at', 'asc')->get();

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

    public function getChatId(Request $request)
    {
        $botToken = env('TELEGRAM_BOT_TOKEN'); // Fetch the bot token from the environment
        $url = "https://api.telegram.org/bot$botToken/getUpdates";

        // Send the request to the Telegram API
        $response = Http::get($url);

        // Check if the response is successful
        if ($response->successful()) {
            $updates = $response->json(); // Decode the JSON response

            // Check if there are any updates
            if (!empty($updates['result'])) {
                // Get the latest update
                $latestUpdate = end($updates['result']);
                $chatId = $latestUpdate['message']['chat']['id']; // Extract chat_id

                // Assuming you have the user ID in the session or request
                $userId = $request->user()->id; // Get the authenticated user's ID

                // Update the user's channel_id with the retrieved chat_id
                $user = User::find($userId);
                $user->channel_id = $chatId; // Save the chat_id to channel_id
                $user->save(); // Save the user record

                return response()->json(['success' => true, 'chat_id' => $chatId]);
            } else {
                return response()->json(['success' => false, 'message' => 'No updates found. Please send a message to the bot first.']);
            }
        } else {
            return response()->json(['success' => false, 'message' => $response->body()]);
        }
    }
    public function sendOtp(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'channel_id' => 'required|string', // Ensure channel_id is provided
        ]);

        // Generate a random OTP
        $otp = rand(100000, 999999); // Generate a 6-digit OTP
        $expiresAt = now()->addMinutes(5); // Set expiration time (e.g., 5 minutes)

        // Store the OTP in the database
        try {
            Otp::create([
                'channel_id' => $request->channel_id,
                'otp' => $otp,
                'expires_at' => $expiresAt,
            ]);
            // Log successful OTP storage
            activity('OTP Generation')
                ->performedOn(Auth::user())
                ->log('OTP stored in database successfully.');
        } catch (\Exception $e) {
            // Log the error and activity
            activity('OTP Generation')
                ->performedOn(Auth::user())
                ->log('Failed to store OTP in database: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to generate OTP.'], 500);
        }

        // Send the OTP to the user's Telegram channel
        try {
            $this->sendOtpToTelegram($request->channel_id, $otp);
            // Log successful Telegram sending
            activity('OTP Generation')
                ->performedOn(Auth::user())
                ->log('OTP sent to Telegram successfully.');
        } catch (\Exception $e) {
            // Log the error and activity
            \Log::error('Failed to send OTP to Telegram: ' . $e->getMessage());
            activity('OTP Generation')
                ->performedOn(Auth::user())
                ->log('Failed to send OTP to Telegram: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to send OTP to Telegram.'], 500);
        }

        // Send the OTP to the user's email
        try {
            $this->sendOtpToEmail(Auth::user()->email, $otp);
            // Log successful email sending
            activity('OTP Generation')
                ->performedOn(Auth::user())
                ->log('OTP sent to email successfully.');
        } catch (\Exception $e) {
            // Log the error and activity
            \Log::error('Failed to send OTP to email: ' . $e->getMessage());
            activity('OTP Generation')
                ->performedOn(Auth::user())
                ->log('Failed to send OTP to email: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to send OTP to email.'], 500);
        }

        // Log the successful OTP generation and sending
        activity('OTP Generation')
            ->performedOn(Auth::user())
            ->log('OTP generated and sent to Telegram and email.');

        // Return a formatted response with an icon
        return response()->json([
            'success' => true,
            'message' => '<i class="fas fa-paper-plane"></i> Your OTP has been sent to your Telegram channel and email.',
        ]);
    }



    private function sendOtpToTelegram($channelId, $otp)
    {
        $botToken = env('TELEGRAM_BOT_TOKEN'); // Get the bot token from the environment
        $message = "🔑 Your OTP is: <b>{$otp}</b>. It will expire in 5 minutes.";

        try {
            // Send message to Telegram
            $response = Http::get("https://api.telegram.org/bot{$botToken}/sendMessage", [
                'chat_id' => $channelId,
                'text' => $message,
                'parse_mode' => 'HTML', // Use HTML formatting
            ]);

            // Check if the message was sent successfully
            if ($response->successful()) {
                // Log successful message sending
                activity('Telegram Notification')
                    ->performedOn(Auth::user())
                    ->log('OTP sent to Telegram successfully.');
            } else {
                // Log failure to send message
                \Log::error('Failed to send OTP to Telegram: ' . $response->body());

                // Log the error in activity log
                activity('Telegram Notification')
                    ->performedOn(Auth::user())
                    ->log('Failed to send OTP to Telegram: ' . $response->body());
            }
        } catch (\Exception $e) {
            // Log the exception
            \Log::error('Error sending OTP to Telegram: ' . $e->getMessage());

            // Log the error in activity log
            activity('Telegram Notification')
                ->performedOn(Auth::user())
                ->log('Error sending OTP to Telegram: ' . $e->getMessage());
        }
    }

    private function sendOtpToEmail($email, $otp)
    {
        try {
            // Send the email
            Mail::to($email)->send(new SendEmailOtp($otp));

            // Log email sending
            activity('Email Notification')
                ->performedOn(Auth::user())
                ->log('OTP sent to email successfully.');
        } catch (\Exception $e) {
            // Log the exception
            \Log::error('Error sending OTP to email: ' . $e->getMessage());

            // Log the error in activity log
            activity('Email Notification')
                ->performedOn(Auth::user())
                ->log('Error sending OTP to email: ' . $e->getMessage());

            throw $e; // Rethrow the exception to handle it in the sendOtp method
        }
    }



    public function checkOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|integer',
        ]);

        // Retrieve the OTP from the database
        $otpRecord = Otp::where('otp', $request->otp)
            ->where('expires_at', '>=', now()) // Check if not expired
            ->first();

        // Check if the OTP is valid and not expired
        if ($otpRecord) {
            // Optionally, you can delete the OTP after successful verification
            $otpRecord->delete();

            return response()->json(['success' => true, 'message' => 'OTP is valid.']);
        }

        return response()->json(['success' => false, 'message' => 'Invalid or expired OTP.']);
    }
}
