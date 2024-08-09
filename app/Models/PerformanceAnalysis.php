<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceAnalysis extends Model
{
    use HasFactory;
    protected $table = 'performance_analysis';
    protected $fillable = [
        'total_count',
        'processed_count',
        'success_count',
        'fail_count',
        'errors',
        'execution_time',
        'status'
    ];


    public function queryPerformanceLogs()
    {
        return $this->hasMany(QueryPerformanceLog::class);
    }
}
