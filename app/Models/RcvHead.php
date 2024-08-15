<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RcvHead extends Model
{
    use HasFactory;
    protected $table = 'rcvhead';
    public $guarded = [];

    public function ordhead()
    {
        return $this->belongsTo(Ordhead::class, 'order_no', 'order_no');
    }

    public function rcvDetail()
    {
        return $this->hasMany(RcvDetail::class, 'receive_no', 'receive_no');
    }


    public function tandaTerimaDetail()
    {
        return $this->hasMany(TandaTerimaDetail::class, 'receive_no', 'receive_no');
    }


}
