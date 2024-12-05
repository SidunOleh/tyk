<?php

namespace App\Providers;

use App\Services\WC\Api;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Automattic\WooCommerce\Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(Api::class, function (Application $app) {
            return new Api(new Client(
                config('services.wc.url'),
                config('services.wc.key'),
                config('services.wc.secret'),
                [
                    'version' => config('services.wc.version'),
                ]
            ));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
