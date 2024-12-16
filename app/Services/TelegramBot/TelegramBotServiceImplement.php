<?php

namespace App\Services\TelegramBot;

use LaravelEasyRepository\ServiceApi;
use App\Repositories\TelegramBot\TelegramBotRepository;
use GuzzleHttp\Client;

class TelegramBotServiceImplement extends ServiceApi implements TelegramBotService{

    /**
     * set title message api for CRUD
     * @param string $title
     */
     protected string $title = "";
     /**
     * uncomment this to override the default message
     * protected string $create_message = "";
     * protected string $update_message = "";
     * protected string $delete_message = "";
     */

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected TelegramBotRepository $mainRepository;
     protected $client;
     protected $token;

    public function __construct(TelegramBotRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
      $this->token = env('TELEGRAM_BOT_TOKEN'); // Store your token in .env
      $this->client = new Client();
    }

    public function sendMessage($chatId, $message)
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

    // Define your custom methods :)
}
