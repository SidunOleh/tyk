<?php

use App\Http\Controllers\Mobile\Shop\CategoriesController;
use App\Http\Controllers\Mobile\Shop\ProductsController;
use App\Http\Controllers\Mobile\Shop\ZakladyController;
use Illuminate\Support\Facades\Route;

Route::get('/zaklady', ZakladyController::class)
    ->name('zaklady');
Route::get('/categories', CategoriesController::class)
    ->name('categories');
Route::get('/products', ProductsController::class)
    ->name('products');