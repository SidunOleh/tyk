<?php

namespace App\Http\Controllers\Admin\CourierServices;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CourierServices\StoreRequest;
use App\Http\Resources\CourierService\CourierServiceResource;
use App\Services\CourierServices\CourierServiceService;

class StoreController extends Controller
{
    public function __construct(
        public CourierServiceService $courierServiceService
    )
    {
        
    }

    public function __invoke(StoreRequest $request)
    {
        $courierService = $this->courierServiceService->create($request);

        return response(['courier_service' => new CourierServiceResource($courierService)]);
    }
}
