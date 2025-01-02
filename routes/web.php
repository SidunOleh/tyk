<?php

use App\Http\Controllers\Admin\Auth\LogInController;
use App\Http\Controllers\Admin\Auth\LogOutController;
use App\Http\Controllers\Admin\IndexController;
use App\Models\Product;
use App\Services\Cart\CartSession;
use Illuminate\Support\Facades\Route;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;

Route::domain(config('app.admin_domain'))->group(function () {
    Route::post('/login', LogInController::class)
        ->name('login');
    Route::post('/logout', LogOutController::class)
        ->name('logout');

    Route::get('/logs', [LogViewerController::class, 'index'])
        ->middleware(['auth:sanctum',]);

    Route::get('/{any}', IndexController::class)
        ->where('any', '.*')
        ->name('index');
});

Route::get('/', function () {
    $cart = new CartSession;
    $cart->addItem(Product::find(1), 3);
    $cartItem = $cart->addItem(Product::find(1), 2);
    $cart->changeQuantity($cartItem->id, 10);

    return dd($cart->total());
});