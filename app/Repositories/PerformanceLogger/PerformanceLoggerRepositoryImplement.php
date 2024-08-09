<?php

namespace App\Repositories\PerformanceLogger;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\QueryPerformanceLog;

class PerformanceLoggerRepositoryImplement extends Eloquent implements PerformanceLoggerRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(QueryPerformanceLog $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
}
