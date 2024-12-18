<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderConfirmationHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_no',
        'confirmation_date',
        'username'
    ];
}
