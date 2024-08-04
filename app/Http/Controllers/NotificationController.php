<?php

namespace App\Http\Controllers;

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
}
