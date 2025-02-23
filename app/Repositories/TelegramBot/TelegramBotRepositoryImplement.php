<?php

namespace App\Repositories\TelegramBot;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\TelegramBot;

class TelegramBotRepositoryImplement extends Eloquent implements TelegramBotRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected TelegramBot $model;

    public function __construct(TelegramBot $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
}
