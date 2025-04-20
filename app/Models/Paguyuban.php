<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Paguyuban extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'logo',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Get the products associated with the paguyuban.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('price')
            ->withTimestamps();
    }

    /**
     * Get the logo URL attribute.
     */
    public function getLogoUrlAttribute()
    {
        return $this->logo ? asset('storage/paguyubans/' . $this->logo) : asset('images/default-paguyuban.png');
    }
}