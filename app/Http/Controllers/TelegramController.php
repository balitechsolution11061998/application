<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    protected $client;
    protected $token;

    public function __construct()
    {
        $this->token = env('TELEGRAM_BOT_TOKEN'); // Store your token in .env
        $this->client = new Client();
    }

    public function sendMessage(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'chat_id' => 'required|string',
            'message' => 'required|string',
        ]);

        $chatId = $request->input('chat_id'); // Get chat_id from request
        $message = $request->input('message'); // Get message from request

        // Send the message to the Telegram bot
        $response = $this->sendTelegramMessage($chatId, $message);
        return response()->json($response);
    }

    protected function sendTelegramMessage($chatId, $message)
    {
        $url = "https://api.telegram.org/bot{$this->token}/sendMessage";

        $response = $this->client->post($url, [
            'json' => [
                'chat_id' => $chatId,
                'text' => $message,
            ],
        ]);

        return json_decode($response->getBody()->getContents());
    }

    public function getUpdates()
    {
        $updates = Telegram::getUpdates();
        return $updates;
    }
}
