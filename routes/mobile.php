<?php

use App\Http\Controllers\Mobile\Client\DeleteController;
use App\Http\Controllers\Mobile\Client\GetController;
use App\Http\Controllers\Mobile\Auth\LogInController;
use App\Http\Controllers\Mobile\Auth\LogOutController;
use App\Http\Controllers\Mobile\Auth\SendCodeController;
use App\Http\Controllers\Mobile\Cart\GetUpsellsController;
use App\Http\Controllers\Mobile\Client\AddAddressController;
use App\Http\Controllers\Mobile\Client\DeleteAddressController;
use App\Http\Controllers\Mobile\Client\UpdatePersonalInfoController;
use App\Http\Controllers\Mobile\Order\CheckoutController;
use App\Http\Controllers\Mobile\Order\GetShippingTypesController;
use App\Http\Controllers\Mobile\Order\OrderCarController;
use App\Http\Controllers\Mobile\Shop\CategoriesController;
use App\Http\Controllers\Mobile\Shop\ProductsController;
use App\Http\Controllers\Mobile\Shop\TagsController;
use App\Http\Controllers\Mobile\Shop\ZakladyController;
use Illuminate\Support\Facades\Route;

Route::post('/send-code', SendCodeController::class)
    ->name('send-code');
Route::post('/login', LogInController::class)
    ->name('login');
Route::post('/logout', LogOutController::class)
    ->middleware(['auth:sanctum',])
    ->name('logout');

Route::prefix('/client')
    ->name('client.')
    ->middleware(['auth:sanctum',])
    ->group(function () {
    Route::get('/', GetController::class)
        ->name('get');
    Route::put('/', UpdatePersonalInfoController::class)
        ->name('update');
    Route::post('/addresses', AddAddressController::class)
        ->name('addresses.add');
    Route::delete('/addresses', DeleteAddressController::class)
        ->name('addresses.delete');
    Route::delete('/', DeleteController::class)
        ->name('delete');
});

Route::get('/zaklady', ZakladyController::class)
    ->name('zaklady');
Route::get('/tags', TagsController::class)
    ->name('tags');
Route::get('/categories', CategoriesController::class)
    ->name('categories');
Route::get('/products', ProductsController::class)
    ->name('products');

Route::get('/upsells', GetUpsellsController::class)
    ->name('upsells');

Route::get('/shipping-types', GetShippingTypesController::class)
    ->name('shipping-types');

Route::post('/checkout', CheckoutController::class)
    ->middleware(['auth:sanctum',])
    ->name('checkout');
Route::post('/order-car', OrderCarController::class)
    ->middleware(['auth:sanctum',])
    ->name('order-car');
