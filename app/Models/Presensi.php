<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $table = 'presensi';

    // Define the relationship to the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'nik'); // Adjust 'user_id' if necessary
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id'); // Adjust foreign key as needed
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id'); // Adjust foreign key as needed
    }

    public function konfigurasiJamKerja()
    {
        return $this->belongsTo(KonfigurasiJamKerja::class, 'kode_jam_kerja'); // Adjust foreign key as needed
    }
}
