<?php

namespace App\Http\Controllers;

use App\Models\SystemUsage;
use Illuminate\Http\Request;

class DashboardSystemController extends Controller
{
    //
    public function __construct()
    {
        // Apply Laratrust middleware to check for permission
        $this->middleware('permission:show-dashboard-system'); // Replace 'view_home' with your actual permission name
    }
    public function index()
    {
        // Get the available total RAM (this is platform-dependent)
        // For example, on Linux, you could execute a system command like 'free -m' or similar to get the total RAM.
        // Here, we assume you have a way to get total available RAM.
        $totalRam = 16000; // Assume 16 GB of total available RAM (for example purposes)

        // Get the total memory usage aggregated per hour
        $memoryUsagePerHour = SystemUsage::selectRaw('
                SUM(memory_usage_mb) as total_memory_used,
                HOUR(accessed_at) as hour
            ')
            ->groupBy('hour')
            ->orderBy('hour', 'asc')
            ->get();

        // Calculate the remaining RAM per hour by subtracting the usage from total RAM
        $remainingRamPerHour = $memoryUsagePerHour->map(function ($usage) use ($totalRam) {
            $usage->remaining_ram = $totalRam - $usage->total_memory_used;
            return $usage;
        });

        // Pass the aggregated data to the view
        return view('dashboard.system.index', compact('remainingRamPerHour'));
    }
}
