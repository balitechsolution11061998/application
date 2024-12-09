<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CcextDetail extends Model
{
    use HasFactory;
    protected $table = 'ccext_detail';

    protected $fillable = [
        'ccext_no',
        'supplier',
        'sku',
        'unit_cost',
        'old_unit_cost',
        'created_at',
    ];
}
