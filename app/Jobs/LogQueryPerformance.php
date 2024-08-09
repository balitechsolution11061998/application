<?php
namespace App\Jobs;

use App\Models\PerformanceAnalysis;
use App\Models\QueryPerformanceLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LogQueryPerformance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $performanceData;
    protected $queryParams;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $performanceData, array $queryParams)
    {
        $this->performanceData = $performanceData;
        $this->queryParams = $queryParams;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $performanceData = $this->performanceData;
        $queryParams = $this->queryParams;

        PerformanceAnalysis::create([
            'total_count' => $performanceData['total_count'],
            'processed_count' => $performanceData['processed_count'],
            'success_count' => $performanceData['success_count'],
            'fail_count' => $performanceData['fail_count'],
            'errors' => $performanceData['errors'],
            'execution_time' => $performanceData['execution_time'],
            'status' => $performanceData['status']
        ]);

        QueryPerformanceLog::create([
            'function_name' => 'Data PO',
            'parameters' => json_encode($queryParams),
            'execution_time' => $performanceData['execution_time'],
            'memory_usage' => $performanceData['memory_usage'],
            'performance_analysis_id' => $performanceData['performance_analysis_id'] // Update if needed
        ]);
    }
}
