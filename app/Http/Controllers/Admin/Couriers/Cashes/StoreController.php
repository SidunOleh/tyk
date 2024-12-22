<?php

namespace App\Http\Controllers\Admin\Couriers\Cashes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Couriers\Cashes\StoreRequest;
use App\Models\Courier;
use App\Services\Couriers\CourierService;

class StoreController extends Controller
{
    public function __construct(
        public CourierService $courierService
    )
    {
        
    }

    public function __invoke(Courier $courier, StoreRequest $request)
    {
        $cash = $this->courierService->createCash($courier, $request);

        return response(['cash' => $cash,]);
    }
}
