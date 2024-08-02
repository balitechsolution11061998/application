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
}
