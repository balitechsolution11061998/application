<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceAnalysis extends Model
{
    use HasFactory;
    protected $table = 'performance_analysis';
    public $guarded = [];
}
