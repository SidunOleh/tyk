<?php

namespace App\Http\Controllers\Admin\Couriers\Cashes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Couriers\Cashes\UpdateRequest;
use App\Models\Cash;
use App\Models\Courier;
use App\Services\Couriers\CourierService;

class UpdateController extends Controller
{
    public function __construct(
        public CourierService $courierService
    )
    {
        
    }

    public function __invoke(Courier $courier, Cash $cash, UpdateRequest $request)
    {
        $this->courierService->updateCash($courier, $cash, $request);

        return response(['cash' => $cash,]);
    }
}
