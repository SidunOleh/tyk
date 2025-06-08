<?php

use App\Http\Controllers\Admin\Analytics\IncomeController;
use App\Http\Controllers\Admin\Analytics\OrdersController;
use App\Http\Controllers\Admin\Analytics\ProductsController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\Auth\SendResetLinkController;
use App\Http\Controllers\Admin\Cars\BulkDeleteController as CarsBulkDeleteController;
use App\Http\Controllers\Admin\Cars\DeleteController as CarsDeleteController;
use App\Http\Controllers\Admin\Cars\GetAllController as CarsGetAllController;
use App\Http\Controllers\Admin\Cars\IndexController as CarsIndexController;
use App\Http\Controllers\Admin\Cars\StoreController as CarsStoreController;
use App\Http\Controllers\Admin\Cars\UpdateController as CarsUpdateController;
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
use App\Http\Controllers\Admin\Couriers\GetCurrentController as CouriersGetCurrentController;
use App\Http\Controllers\Admin\Couriers\GetCurrentLocationsController;
use App\Http\Controllers\Admin\Couriers\IndexController as CouriersIndexController;
use App\Http\Controllers\Admin\Couriers\StoreController as CouriersStoreController;
use App\Http\Controllers\Admin\Couriers\UpdateController as CouriersUpdateController;
use App\Http\Controllers\Admin\CourierServices\DeleteController as CourierServicesDeleteController;
use App\Http\Controllers\Admin\CourierServices\GetController as CourierServicesGetController;
use App\Http\Controllers\Admin\CourierServices\StoreController as CourierServicesStoreController;
use App\Http\Controllers\Admin\CourierServices\UpdateController as CourierServicesUpdateController;
use App\Http\Controllers\Admin\Driver\ChangePasswordController;
use App\Http\Controllers\Admin\Driver\CurrentWorkShiftController;
use App\Http\Controllers\Admin\Driver\GetController as DriverGetController;
use App\Http\Controllers\Admin\Driver\StatisticController;
use App\Http\Controllers\Admin\Driver\UpdateController as DriverUpdateController;
use App\Http\Controllers\Admin\Driver\WorkShiftsController;
use App\Http\Controllers\Admin\Images\UploadController;
use App\Http\Controllers\Admin\Orders\BulkDeleteController as OrdersBulkDeleteController;
use App\Http\Controllers\Admin\Orders\ChangeCourierController;
use App\Http\Controllers\Admin\Orders\ChangeStatusController;
use App\Http\Controllers\Admin\Orders\ChangeTimeContoller;
use App\Http\Controllers\Admin\Orders\DeleteController as OrdersDeleteController;
use App\Http\Controllers\Admin\Orders\GetBetweenController;
use App\Http\Controllers\Admin\Orders\IndexController as OrdersIndexController;
use App\Http\Controllers\Admin\Orders\ReviewController;
use App\Http\Controllers\Admin\Orders\StoreController as OrdersStoreController;
use App\Http\Controllers\Admin\Orders\UpdateController as OrdersUpdateController;
use App\Http\Controllers\Admin\Products\BulkDeleteController as ProductsBulkDeleteController;
use App\Http\Controllers\Admin\Products\DeleteController as ProductsDeleteController;
use App\Http\Controllers\Admin\Products\GetPackagingController;
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
use App\Http\Controllers\Admin\Settings\GetController as SettingsGetController;
use App\Http\Controllers\Admin\Settings\SaveController as SettingsSaveController;
use App\Http\Controllers\Admin\Tariffs\BulkDeleteController as TariffsBulkDeleteController;
use App\Http\Controllers\Admin\Tariffs\DeleteController as TariffsDeleteController;
use App\Http\Controllers\Admin\Tariffs\GetAllController as TariffsGetAllController;
use App\Http\Controllers\Admin\Tariffs\IndexController as TariffsIndexController;
use App\Http\Controllers\Admin\Tariffs\SetDefaultController;
use App\Http\Controllers\Admin\Tariffs\StoreController as TariffsStoreController;
use App\Http\Controllers\Admin\Tariffs\UpdateController as TariffsUpdateController;
use App\Http\Controllers\Admin\Users\BulkDeleteController;
use App\Http\Controllers\Admin\Users\DeleteController;
use App\Http\Controllers\Admin\Users\GetDispatchersController;
use App\Http\Controllers\Admin\Users\IndexController;
use App\Http\Controllers\Admin\Users\StoreController;
use App\Http\Controllers\Admin\Users\UpdateController;
use App\Http\Controllers\Admin\WorkShifts\Drivers\GetStatController;
use App\Http\Controllers\Admin\WorkShifts\CloseController;
use App\Http\Controllers\Admin\WorkShifts\Dispatchers\CloseController as DispatchersCloseController;
use App\Http\Controllers\Admin\WorkShifts\Dispatchers\GetStatController as DispatchersGetStatController;
use App\Http\Controllers\Admin\WorkShifts\Dispatchers\OpenController as DispatchersOpenController;
use App\Http\Controllers\Admin\WorkShifts\Drivers\CloseController as DriversCloseController;
use App\Http\Controllers\Admin\WorkShifts\Drivers\OpenController as DriversOpenController;
use App\Http\Controllers\Admin\WorkShifts\Drivers\UpdateController as DriversUpdateController;
use App\Http\Controllers\Admin\WorkShifts\GetCurrentController;
use App\Http\Controllers\Admin\WorkShifts\GetStatController as WorkShiftsGetStatController;
use App\Http\Controllers\Admin\WorkShifts\IndexController as WorkShiftsIndexController;
use App\Http\Controllers\Admin\WorkShifts\OpenController;
use App\Http\Controllers\Admin\WorkShifts\ZakladReports\UpdateController as ZakladReportsUpdateController;
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
                ->name('index')
                ->middleware('has_role:адмін');
            Route::get('/dispatchers', GetDispatchersController::class)
                ->name('dispatchers')
                ->middleware('has_role:адмін,диспетчер');
            Route::post('/', StoreController::class)
                ->name('store')
                ->middleware('has_role:адмін');
            Route::put('/{user}', UpdateController::class)
                ->name('update')
                ->middleware('has_role:адмін');
            Route::delete('/bulk', BulkDeleteController::class)
                ->name('bulk-delete')
                ->middleware('has_role:адмін');
            Route::delete('/{user}', DeleteController::class)
                ->name('delete')
                ->middleware('has_role:адмін');
        });

        Route::prefix('/couriers')->name('couriers.')->middleware('has_role:адмін,диспетчер')->group(function () {
            Route::get('/', CouriersIndexController::class)
                ->name('index');
            Route::get('/all', CouriersGetAllController::class)
                ->name('all');
            Route::get('/current', CouriersGetCurrentController::class)
                ->name('current');
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
        });

        Route::prefix('/products')->name('products.')->middleware('has_role:адмін,диспетчер')->group(function () {
            Route::get('/', ProductsIndexController::class)
                ->name('index');
            Route::get('/search', ProductsSearchController::class)
                ->name('search');
            Route::get('/packaging', GetPackagingController::class)
                ->name('packaging');
            Route::post('/', ProductsStoreController::class)
                ->name('store');
            Route::put('/{product}', ProductsUpdateController::class)
                ->name('update');
            Route::delete('/bulk', ProductsBulkDeleteController::class)
                ->name('bulk-delete');
            Route::delete('/{product}', ProductsDeleteController::class)
                ->name('delete');
        });

        Route::prefix('/categories')->name('categories.')->middleware('has_role:адмін,диспетчер')->group(function () {
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

            Route::prefix('/tags')->name('tags.')->middleware('has_role:адмін,диспетчер')->group(function () {
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

        Route::prefix('/images')->name('images.')->middleware('has_role:адмін,диспетчер')->group(function () {
            Route::post('/upload', UploadController::class)
                ->name('upload');
        });

        Route::prefix('/clients')->name('clients.')->middleware('has_role:адмін,диспетчер')->group(function () {
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

        Route::prefix('/orders')->name('orders.')->middleware('has_role:адмін,диспетчер')->group(function () {
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
            Route::post('/{order}/time', ChangeTimeContoller::class)
                ->name('change-time');
            Route::post('/{order}/review', ReviewController::class)
                ->name('review');
            Route::put('/{order}', OrdersUpdateController::class)
                ->name('update');
            Route::delete('/bulk', OrdersBulkDeleteController::class)
                ->name('bulk-delete');
            Route::delete('/{order}', OrdersDeleteController::class)
                ->name('delete');
        });

        Route::prefix('/promotions')->name('promotions.')->middleware('has_role:адмін,диспетчер')->group(function () {
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

        Route::prefix('/cars')->name('cars.')->middleware('has_role:адмін,диспетчер')->group(function () {
            Route::get('/', CarsIndexController::class)
                ->name('index');
            Route::get('/all', CarsGetAllController::class)
                ->name('all');
            Route::post('/', CarsStoreController::class)
                ->name('store');
            Route::put('/{car}', CarsUpdateController::class)
                ->name('update');
            Route::delete('/bulk', CarsBulkDeleteController::class)
                ->name('bulk-delete');
            Route::delete('/{car}', CarsDeleteController::class)
                ->name('delete');
        });

        Route::prefix('/analytics')->name('analytics.')->middleware('has_role:адмін')->group(function () {
            Route::get('/income', IncomeController::class)
                ->name('income');
            Route::get('/orders', OrdersController::class)
                ->name('orders');
            Route::get('/products', ProductsController::class)
                ->name('products');
        });

        Route::prefix('/content')->name('content.')->middleware('has_role:адмін,диспетчер')->group(function () {
            Route::get('/', ContentGetController::class)
                ->name('get');
            Route::post('/', SaveController::class)
                ->name('save');
        });

        Route::prefix('/tariffs')->name('tariffs.')->middleware('has_role:адмін')->group(function () {
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

        Route::prefix('/regions')->name('regions.')->middleware('has_role:адмін')->group(function () {
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
                ->name('price-for-route')
                ->middleware('has_role:адмін,диспетчер');
            Route::get('/settings', GetSettingsController::class)
                ->name('settings.get')
                ->middleware('has_role:адмін');
            Route::post('/settings', SaveSettingsController::class)
                ->name('settings.save')
                ->middleware('has_role:адмін');
        });

        Route::prefix('/work-shifts')->name('work-shifts.')->group(function () {
            Route::get('/', WorkShiftsIndexController::class)
                ->name('index')
                ->middleware('has_role:адмін,диспетчер');
            Route::get('/current', GetCurrentController::class)
                ->name('current')
                ->middleware('has_role:адмін,диспетчер');
            Route::post('/open', OpenController::class)
                ->name('open')
                ->middleware('has_role:адмін,диспетчер');
            Route::get('/{workShift}/stat', WorkShiftsGetStatController::class)
                ->name('stat')
                ->middleware('has_role:адмін,диспетчер');
            Route::post('/{workShift}/close', CloseController::class)
                ->name('close')
                ->middleware('has_role:адмін');

            Route::post('/{workShift}/drivers/open', DriversOpenController::class)
                ->name('drivers.open')
                ->middleware('has_role:адмін,диспетчер');
            Route::get('/drivers/{driverWorkShift}/stat', GetStatController::class)
                ->name('drivers.stat')
                ->middleware('has_role:адмін,диспетчер');
            Route::post('/drivers/{driverWorkShift}/close', DriversCloseController::class)
                ->name('drivers.close')
                ->middleware('has_role:адмін,диспетчер');
            Route::post('/drivers/{driverWorkShift}', DriversUpdateController::class)
                ->name('drivers.update')
                ->middleware('has_role:адмін,диспетчер');

            Route::post('/{workShift}/dispatchers/open', DispatchersOpenController::class)
                ->name('dispatchers.open')
                ->middleware('has_role:адмін,диспетчер');
            Route::get('/dispatchers/{dispatcherWorkShift}/stat', DispatchersGetStatController::class)
                ->name('dipatchers.stat')
                ->middleware('has_role:адмін,диспетчер');
            Route::post('/dispatchers/{dispatcherWorkShift}/close', DispatchersCloseController::class)
                ->name('dispatchers.close')
                ->middleware('has_role:адмін,диспетчер');
                
            Route::post('/zaklad-reports/{zakladReport}', ZakladReportsUpdateController::class)
                ->name('zaklad-reports.update')
                ->middleware('has_role:адмін,диспетчер');
        });

        Route::prefix('/settings')->name('settings.')->middleware('has_role:адмін')->group(function () {
            Route::get('/', SettingsGetController::class)
                ->name('get');
            Route::post('/', SettingsSaveController::class)
                ->name('save');
        });

        Route::prefix('/courier-services')->name('courier-services.')->group(function () {
            Route::get('/all', CourierServicesGetController::class)
                ->middleware('has_role:адмін,диспетчер')
                ->name('all');
            Route::post('/', CourierServicesStoreController::class)
                ->middleware('has_role:адмін')
                ->name('store');
            Route::put('/{courierService}', CourierServicesUpdateController::class)
                ->middleware('has_role:адмін')
                ->name('update');
            Route::delete('/{courierService}', CourierServicesDeleteController::class)
                ->middleware('has_role:адмін')
                ->name('delete');
        });

        Route::prefix('/driver')->name('driver.')->middleware('has_role:кур\'єр')->group(function () {
            Route::get('/', DriverGetController::class)
                ->name('get');
            Route::get('/statistic', StatisticController::class)
                ->name('statistic');
            Route::put('/', DriverUpdateController::class)
                ->name('update');
            Route::post('/change-password', ChangePasswordController::class)
                ->name('change-password');
            Route::get('/work-shifts', WorkShiftsController::class)
                ->name('work-shifts');
            Route::get('/work-shifts/current', CurrentWorkShiftController::class)
                ->name('work-shifts.current');
        });
    });
});