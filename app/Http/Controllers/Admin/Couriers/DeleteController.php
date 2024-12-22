<?php

namespace App\Http\Controllers\Admin\Couriers;

use App\Http\Controllers\Controller;
use App\Models\Courier;
use App\Services\Couriers\CourierService;

class DeleteController extends Controller
{
    public function __construct(
        public CourierService $courierService
    )
    {
        
    }

    public function __invoke(Courier $courier)
    {
        $this->courierService->delete($courier);

        return response(['message' => 'OK',]);
    }
}
