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
        'is_active',
        'logo'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('price')
            ->withTimestamps();
    }

    public function getLogoUrlAttribute()
    {
        return $this->logo ? asset('storage/paguyubans/' . $this->logo) : asset('images/default-paguyuban.png');
    }
}