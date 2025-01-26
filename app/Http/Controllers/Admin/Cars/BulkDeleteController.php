<?php

namespace App\Http\Controllers\Admin\Cars;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Cars\BulkDeleteRequest;
use App\Services\Cars\CarService;

class BulkDeleteController extends Controller
{
    public function __construct(
        public CarService $carService
    )
    {
        
    }

    public function __invoke(BulkDeleteRequest $request)
    {
        $this->carService->bulkDelete($request->ids);

        return response(['message' => 'OK',]);
    }
}
