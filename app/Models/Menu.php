<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'url', 'is_dropdown', 'parent_id'];

    // Relasi ke parent menu
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    // Relasi ke child menu
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }
}
