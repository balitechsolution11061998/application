<?php

namespace App\Jobs;

use App\Events\UserLoggedIn;
use App\Events\UserLoggedOut;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SendTelegramMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $message;
    protected $chatId;

    public function __construct($message, $chatId)
    {
        $this->message = $message;
        $this->chatId = $chatId;
    }

    public function handle()
    {
        $telegramToken = env('TELEGRAM_BOT_TOKEN');
        $url = "https://api.telegram.org/bot$telegramToken/sendMessage";

        Http::post($url, [
            'chat_id' => $this->chatId,
            'text' => $this->message,
            'parse_mode' => 'Markdown',
        ]);
    }
}
