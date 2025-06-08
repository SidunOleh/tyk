<?php

namespace App\Http\Controllers\Admin\Couriers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Couriers\UpdateRequest;
use App\Http\Resources\Courier\CourierResource;
use App\Models\Courier;
use App\Services\Couriers\CourierService;

class UpdateController extends Controller
{
    public function __construct(
        public CourierService $courierService
    )
    {
        
    }

    public function __invoke(Courier $courier, UpdateRequest $request)
    {
        $this->courierService->update($courier, $request->validated());
        
        return response(['courier' => new CourierResource($courier),]);
    }
}
