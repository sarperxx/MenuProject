<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class MenuItemsController extends Controller
{
    public function index(Request $request)
    {
        $menus = \App\Models\Menu::with('categories')->get();
        $categories = \App\Models\Category::with('menus')->get()->map(function ($cat) {
            $cat->menu_ids = $cat->menus->pluck('id')->toArray();
            return $cat;
        });
        $allergens = \App\Models\Allergen::all();
        $items = \App\Models\MenuItem::with(['category', 'allergens'])->paginate(10);

        return \Inertia\Inertia::render('MenuItems', [
            'menus' => $menus,
            'categories' => $categories,
            'allergens' => $allergens,
            'items' => $items,
            'user' => $request->user(),
        ]);
    }
} 