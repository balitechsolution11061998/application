<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdHead extends Model
{
    use HasFactory;
    protected $table = 'ordhead';
    public $guarded = [];

    public function ordsku()
    {
        return $this->hasMany(OrdSku::class, 'ordhead_id'); // Adjust the foreign key as necessary
    }
}
