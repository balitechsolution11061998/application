<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceChange extends Model
{
    use HasFactory;
    protected $table = 'pricelist_head';

    public $guarded = [];
    public function priceListDetails()
    {
        return $this->hasMany(PriceChangeDetail::class, 'pricelist_head_id', 'id');
    }

    public function suppliers()
    {
        return $this->hasOne(Supplier::class, 'supp_code', 'supplier_id');
    }

    public function users()
    {
        return $this->hasOne(User::class, 'username', 'approval_id');
    }
}
