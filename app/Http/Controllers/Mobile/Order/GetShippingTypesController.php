<?php

namespace App\Http\Controllers\Mobile\Order;

use App\Http\Controllers\Controller;
use App\Services\CourierServices\CourierServiceService;

class GetShippingTypesController extends Controller
{
    public function __construct(
        public CourierServiceService $courierServiceService
    )
    {
        
    }

    public function __invoke()
    {
        $courierServices = $this->courierServiceService->visible();

        return response($courierServices->pluck('name'));
    }
}
