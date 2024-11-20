<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ItemSupplier extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'item_supplier';

    protected $fillable = [
        'supplier',
        'sup_name',
        'sku',
        'sku_desc',
        'upc',
        'unit_cost',
        'create_id',
        'create_date',
        'last_update_id',
        'last_update_date',
        'VAT_IND',
    ];

    // Enable Spatie Activity Log
    protected static $logAttributes = [
        'supplier',
        'sup_name',
        'sku',
        'sku_desc',
        'upc',
        'unit_cost',
        'create_id',
        'create_date',
        'last_update_id',
        'last_update_date',
        'VAT_IND',
    ];

    protected static $logName = 'item_supplier';
}
