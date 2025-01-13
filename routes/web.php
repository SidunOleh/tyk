<?php

use App\Http\Controllers\Admin\Auth\LogInController;
use App\Http\Controllers\Admin\Auth\LogOutController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Auth\LogInController as AuthLogInController;
use App\Http\Controllers\Auth\LogOutController as AuthLogOutController;
use App\Http\Controllers\Auth\SendCodeController;
use App\Http\Controllers\Cart\ChangeQuantityController;
use App\Http\Controllers\Cart\RemoveItemController;
use App\Http\Controllers\Orders\CourierController;
use App\Http\Controllers\Orders\FoodShippingController;
use App\Http\Controllers\Orders\TaxiController;
use App\Http\Controllers\Pages\CabinetController;
use App\Http\Controllers\Pages\CartController;
use App\Http\Controllers\Pages\CheckoutController;
use App\Http\Controllers\Pages\CompleteController;
use App\Http\Controllers\Pages\EstablishmentsController;
use App\Http\Controllers\Pages\GetCatalogHtmlController;
use App\Http\Controllers\Pages\HomeController;
use App\Http\Controllers\Pages\ProductsController;
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

/**
 * Auth
 */
Route::post('/send-code', SendCodeController::class)
    ->name('send-code');
Route::post('/login', AuthLogInController::class)
    ->name('login');
Route::post('/logout', AuthLogOutController::class)
    ->middleware(['auth:web',])
    ->name('logout');

/**
 * Pages
 */
// Route::get('/', HomeController::class)
//     ->name('pages.home'); 
// Route::get('/zaklady', EstablishmentsController::class)
//     ->name('pages.zaklady');  
// Route::get('/product-category/{category:slug}', ProductsController::class)
//     ->name('pages.category'); 
// Route::get('/catalog-html/{category}', GetCatalogHtmlController::class)
//     ->name('pages.catalog-html');
// Route::get('/korzyna', CartController::class)
//     ->name('pages.cart'); 
// Route::get('/oformlennya', CheckoutController::class)
//     ->name('pages.checkout'); 
// Route::get('/cabinet', CabinetController::class)
//     ->middleware(['auth:web',])
//     ->name('pages.cabinet'); 
// Route::get('/complete', CompleteController::class)
//     ->middleware(['auth:web',])
//     ->name('pages.complete'); 

/**
 * Cart
 */
Route::prefix('/cart')->name('cart.')->group(function () {
    Route::post('/change-quantity', ChangeQuantityController::class)
        ->name('change-quantity'); 
    Route::post('/remove-item', RemoveItemController::class)
        ->name('remove-item'); 
});

/**
 * Orders
 */
Route::prefix('/orders')->name('orders')->group(function () {
    Route::post('/food-shipping', FoodShippingController::class)
        ->name('food-shipping'); 
    Route::post('/courier', CourierController::class)
        ->name('courier'); 
    Route::post('/taxi', TaxiController::class)
        ->name('taxi'); 
});