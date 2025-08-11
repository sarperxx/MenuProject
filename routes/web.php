<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Api\MenuItemController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\AllergenController;
use App\Http\Controllers\MenuController;
use Illuminate\Http\Request;
use App\Http\Controllers\MenuItemsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\MenuManagementController;


Route::get('/', [\App\Http\Controllers\MenuController::class, 'publicIndex'])->name('public.menus.index');

// Dashboard route
Route::get('dashboard', [DashboardController::class, 'show'])->middleware(['auth', 'verified'])->name('dashboard');

// Public menu listing and detail pages
Route::get('/menus/{slug}', [\App\Http\Controllers\MenuController::class, 'publicShow'])->name('public.menus.show');

// Menu items page
Route::get('/admin/menu-items', [MenuItemsController::class, 'index'])->name('admin.menu-items');

Route::middleware('auth')->get('/api/user', function (Request $request) {
    return response()->json($request->user());
})->middleware('auth');

// Add these lines to web.php for session-authenticated API endpoints:

// Publicly accessible endpoints
Route::get('/api/menu-items', [MenuItemController::class, 'index']);
Route::get('/api/menu-items/{menu_item}', [MenuItemController::class, 'show']);

// Admin-only endpoints (require login)
Route::middleware('auth')->group(function () {
    Route::post('/api/menu-items', [MenuItemController::class, 'store'])->name('menu-items.store');
    Route::put('/api/menu-items/{menu_item}', [MenuItemController::class, 'update'])->name('menu-items.update');
    Route::delete('/api/menu-items/{menu_item}', [MenuItemController::class, 'destroy'])->name('menu-items.destroy');
});

Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('menu-management', [MenuManagementController::class, 'index'])->name('admin.menu-management.index');
    Route::post('menu-management/menus', [MenuManagementController::class, 'storeMenu'])->name('admin.menu-management.menus.store');
    Route::put('menu-management/menus/{id}', [MenuManagementController::class, 'updateMenu'])->name('admin.menu-management.menus.update');
    Route::delete('menu-management/menus/{id}', [MenuManagementController::class, 'destroyMenu'])->name('admin.menu-management.menus.destroy');
    Route::post('menu-management/categories', [MenuManagementController::class, 'storeMenuCategory'])->name('admin.menu-management.categories.store');
    Route::put('menu-management/categories/{id}', [MenuManagementController::class, 'updateMenuCategory'])->name('admin.menu-management.categories.update');
    Route::delete('menu-management/categories/{id}', [MenuManagementController::class, 'destroyMenuCategory'])->name('admin.menu-management.categories.destroy');
    Route::post('menu-management/category-items', [MenuManagementController::class, 'storeMenuCategoryItem'])->name('admin.menu-management.category-items.store');
    Route::delete('menu-management/category-items/{id}', [MenuManagementController::class, 'destroyMenuCategoryItem'])->name('admin.menu-management.category-items.destroy');
    Route::post('menu-management/categories/reorder', [MenuManagementController::class, 'reorderMenuCategories'])->name('admin.menu-management.categories.reorder');
});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
