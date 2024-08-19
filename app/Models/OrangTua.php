<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrangTua extends Model
{
    use SoftDeletes;
    protected $table = 'orang_tua';
    protected $fillable = [
        'nik', 'nama', 'alamat', 'telepon', 'email', 'pekerjaan', 'hubungan'
    ];
}
