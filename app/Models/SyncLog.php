<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyncLog extends Model
{
    use HasFactory;
    protected $fillable = ['receive_no', 'message', 'level'];

    public static function info($message, $receive_no = null)
    {
        return self::create([
            'receive_no' => $receive_no,
            'message' => $message,
            'level' => 'info'
        ]);
    }

    public static function error($message, $receive_no = null)
    {
        return self::create([
            'receive_no' => $receive_no,
            'message' => $message,
            'level' => 'error'
        ]);
    }
}
