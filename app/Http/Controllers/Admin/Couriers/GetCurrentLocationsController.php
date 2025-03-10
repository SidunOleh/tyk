<?php

namespace App\Http\Controllers\Admin\Couriers;

use App\Http\Controllers\Controller;
use App\Services\Couriers\CourierService;

class GetCurrentLocationsController extends Controller
{
    public function __construct(
        public CourierService $courierService
    )
    {
        
    }

    public function __invoke()
    {
        $data = $this->courierService->getCurrentLocations();

        return response(['data' => $data,]);
    }
}
