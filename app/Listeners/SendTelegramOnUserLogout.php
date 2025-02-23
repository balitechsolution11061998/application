<?php

namespace App\Listeners;

use App\Events\UserLoggedOut;
use App\Jobs\SendTelegramMessage;

class SendTelegramOnUserLogout
{
    public function handle(UserLoggedOut $event)
    {
        $message = $this->createLogoutTelegramMessage($event->user, $event->ipAddress);
        SendTelegramMessage::dispatch($message, $event->user->channel_id);
    }

    private function createLogoutTelegramMessage($user, $ipAddress)
    {
        // Create a more engaging message for logout
        $message = "👤 **User Logout Notification** 👤\n\n";
        $message .= "🏢 *User:* **{$user->name}**\n";
        $message .= "📧 *Email:* **{$user->email}**\n"; // Include user's email
        $message .= "🌐 *IP Address:* **$ipAddress**\n"; // Include user's IP address
        $message .= "🎉 *Status:* **User logged out**\n";
        $message .= "🕒 *Logout Time:* **" . now()->toDateTimeString() . "**\n"; // Include logout timestamp

        return $message;
    }
}
