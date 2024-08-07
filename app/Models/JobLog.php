<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobLog extends Model
{
    use HasFactory;
    protected $fillable = ['job_name', 'status', 'receive_no', 'message'];
}
