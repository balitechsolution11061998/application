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

        // Get the memory usage data for the last 10 minutes
        $memoryUsagePerMinute = SystemUsage::selectRaw('
                SUM(memory_usage_mb) as total_memory_used,
                DATE_FORMAT(accessed_at, "%H:%i") as time,
                (' . $totalRam . ' - SUM(memory_usage_mb)) as remaining_ram,
                MAX(accessed_at) as max_accessed_at
            ')
            ->groupBy(DB::raw('DATE_FORMAT(accessed_at, "%H:%i")')) // Group by formatted time
            ->orderByDesc('max_accessed_at') // Order by the raw timestamp
            ->take(5) // Limit to the last 5 records (or 10 if you prefer)
            ->get();

        // Include the total RAM in the response
        return response()->json([
            'total_ram' => $totalRam, // Include total RAM in the response
            'data' => $memoryUsagePerMinute // The actual memory usage data
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
