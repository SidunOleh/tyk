<?php

namespace App\Http\Controllers\Admin\CourierServices;

use App\Http\Controllers\Controller;
use App\Models\CourierService;
use App\Services\CourierServices\CourierServiceService;

class DeleteController extends Controller
{
    public function __construct(
        public CourierServiceService $courierServiceService
    )
    {
        
    }

    public function __invoke(CourierService $courierService)
    {
        $this->courierServiceService->delete($courierService);

        return response(['message' => 'OK']);
    }
}
