<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request; // Import Request for type hinting
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Facades\Activity;

trait TelegramNotificationTrait
{
    use ActivityLogger; // Use the ActivityLogger trait

    private function sendMessageToTelegram($message, $chatId, Request $request = null)
    {
        $telegramToken = env('TELEGRAM_BOT_TOKEN');
        $url = "https://api.telegram.org/bot$telegramToken/sendMessage";

        // Construct the full URL for debugging
        $fullUrl = $url . "?chat_id=" . $chatId . "&text=" . urlencode($message) . "&parse_mode=Markdown";
        try {
            // Send the message to Telegram
            $response = Http::post($fullUrl, [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'Markdown', // Use Markdown for formatting
            ]);

            // Check if the response is successful
            if ($response->successful()) {
                $this->logActivity('Telegram Notification Sent', null, 'telegram_notification', $request);
            } else {
                // Log the error response for debugging
                $errorMessage = $response->json()['description'] ?? 'Unknown error';
                $this->logActivity('Telegram Notification Failed', null, 'telegram_notification', $request, null, null);
            }
        } catch (\Exception $e) {
            // Log the exception
            $this->logActivity('Telegram Notification Exception', null, 'telegram_notification', $request, null, null);
        }
    }
}
