<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierQuantity extends Model
{
    use HasFactory;
    protected $table ='supplier_quantities';
    public $guarded = [];

}
