<?php

namespace App\Http\Controllers\Admin\Couriers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Couriers\BulkDeleteRequest;
use App\Services\Couriers\CourierService;

class BulkDeleteController extends Controller
{
    public function __construct(
        public CourierService $courierService
    )
    {
        
    }

    public function __invoke(BulkDeleteRequest $request)
    {
        $this->courierService->bulkDelete($request->ids);

        return response(['message' => 'OK',]);
    }
}
