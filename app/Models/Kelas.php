<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $fillable = ['paket_id', 'name', 'guru_id'];
    public function guru()
    {
        return $this->belongsTo('App\Models\Guru')->withDefault();
    }

    public function paket()
    {
        return $this->belongsTo('App\Models\Paket')->withDefault();
    }

    protected $table = 'kelas';
}
