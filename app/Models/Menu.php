<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Menu extends Model
{
    protected $fillable = [
        'name', 'slug', 'start_time', 'end_time', 'description'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_menu');
    }
    public function menus()
    {
        return $this->belongsToMany(Menu::class);
    }

}