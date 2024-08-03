<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    use HasFactory;
    protected $table = 'izin';
    public $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'nik','nik'); // Adjust 'user_id' if necessary
    }

    protected $casts = [
        'tgl_izin_dari' => 'date',
        'tgl_izin_sampai' => 'date',
    ];
}
