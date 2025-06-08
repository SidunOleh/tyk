<?php

namespace App\Http\Controllers\Admin\Couriers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Couriers\StoreRequest;
use App\Http\Resources\Courier\CourierResource;
use App\Services\Couriers\CourierService;

class StoreController extends Controller
{
    public function __construct(
        public CourierService $courierService
    )
    {
        
    }

    public function __invoke(StoreRequest $request)
    {
        $courier = $this->courierService->create($request->validated());

        return response(['courier' => new CourierResource($courier),]);
    }
}
