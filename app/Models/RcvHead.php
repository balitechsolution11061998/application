<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RcvHead extends Model
{
    use HasFactory;
    protected $table = 'rcvhead';
    public $guarded = [];

    public function details()
    {
        return $this->hasMany(RcvDetail::class, 'rcvhead_id'); // Adjust foreign key as necessary
    }
}
