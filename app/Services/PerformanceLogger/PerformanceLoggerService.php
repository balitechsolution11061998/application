<?php

namespace App\Services\PerformanceLogger;

use LaravelEasyRepository\BaseService;

interface PerformanceLoggerService extends BaseService{

    // Write something awesome :)
    public function logPerformanceData($data, $executionTime, $memoryUsage);
}
