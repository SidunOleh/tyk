<?php

namespace App\Http\Controllers\Admin\CourierServices;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourierService\CourierServiceSearchCollection;
use App\Services\CourierServices\CourierServiceService;

class GetController extends Controller
{
    public function __construct(
        public CourierServiceService $courierServiceService
    )
    {
        
    }

    public function __invoke()
    {
        $courierServices = $this->courierServiceService->all();

        return response(new CourierServiceSearchCollection($courierServices));
    }
}
