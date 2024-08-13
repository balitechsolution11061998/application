<?php

namespace App\Helpers;

use App\Models\PerformanceAnalysis;
use App\Models\QueryPerformanceLog;

class PerformanceHelper
{
    public static function logPerformanceMetrics($functionName, $date, $executionTime, $memoryUsage, $totalCount, $processedCount, $successCount, $failCount = 0, $errors = null)
    {
        // Determine performance status based on execution time
        $performanceStatus = $executionTime > 1 ? 'slow' : 'fast'; // Example threshold of 1 second

        // Create or update performance analysis record
        $performanceAnalysis = PerformanceAnalysis::create([
            'total_count' => $totalCount,
            'processed_count' => $processedCount,
            'success_count' => $successCount,
            'fail_count' => $failCount,
            'errors' => $errors,
            'execution_time' => $executionTime,
            'status' => $performanceStatus
        ]);

        // Log performance metrics
        QueryPerformanceLog::create([
            'function_name' => $functionName,
            'parameters' => json_encode(['date' => $date]),
            'execution_time' => $executionTime,
            'memory_usage' => $memoryUsage,
            'performance_analysis_id' => $performanceAnalysis->id
        ]);
    }
}
