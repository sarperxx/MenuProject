<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'position'];

    public function menus()
{
    return $this->belongsToMany(Menu::class, 'category_menu');
}

    public function menuItems()
    {
        return $this->hasMany(\App\Models\MenuItem::class);
    }
}
