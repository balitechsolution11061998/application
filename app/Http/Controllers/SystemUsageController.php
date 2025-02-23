<?php

namespace App\Http\Controllers;

use App\Models\SystemUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SystemUsageController extends Controller
{
    //
    public function getRamUsageData()
    {
        $totalRam = $this->getTotalRam(); // Fetch the total available RAM (4096 MB for example)

        // Get the memory usage data for the last 10 seconds
        $memoryUsagePerSecond = SystemUsage::selectRaw('
                SUM(memory_usage_mb) as total_memory_used,
                DATE_FORMAT(accessed_at, "%H:%i:%s") as time,  -- Group by second
                (' . $totalRam . ' - SUM(memory_usage_mb)) as remaining_ram,
                MAX(accessed_at) as max_accessed_at
            ')
            ->groupBy(DB::raw('DATE_FORMAT(accessed_at, "%H:%i:%s")')) // Group by formatted time with seconds
            ->orderByDesc('max_accessed_at') // Order by raw timestamp to get the most recent data
            ->take(10) // Limit to the last 10 records (or adjust as needed)
            ->get();

        // Include the total RAM in the response
        return response()->json([
            'total_ram' => $totalRam, // Include total RAM in the response
            'data' => $memoryUsagePerSecond // The actual memory usage data per second
        ]);
    }

    private function getTotalRam()
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            // For Windows
            $ram = shell_exec("wmic computersystem get totalphysicalmemory");
            preg_match('/\d+/', $ram, $matches);
            return isset($matches[0]) ? $matches[0] / 1024 / 1024 : 0; // Return in MB
        } else {
            // For Linux/Unix systems
            $ram = shell_exec("cat /proc/meminfo | grep MemTotal | awk '{print $2}'");
            return (int)$ram / 1024; // Convert KB to MB and return
        }
    }

}
