<?php

use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SendResetLinkController;
use App\Http\Controllers\Cashes\DeleteController as CashesDeleteController;
use App\Http\Controllers\Cashes\StoreController as CashesStoreController;
use App\Http\Controllers\Cashes\UpdateController as CashesUpdateController;
use App\Http\Controllers\Couriers\BulkDeleteController as CouriersBulkDeleteController;
use App\Http\Controllers\Couriers\DeleteController as CouriersDeleteController;
use App\Http\Controllers\Couriers\IndexController as CouriersIndexController;
use App\Http\Controllers\Couriers\StoreController as CouriersStoreController;
use App\Http\Controllers\Couriers\UpdateController as CouriersUpdateController;
use App\Http\Controllers\Products\IndexController as ProductsIndexController;
use App\Http\Controllers\Users\BulkDeleteController;
use App\Http\Controllers\Users\DeleteController;
use App\Http\Controllers\Users\IndexController;
use App\Http\Controllers\Users\StoreController;
use App\Http\Controllers\Users\UpdateController;
use Illuminate\Support\Facades\Route;

Route::name('password.')->group(function () {
    Route::post('/send-reset-link', SendResetLinkController::class)
        ->name('send-reset-link');
    Route::post('/reset-password', ResetPasswordController::class)
        ->name('reset');
});

Route::middleware(['auth:sanctum',])->group(function () {
    Route::prefix('/users')
        ->name('users.')
        ->group(function () {
        Route::get('/', IndexController::class)
            ->name('index');
        Route::post('/', StoreController::class)
            ->name('store');
        Route::put('/{user}', UpdateController::class)
            ->name('update');
        Route::delete('/bulk', BulkDeleteController::class)
            ->name('bulk-delete');
        Route::delete('/{user}', DeleteController::class)
            ->name('delete');
    });

    Route::prefix('/couriers')
        ->name('couriers.')
        ->group(function () {
        Route::get('/', CouriersIndexController::class)
            ->name('index');
        Route::post('/', CouriersStoreController::class)
            ->name('store');
        Route::put('/{courier}', CouriersUpdateController::class)
            ->name('update');
        Route::delete('/bulk', CouriersBulkDeleteController::class)
            ->name('bulk-delete');
        Route::delete('/{courier}', CouriersDeleteController::class)
            ->name('delete');
    });

    Route::prefix('/cashes')
        ->name('cashes.')
        ->group(function () {
        Route::post('/', CashesStoreController::class)
            ->name('store');
        Route::put('/{cash}', CashesUpdateController::class)
            ->name('update');
        Route::delete('/{cash}', CashesDeleteController::class)
            ->name('delete');
    });

    Route::prefix('/products')
        ->name('products.')
        ->group(function () {
        Route::get('/', ProductsIndexController::class)
            ->name('index');
    });
});