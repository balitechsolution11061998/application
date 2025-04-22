<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'image',
        'sku',
        'upc',
        'description',
        'options',
        'company_id',
        'is_active'
    ];

    protected $casts = [
        'options' => 'array',
        'is_active' => 'boolean'
    ];


    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function paguyubans(): BelongsToMany
    {
        return $this->belongsToMany(Paguyuban::class)
            ->withPivot('price')
            ->withTimestamps();
    }



    public function bonuses()
    {
        return $this->hasMany(Bonus::class);
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/products/' . $this->image) : asset('images/default-product.png');
    }
}