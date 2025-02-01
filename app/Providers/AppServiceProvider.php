<?php

namespace App\Providers;

use App\Services\Cart\Cart;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View as ViewView;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(Cart::class, function (Application $app) {
            return Cart::make(Auth::guard('web')->check() ? 'db' : 'session');
        });

        View::composer(['*'], function (ViewView $view) {
            $cart = app()->make(Cart::class);

            $view->with('cartTotal', $cart->formattedTotal());
        });

        // DB::listen(fn($sql) => $GLOBALS['sql'][] = $sql);
    }
}
