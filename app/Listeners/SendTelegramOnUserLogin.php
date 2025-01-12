<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
use App\Jobs\SendTelegramMessage;

class SendTelegramOnUserLogin
{
    public function handle(UserLoggedIn $event)
    {
        $message = $this->createTelegramMessage($event->user, $event->address, $event->ipAddress);
        SendTelegramMessage::dispatch($message, $event->user->channel_id);
    }

    private function createTelegramMessage($user, $address, $ipAddress)
    {
        // Create a more engaging message
        $message = "👤 **User Login Notification** 👤\n\n";
        $message .= "🏢 *User:* **{$user->name}**\n";
        $message .= "📧 *Email:* **{$user->email}**\n"; // Include user's email
        $message .= "🏠 *User Address:* **$address**\n\n";
        $message .= "🌐 *IP Address:* **$ipAddress**\n"; // Include user's IP address
        $message .= "🎉 *Status:* **User logged in**\n";
        $message .= "🕒 *Login Time:* **" . now()->toDateTimeString() . "**\n"; // Include login timestamp

        return $message;
    }
}
