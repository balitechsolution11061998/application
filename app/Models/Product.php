<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'buyer_sku_code', // Add this line
        'product_name',
        'category',
        'brand',
        'type',
        'seller_name',
        'price',
        'stock',
        'buyer_product_status',
        'seller_product_status',
        'unlimited_stock',
        'start_cut_off',
        'end_cut_off',
        'desc',
        'multi',
    ];
}
