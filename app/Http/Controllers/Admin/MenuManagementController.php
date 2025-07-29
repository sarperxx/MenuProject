<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MenuManagementController extends Controller
{
    public function index(Request $request)
    {
        $menus = Menu::with('categories')->get();
        $categories = Category::with('menus')->orderBy('position')->get();
        $items = MenuItem::all();

        return Inertia::render('Admin/MenuManagement', [
            'menus' => $menus,
            'categories' => $categories,
            'items' => $items,
        ]);
    }

    public function storeMenu(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:menus,slug',
            'start_time' => 'required',
            'end_time' => 'required',
            'description' => 'nullable|string',
        ]);
        \App\Models\Menu::create($validated);
        return redirect()->route('admin.menu-management.index')->with('success', 'Menu created.');
    }

    public function updateMenu(Request $request, $id)
    {
        $menu = \App\Models\Menu::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:menus,slug,' . $menu->id,
            'start_time' => 'required',
            'end_time' => 'required',
            'description' => 'nullable|string',
        ]);
        $menu->update($validated);
        return redirect()->route('admin.menu-management.index')->with('success', 'Menu updated.');
    }

    public function destroyMenu($id)
    {
        $menu = \App\Models\Menu::findOrFail($id);
        $menu->delete();
        return redirect()->route('admin.menu-management.index')->with('success', 'Menu deleted.');
    }

    public function storeMenuCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'menu_id' => 'required|exists:menus,id',
        ]);
        
        // Create the category
        $category = Category::create([
            'name' => $validated['name'],
            'position' => Category::max('position') + 1,
        ]);
        
        // Attach to menu
        $category->menus()->attach($validated['menu_id']);
        
        return redirect()->route('admin.menu-management.index')->with('success', 'Menu category created.');
    }

    public function updateMenuCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'menu_id' => 'required|exists:menus,id',
        ]);
        
        $category->update(['name' => $validated['name']]);
        
        // Update menu relationship
        $category->menus()->sync([$validated['menu_id']]);
        
        return redirect()->route('admin.menu-management.index')->with('success', 'Menu category updated.');
    }

    public function destroyMenuCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.menu-management.index')->with('success', 'Menu category deleted.');
    }

    public function reorderMenuCategories(Request $request)
    {
        $orderedIds = $request->input('ids'); // expects array of category IDs in new order
        foreach ($orderedIds as $index => $id) {
            Category::where('id', $id)->update(['position' => $index]);
        }
        return response()->json(['success' => true]);
    }
} 