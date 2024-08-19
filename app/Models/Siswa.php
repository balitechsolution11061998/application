<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nik', 'nis', 'nama', 'jk', 'tanggal_lahir', 'alamat', 'telepon',
        'email', 'kelas_id', 'ortu_id', 'tanggal_masuk', 'tanggal_lulus',
        'status', 'catatan', 'golongan_darah', 'tempat_lahir', 'foto'
    ];

    public function rombel()
    {
        return $this->belongsTo(Rombel::class);
    }

    public function users()
    {
        return $this->hasOne(User::class, 'nik', 'nis');
    }
}
