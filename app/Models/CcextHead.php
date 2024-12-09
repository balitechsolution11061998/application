<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CcextHead extends Model
{
    use HasFactory;
    protected $table = 'ccext_head';

    protected $fillable = [
        'cost_change_no',
        'cost_change_desc',
        'reason',
        'status',
        'active_date',
        'create_date',
    ];
}
