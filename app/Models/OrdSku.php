<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdSku extends Model
{
    use HasFactory;
    protected $table = 'ordsku';
    public $guarded = [];

    public function itemSupplier()
    {
        return $this->belongsTo(ItemSupplier::class, 'sku', 'sku');
    }
}
