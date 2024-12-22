<?php

namespace App\Http\Controllers\Admin\Couriers\Cashes;

use App\Http\Controllers\Controller;
use App\Models\Cash;
use App\Models\Courier;
use App\Services\Couriers\CourierService;

class DeleteController extends Controller
{
    public function __construct(
        public CourierService $courierService
    )
    {
        
    }

    public function __invoke(Courier $courier, Cash $cash)
    {
        $this->courierService->deleteCash($courier, $cash);

        return response(['message' => 'OK',]);
    }
}
