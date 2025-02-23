<?php

namespace App\Http\Controllers;

use App\Helpers\SystemMetrics;
use App\Models\ActivityLog;
use App\Models\SystemUsage;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\ServerMonitor\Models\Check;
use Artisan;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //

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
        return view('home', compact('remainingRamPerHour'));
    }
    public function importDatabase(Request $request)
    {
        // Define the tables you want to truncate
        $tablesToTruncate = ['supplier']; // Replace with your actual table names

        // Truncate the tables
        foreach ($tablesToTruncate as $table) {
            DB::table($table)->truncate();
        }

        // Simulate a long-running process
        sleep(1); // Simulate some delay for the truncation process

        // Execute the Artisan command to import the SQL file
        Artisan::call('db:migrate-and-import database/supplier.sql');

        // Simulate another delay for the import process
        sleep(1); // Simulate some delay for the import process

        // Return a JSON response
        return response()->json(['success' => true, 'message' => 'Database imported successfully!']);
    }




}
