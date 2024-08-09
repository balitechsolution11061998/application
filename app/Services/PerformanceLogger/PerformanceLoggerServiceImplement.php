<?php

namespace App\Services\PerformanceLogger;

use LaravelEasyRepository\ServiceApi;
use App\Repositories\PerformanceLogger\PerformanceLoggerRepository;

class PerformanceLoggerServiceImplement extends ServiceApi implements PerformanceLoggerService{

    /**
     * set title message api for CRUD
     * @param string $title
     */
     protected $title = "";
     /**
     * uncomment this to override the default message
     * protected $create_message = "";
     * protected $update_message = "";
     * protected $delete_message = "";
     */

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(PerformanceLoggerRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }
    public function logPerformanceData($data, $executionTime, $memoryUsage)
    {
        $status = $executionTime > 1 ? 'slow' : 'fast';

        $performanceData = [
            'total_count' => $data->count(),
            'processed_count' => $data->count(),
            'success_count' => $data->count(),
            'fail_count' => 0,
            'errors' => null,
            'execution_time' => $executionTime,
            'status' => $status,
            'memory_usage' => $memoryUsage,
            'performance_analysis_id' => null // Placeholder, to be updated by job if needed
        ];
        return $performanceData;

    }
    // Define your custom methods :)
}
