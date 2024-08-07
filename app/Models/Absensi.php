<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;
    protected $table = 'absensi';
    public $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'nik','nik'); // Adjust 'user_id' if necessary
    }

    public function jamKerja()
    {
        return $this->belongsTo(JamKerja::class, 'kode_jam_kerja','kode_jk'); // Adjust foreign key as needed
    }
}
