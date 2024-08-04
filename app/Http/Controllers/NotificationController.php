<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    //
    public function fetchNotifications()
    {
        $user = Auth::user(); // Get the currently authenticated user

        // Fetch notifications for the user
        $notifications = $user->notifications()->latest()->take(10)->get(); // Adjust as needed

        return response()->json($notifications);
    }

    // In NotificationController.php
    public function markAsRead($id)
    {
        $notification = Notification::find($id);

        if ($notification) {
            $notification->update(['read_at' => now()]);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }
}
