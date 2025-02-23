<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyncData extends Model
{
    use HasFactory;

    protected $fillable = [
        'mode',
        'tungsura_chart',
        'tungsura_administrasi',
        'psu',
        'status_suara',
        'status_adm',
        'images',
        'ts',
        'province_id',
        'kabupaten_id',
        'kecamatan_id',
        'kelurahan_id',
        'tps_id',
    ];

    protected $casts = [
        'tungsura_chart' => 'array',
        'tungsura_administrasi' => 'array',
        'psu' => 'array',
        'images' => 'array',
        'ts' => 'datetime',
    ];
}
