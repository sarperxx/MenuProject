<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MenuItemController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\AllergenController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\MenuController;

Route::apiResource('menu-items', MenuItemController::class);
Route::get('categories', [CategoryController::class, 'index']);
Route::get('allergens', [AllergenController::class, 'index']);
Route::get('menus', [MenuController::class, 'index']);
Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});
