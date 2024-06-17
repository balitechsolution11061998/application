<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueryPerformanceLog extends Model
{
    use HasFactory;
    protected $fillable = ['function_name', 'parameters', 'execution_time', 'memory_usage'];
}
