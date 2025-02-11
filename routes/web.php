<?php

use App\Http\Controllers\Admin\Auth\LogInController;
use App\Http\Controllers\Admin\Auth\LogOutController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Auth\LogInController as AuthLogInController;
use App\Http\Controllers\Auth\LogOutController as AuthLogOutController;
use App\Http\Controllers\Auth\SendCodeController;
use App\Http\Controllers\Cart\ChangeQuantityController;
use App\Http\Controllers\Cart\RemoveItemController;
use App\Http\Controllers\Clients\AddAddressController;
use App\Http\Controllers\Clients\DeleteAccountController;
use App\Http\Controllers\Clients\DeleteAddressController;
use App\Http\Controllers\Clients\UpdatePersonalInfoController;
use App\Http\Controllers\Forms\HandleController;
use App\Http\Controllers\Fragments\RefreshController;
use App\Http\Controllers\Orders\CheckoutController as OrdersCheckoutController;
use App\Http\Controllers\Orders\OrderCarController as OrdersOrderCarController;
use App\Http\Controllers\Orders\RepeatController;
use App\Http\Controllers\Pages\AboutUsController;
use App\Http\Controllers\Pages\CabinetController;
use App\Http\Controllers\Pages\CartController;
use App\Http\Controllers\Pages\CheckoutController;
use App\Http\Controllers\Pages\CompleteController;
use App\Http\Controllers\Pages\EstablishmentsController;
use App\Http\Controllers\Pages\GetCatalogHtmlController;
use App\Http\Controllers\Pages\HomeController;
use App\Http\Controllers\Pages\OrderCarController;
use App\Http\Controllers\Pages\ProductsController;
use App\Http\Controllers\Pages\PromotionController;
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
Route::get('/', HomeController::class)
    ->name('pages.home'); 
Route::get('/pro-nas', AboutUsController::class)
    ->name('pages.about-us'); 
Route::get('/akciyi/{promotion:slug}', PromotionController::class)
    ->name('pages.promotion'); 
Route::get('/zaklady', EstablishmentsController::class)
    ->name('pages.zaklady');  
Route::get('/product-category/{category:slug}', ProductsController::class)
    ->name('pages.category'); 
Route::get('/catalog-html/{category}', GetCatalogHtmlController::class)
    ->name('pages.catalog-html');
Route::get('/cabinet', CabinetController::class)
    ->middleware(['auth:web',])
    ->name('pages.cabinet');
Route::get('/korzyna', CartController::class)
    ->name('pages.cart'); 
Route::get('/oformlennya', CheckoutController::class)
    ->name('pages.checkout');  
Route::get('/zaversheno', CompleteController::class)
    ->name('pages.complete'); 
Route::get('/zamoviti-avto', OrderCarController::class)
    ->name('pages.order-car'); 

/**
 * Fragments
 */
Route::get('/fragments/refresh', RefreshController::class)
    ->name('fragments.refresh');
    
/**
 * Update personal info
 */
Route::post('/update-personal-info', UpdatePersonalInfoController::class)
    ->middleware(['auth:web',])
    ->name('update-personal-info'); 

/**
 * Addresses
 */
Route::prefix('/addresses')
    ->name('addresses.')
    ->middleware(['auth:web',])
    ->group(function () {
    Route::post('/', AddAddressController::class)
        ->name('add'); 
    Route::delete('/', DeleteAddressController::class)
        ->name('delete'); 
});

/**
 * Delete Account
 */
Route::delete('/delete-account', DeleteAccountController::class)
    ->middleware(['auth:web',])
    ->name('delete-account');
    
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
 * Repeat order
 */
Route::post('/orders/{order}/repeat', RepeatController::class)
    ->middleware(['auth:web',])
    ->name('orders.repeat'); 

/**
 * Order car
 */
Route::post('/orders/order-car', OrdersOrderCarController::class)
    ->middleware(['auth:web',])
    ->name('orders.order-car'); 

/**
 * Checkout
 */
Route::post('/checkout', OrdersCheckoutController::class)
    ->name('checkout'); 

/**
 * Form
 */
Route::post('/form', HandleController::class)
    ->name('form');