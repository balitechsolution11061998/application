<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    use HasFactory;
    protected $table = 'login_logs';
    protected $fillable = [
        'user_id',
        'email',
        'ip_address',
        'status',
        'logged_at',
    ];
}
