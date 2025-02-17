<?php

use App\Http\Controllers\Admin\Analytics\IncomeController;
use App\Http\Controllers\Admin\Analytics\OrdersController;
use App\Http\Controllers\Admin\Analytics\ProductsController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\Auth\SendResetLinkController;
use App\Http\Controllers\Admin\Cars\BulkDeleteController as CarsBulkDeleteController;
use App\Http\Controllers\Admin\Cars\DeleteController as CarsDeleteController;
use App\Http\Controllers\Admin\Cars\IndexController as CarsIndexController;
use App\Http\Controllers\Admin\Cars\StoreController as CarsStoreController;
use App\Http\Controllers\Admin\Cars\UpdateController as CarsUpdateController;
use App\Http\Controllers\Admin\Couriers\Cashes\DeleteController as CashesDeleteController;
use App\Http\Controllers\Admin\Couriers\Cashes\StoreController as CashesStoreController;
use App\Http\Controllers\Admin\Couriers\Cashes\UpdateController as CashesUpdateController;
use App\Http\Controllers\Admin\Categories\BulkDeleteController as CategoriesBulkDeleteController;
use App\Http\Controllers\Admin\Categories\DeleteController as CategoriesDeleteController;
use App\Http\Controllers\Admin\Categories\GetAllController;
use App\Http\Controllers\Admin\Categories\GetProducts;
use App\Http\Controllers\Admin\Categories\GetTreeController;
use App\Http\Controllers\Admin\Categories\IndexController as CategoriesIndexController;
use App\Http\Controllers\Admin\Categories\ReorderController;
use App\Http\Controllers\Admin\Categories\ReorderProductsController;
use App\Http\Controllers\Admin\Categories\SearchZakladyController;
use App\Http\Controllers\Admin\Categories\StoreController as CategoriesStoreController;
use App\Http\Controllers\Admin\Categories\Tags\DeleteController as TagsDeleteController;
use App\Http\Controllers\Admin\Categories\Tags\GetController;
use App\Http\Controllers\Admin\Categories\Tags\ReorderController as TagsReorderController;
use App\Http\Controllers\Admin\Categories\Tags\StoreController as TagsStoreController;
use App\Http\Controllers\Admin\Categories\Tags\UpdateController as TagsUpdateController;
use App\Http\Controllers\Admin\Categories\UpdateController as CategoriesUpdateController;
use App\Http\Controllers\Admin\Clients\BulkDeleteController as ClientsBulkDeleteController;
use App\Http\Controllers\Admin\Clients\DeleteController as ClientsDeleteController;
use App\Http\Controllers\Admin\Clients\FindOrCreateController;
use App\Http\Controllers\Admin\Clients\GetOrdersController;
use App\Http\Controllers\Admin\Clients\IndexController as ClientsIndexController;
use App\Http\Controllers\Admin\Clients\SearchController;
use App\Http\Controllers\Admin\Clients\StoreController as ClientsStoreController;
use App\Http\Controllers\Admin\Clients\UpdateController as ClientsUpdateController;
use App\Http\Controllers\Admin\Content\GetController as ContentGetController;
use App\Http\Controllers\Admin\Content\SaveController;
use App\Http\Controllers\Admin\Couriers\BulkDeleteController as CouriersBulkDeleteController;
use App\Http\Controllers\Admin\Couriers\DeleteController as CouriersDeleteController;
use App\Http\Controllers\Admin\Couriers\GetAllController as CouriersGetAllController;
use App\Http\Controllers\Admin\Couriers\GetCurrentLocationsController;
use App\Http\Controllers\Admin\Couriers\IndexController as CouriersIndexController;
use App\Http\Controllers\Admin\Couriers\StoreController as CouriersStoreController;
use App\Http\Controllers\Admin\Couriers\UpdateController as CouriersUpdateController;
use App\Http\Controllers\Admin\Images\UploadController;
use App\Http\Controllers\Admin\Orders\BulkDeleteController as OrdersBulkDeleteController;
use App\Http\Controllers\Admin\Orders\ChangeCourierController;
use App\Http\Controllers\Admin\Orders\ChangeStatusController;
use App\Http\Controllers\Admin\Orders\DeleteController as OrdersDeleteController;
use App\Http\Controllers\Admin\Orders\GetBetweenController;
use App\Http\Controllers\Admin\Orders\IndexController as OrdersIndexController;
use App\Http\Controllers\Admin\Orders\StoreController as OrdersStoreController;
use App\Http\Controllers\Admin\Orders\UpdateController as OrdersUpdateController;
use App\Http\Controllers\Admin\Products\BulkDeleteController as ProductsBulkDeleteController;
use App\Http\Controllers\Admin\Products\DeleteController as ProductsDeleteController;
use App\Http\Controllers\Admin\Products\IndexController as ProductsIndexController;
use App\Http\Controllers\Admin\Products\SearchController as ProductsSearchController;
use App\Http\Controllers\Admin\Products\StoreController as ProductsStoreController;
use App\Http\Controllers\Admin\Products\UpdateController as ProductsUpdateController;
use App\Http\Controllers\Admin\Promotions\BulkDeleteController as PromotionsBulkDeleteController;
use App\Http\Controllers\Admin\Promotions\DeleteController as PromotionsDeleteController;
use App\Http\Controllers\Admin\Promotions\IndexController as PromotionsIndexController;
use App\Http\Controllers\Admin\Promotions\StoreController as PromotionsStoreController;
use App\Http\Controllers\Admin\Promotions\UpdateController as PromotionsUpdateController;
use App\Http\Controllers\Admin\Regions\DeleteController as RegionsDeleteController;
use App\Http\Controllers\Admin\Regions\GetAllController as RegionsGetAllController;
use App\Http\Controllers\Admin\Regions\StoreController as RegionsStoreController;
use App\Http\Controllers\Admin\Regions\UpdateController as RegionsUpdateController;
use App\Http\Controllers\Admin\Tariffs\BulkDeleteController as TariffsBulkDeleteController;
use App\Http\Controllers\Admin\Tariffs\DeleteController as TariffsDeleteController;
use App\Http\Controllers\Admin\Tariffs\GetAllController as TariffsGetAllController;
use App\Http\Controllers\Admin\Tariffs\IndexController as TariffsIndexController;
use App\Http\Controllers\Admin\Tariffs\SetDefaultController;
use App\Http\Controllers\Admin\Tariffs\StoreController as TariffsStoreController;
use App\Http\Controllers\Admin\Tariffs\UpdateController as TariffsUpdateController;
use App\Http\Controllers\Admin\Users\BulkDeleteController;
use App\Http\Controllers\Admin\Users\DeleteController;
use App\Http\Controllers\Admin\Users\IndexController;
use App\Http\Controllers\Admin\Users\StoreController;
use App\Http\Controllers\Admin\Users\UpdateController;
use App\Http\Controllers\Price\CalcForRouteController;
use App\Http\Controllers\Price\GetSettingsController;
use App\Http\Controllers\Price\SaveSettingsController;
use Illuminate\Support\Facades\Route;

Route::domain(config('app.admin_domain'))->group(function () {
    Route::name('password.')->group(function () {
        Route::post('/send-reset-link', SendResetLinkController::class)
            ->name('send-reset-link');
        Route::post('/reset-password', ResetPasswordController::class)
            ->name('reset');
    });

    Route::middleware(['auth:sanctum',])->group(function () {
        Route::prefix('/users')->name('users.')->group(function () {
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

        Route::prefix('/couriers')->name('couriers.')->group(function () {
            Route::get('/', CouriersIndexController::class)
                ->name('index');
            Route::get('/all', CouriersGetAllController::class)
                ->name('all');
            Route::get('/current-locations', GetCurrentLocationsController::class)
                ->name('current-locations');
            Route::post('/', CouriersStoreController::class)
                ->name('store');
            Route::put('/{courier}', CouriersUpdateController::class)
                ->name('update');
            Route::delete('/bulk', CouriersBulkDeleteController::class)
                ->name('bulk-delete');
            Route::delete('/{courier}', CouriersDeleteController::class)
                ->name('delete');

            Route::prefix('/{courier}/cashes')->name('cashes.')->group(function () {
                Route::post('/', CashesStoreController::class)
                    ->name('store');
                Route::put('/{cash}', CashesUpdateController::class)
                    ->name('update');
                Route::delete('/{cash}', CashesDeleteController::class)
                    ->name('delete');
            });
        });

        Route::prefix('/products')->name('products.')->group(function () {
            Route::get('/', ProductsIndexController::class)
                ->name('index');
            Route::get('/search', ProductsSearchController::class)
                ->name('search');
            Route::post('/', ProductsStoreController::class)
                ->name('store');
            Route::put('/{product}', ProductsUpdateController::class)
                ->name('update');
            Route::delete('/bulk', ProductsBulkDeleteController::class)
                ->name('bulk-delete');
            Route::delete('/{product}', ProductsDeleteController::class)
                ->name('delete');
        });

        Route::prefix('/categories')->name('categories.')->group(function () {
            Route::get('/', CategoriesIndexController::class)
                ->name('index');
            Route::get('/all', GetAllController::class)
                ->name('all');
            Route::get('/tree', GetTreeController::class)
                ->name('tree');
            Route::get('/{category}/products', GetProducts::class)
                ->name('products');
            Route::get('/search-zaklady', SearchZakladyController::class)
                ->name('search-zaklady');
            Route::post('/', CategoriesStoreController::class)
                ->name('store');
            Route::put('/{category}', CategoriesUpdateController::class)
                ->name('update');
            Route::delete('/bulk', CategoriesBulkDeleteController::class)
                ->name('bulk-delete');
            Route::delete('/{category}', CategoriesDeleteController::class)
                ->name('delete');
            Route::post('/reorder', ReorderController::class)
                ->name('reorder');
            Route::post('/{category}/reorder-products', ReorderProductsController::class)
                ->name('reorder-products');

            Route::prefix('/tags')->name('tags.')->group(function () {
                Route::get('/', GetController::class)
                    ->name('get');
                Route::post('/', TagsStoreController::class)
                    ->name('store');
                Route::put('/{categoryTag}', TagsUpdateController::class)
                    ->name('update');
                Route::delete('/{categoryTag}', TagsDeleteController::class)
                    ->name('delete');
                Route::post('/reorder', TagsReorderController::class)
                    ->name('reorder');
            });
        });

        Route::prefix('/images')->name('images.')->group(function () {
            Route::post('/upload', UploadController::class)
                ->name('upload');
        });

        Route::prefix('/clients')->name('clients.')->group(function () {
            Route::get('/', ClientsIndexController::class)
                ->name('index');
            Route::get('/search', SearchController::class)
                ->name('search');
            Route::get('/{client}/orders', GetOrdersController::class)
                ->name('orders.get');
            Route::post('/', ClientsStoreController::class)
                ->name('store');
            Route::post('/find-or-create', FindOrCreateController::class)
                ->name('find-or-create');
            Route::put('/{client}', ClientsUpdateController::class)
                ->name('update');
            Route::delete('/bulk', ClientsBulkDeleteController::class)
                ->name('bulk-delete');
            Route::delete('/{client}', ClientsDeleteController::class)
                ->name('delete');
        });

        Route::prefix('/orders')->name('orders.')->group(function () {
            Route::get('/', OrdersIndexController::class)
                ->name('index');
            Route::get('/between', GetBetweenController::class)
                ->name('between');
            Route::post('/', OrdersStoreController::class)
                ->name('store');
            Route::post('/{order}/status', ChangeStatusController::class)
                ->name('change-status');
            Route::post('/{order}/courier', ChangeCourierController::class)
                ->name('change-courier');
            Route::put('/{order}', OrdersUpdateController::class)
                ->name('update');
            Route::delete('/bulk', OrdersBulkDeleteController::class)
                ->name('bulk-delete');
            Route::delete('/{order}', OrdersDeleteController::class)
                ->name('delete');
        });

        Route::prefix('/promotions')->name('promotions.')->group(function () {
            Route::get('/', PromotionsIndexController::class)
                ->name('index');
            Route::post('/', PromotionsStoreController::class)
                ->name('store');
            Route::put('/{promotion}', PromotionsUpdateController::class)
                ->name('update');
            Route::delete('/bulk', PromotionsBulkDeleteController::class)
                ->name('bulk-delete');
            Route::delete('/{promotion}', PromotionsDeleteController::class)
                ->name('delete');
        });

        Route::prefix('/cars')->name('cars.')->group(function () {
            Route::get('/', CarsIndexController::class)
                ->name('index');
            Route::post('/', CarsStoreController::class)
                ->name('store');
            Route::put('/{car}', CarsUpdateController::class)
                ->name('update');
            Route::delete('/bulk', CarsBulkDeleteController::class)
                ->name('bulk-delete');
            Route::delete('/{car}', CarsDeleteController::class)
                ->name('delete');
        });

        Route::prefix('/analytics')->name('analytics.')->group(function () {
            Route::get('/income', IncomeController::class)
                ->name('income');
            Route::get('/orders', OrdersController::class)
                ->name('orders');
            Route::get('/products', ProductsController::class)
                ->name('products');
        });

        Route::prefix('/content')->name('content.')->group(function () {
            Route::get('/', ContentGetController::class)
                ->name('get');
            Route::post('/', SaveController::class)
                ->name('save');
        });

        Route::prefix('/tariffs')->name('tariffs.')->group(function () {
            Route::get('/', TariffsIndexController::class)
                ->name('index');
            Route::get('/all', TariffsGetAllController::class)
                ->name('all');
            Route::post('/', TariffsStoreController::class)
                ->name('store');
            Route::put('/{tariff}', TariffsUpdateController::class)
                ->name('update');
            Route::post('/{tariff}/set-default', SetDefaultController::class)
                ->name('set-default');
            Route::delete('/bulk', TariffsBulkDeleteController::class)
                ->name('bulk-delete');
            Route::delete('/{tariff}', TariffsDeleteController::class)
                ->name('delete');
        });

        Route::prefix('/regions')->name('regions.')->group(function () {
            Route::get('/all', RegionsGetAllController::class)
                ->name('all');
            Route::post('/', RegionsStoreController::class)
                ->name('store');
            Route::put('/{region}', RegionsUpdateController::class)
                ->name('update');
            Route::delete('/{region}', RegionsDeleteController::class)
                ->name('delete');
        });

        Route::prefix('/price')->name('price.')->group(function () {
            Route::post('/calc-for-route', CalcForRouteController::class)
                ->name('price-for-route');
            Route::get('/settings', GetSettingsController::class)
                ->name('settings.get');
            Route::post('/settings', SaveSettingsController::class)
                ->name('settings.save');
        });
    });
});