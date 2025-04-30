<?php

namespace App\Http\Controllers\Admin\CourierServices;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CourierServices\UpdateRequest;
use App\Models\CourierService;
use App\Services\CourierServices\CourierServiceService;

class UpdateController extends Controller
{
    public function __construct(
        public CourierServiceService $courierServiceService
    )
    {
        
    }

    public function __invoke(CourierService $courierService, UpdateRequest $request)
    {
        $this->courierServiceService->update($courierService, $request);

        return response(['message' => 'OK']);
    }
}
