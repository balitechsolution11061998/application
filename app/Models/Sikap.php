<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sikap extends Model
{
    use HasFactory;
    protected $fillable = ['siswa_id', 'kelas_id', 'guru_id', 'mapel_id', 'sikap_1', 'sikap_2', 'sikap_3'];

    protected $table = 'sikap';
}
