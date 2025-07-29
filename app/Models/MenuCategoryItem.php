<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuCategoryItem extends Model
{
    protected $table = 'menu_category_items';
    protected $fillable = [
        'menu_category_id',
        'menu_item_id',
        // Add extra fields here if needed
    ];

    public function menuCategory()
    {
        return $this->belongsTo(MenuCategory::class);
    }

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }
} 