<?php

use App\Http\Controllers\Admin\Auth\LogInController;
use App\Http\Controllers\Admin\Auth\LogOutController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Pages\EstablishmentsController;
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
 * Pages
 */
Route::get('/', HomeController::class)
    ->name('pages.home'); 
Route::get('/zakladi', EstablishmentsController::class)
    ->name('pages.zakladi');  
Route::get('/zakladi/{zaklad}', ProductsController::class)
    ->name('pages.zaklad'); 
