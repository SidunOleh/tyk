<?php

namespace App\Http\Controllers\Admin\Couriers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Courier\CouriersSearchCollection;
use App\Services\Couriers\CourierService;

class GetAllController extends Controller
{
    public function __construct(
        public CourierService $courierService
    )
    {
        
    }

    public function __invoke()
    {
        $couriers = $this->courierService->all();

        return response(new CouriersSearchCollection($couriers));
    }
}
