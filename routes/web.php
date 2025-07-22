<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Api\MenuItemController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\AllergenController;
use Illuminate\Http\Request;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/menu-items', function () {
    return Inertia::render('MenuItems');
})->name('menu.items');

Route::middleware('auth')->get('/api/user', function (Request $request) {
    return response()->json($request->user());
})->middleware('auth');

// Add these lines to web.php for session-authenticated API endpoints:

// Publicly accessible endpoints
Route::get('/api/menu-items', [MenuItemController::class, 'index']);
Route::get('/api/menu-items/{menu_item}', [MenuItemController::class, 'show']);

// Admin-only endpoints (require login)
Route::middleware('auth')->group(function () {
    Route::post('/api/menu-items', [MenuItemController::class, 'store']);
    Route::put('/api/menu-items/{menu_item}', [MenuItemController::class, 'update']);
    Route::delete('/api/menu-items/{menu_item}', [MenuItemController::class, 'destroy']);
});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
