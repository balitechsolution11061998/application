<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    protected $fillable = [
        'product_id',
        'expense_category',
        'is_recurring',
        'recurrence',
        'is_active'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}