<?php
namespace App\Traits;

use App\Models\QueryPerformanceLog;
use Illuminate\Support\Facades\Log;

trait QueryPerformanceLoggingTrait
{
    public function logQueryPerformance($functionName, $parameters, $executionTime, $memoryUsage)
    {
        try {
            QueryPerformanceLog::create([
                'function_name' => $functionName,
                'parameters' => json_encode($parameters),
                'execution_time' => $executionTime,
                'memory_usage' => $memoryUsage,
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return $e->getMessage();
        }
    }
}
