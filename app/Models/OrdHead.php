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

    public function suppliers()
    {
        return $this->belongsTo(Supplier::class, 'supplier', 'supp_code'); // Adjust the foreign key as necessary
    }

    // Define the relationship to the Store
    public function stores()
    {
        return $this->belongsTo(Store::class, 'ship_to', 'store'); // Adjust the foreign key as necessary
    }
}
