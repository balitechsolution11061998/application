<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKependudukan extends Model
{
    use HasFactory;
    protected $table = 'data_kependudukan';
    protected $fillable = [
        'nama',
        'nik',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'no_kk',
        'pendidikan',
        'pekerjaan',
        'golongan_darah',
        'status_kawin',
        'nama_ibu',
        'nama_bapak',
        'alamat',
        'ktp_elektronik',
        'keterangan',
    ];

}
