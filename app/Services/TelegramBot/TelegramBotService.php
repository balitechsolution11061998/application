<?php

namespace App\Services\TelegramBot;

use LaravelEasyRepository\BaseService;

interface TelegramBotService extends BaseService{

    // Write something awesome :)
    public function sendMessage($chatId, $message);
}
