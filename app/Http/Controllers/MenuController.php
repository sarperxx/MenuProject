<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Allergen;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    // Ana sayfa
    public function index()
    {
        $menus = Menu::all();
        return view('menus.index', compact('menus'));
    }

    // Menü detay sayfası
    public function show($slug)
    {
        $menu = Menu::where('slug', $slug)->with('categories.items')->firstOrFail();
        $categories = $menu->categories()->with('menuItems')->get();
        return view('menus.show', compact('menu', 'categories'));
    }

    // Public home page: list all menus
    public function publicIndex()
    {
        $menus = Menu::all();
        return view('public.menus.index', compact('menus'));
    }

    // Public menu detail page: show categories and menu items for a menu
    public function publicShow($slug)
    {
        $menu = Menu::where('slug', $slug)->with('categories.menuItems.allergens')->firstOrFail();
        $allergens = Allergen::orderBy('name')->get();
        
        // Show allergen filter for all menus
        $showAllergenFilter = true;
        
        return view('public.menus.show', compact('menu', 'allergens', 'showAllergenFilter'));
    }
}
