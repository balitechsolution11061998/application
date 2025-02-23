<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CcextHead extends Model
{
    use HasFactory;
    protected $table = 'ccext_head';

    protected $fillable = [
        'ccext_no',
        'ccext_desc',
        'reason',
        'status',
        'active_date',
        'create_date',
    ];
}
