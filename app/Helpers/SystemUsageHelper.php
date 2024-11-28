<?php
// app/Helpers/SystemUsageHelper.php

namespace App\Helpers;

use App\Models\SystemUsage;

class SystemUsageHelper
{
    public static function logUsage($startTime, $startMemory,$accessed_at,$functioon)
    {
        // End timing and memory tracking
        $endTime = microtime(true);
        $endMemory = memory_get_usage();

        // Calculate load time in milliseconds and memory usage in MB
        $loadTimeMs = round(($endTime - $startTime) * 1000); // Convert seconds to milliseconds
        $ramUsageMb = round(($endMemory - $startMemory) / 1024 / 1024, 2); // Convert bytes to MB

        // Log memory usage, load time, and access time to the database
        SystemUsage::create([
            'memory_usage_mb' => $ramUsageMb,
            'load_time_ms' => $loadTimeMs,
            'accessed_at' => now(),
            'function'=>$functioon
        ]);
    }
}
