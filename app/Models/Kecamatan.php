<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'tingkat',
        'province_id',
        'kabupaten_id',
    ];

    // Define relationship with Province
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    // Define relationship with Kabupaten
    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class);
    }
}