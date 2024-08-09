<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueryPerformanceLog extends Model
{
    use HasFactory;
    protected $table = 'query_performance_logs';
    protected $fillable = [
        'function_name',
        'parameters',
        'execution_time',
        'memory_usage',
        'ping',
        'download_speed',
        'upload_speed',
        'ip_user',
        'performance_analysis_id'
    ];

    public function performanceAnalysis()
    {
        return $this->belongsTo(PerformanceAnalysis::class);
    }
}
