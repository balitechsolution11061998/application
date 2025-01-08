<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

trait SystemUsageLogger
{
    protected function logSystemUsage(Request $request, $function, $startTime, $memoryBefore)
    {
        $executionTime = (microtime(true) - $startTime) * 1000; // Convert to milliseconds
        $memoryAfter = memory_get_usage(); // Memory usage after the action
        $memoryUsed = ($memoryAfter - $memoryBefore) / 1024 / 1024; // Convert to MB

        // Insert into the system_usages table
        DB::table('system_usages')->insert([
            'memory_usage_mb' => round($memoryUsed, 2),
            'load_time_ms' => round($executionTime, 2),
            'accessed_at' => now(),
            'function' => $function,
        ]);
    }
}
