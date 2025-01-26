<?php

namespace App\Http\Controllers\Admin\Cars;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Cars\StoreRequest;
use App\Http\Resources\Car\CarResource;
use App\Services\Cars\CarService;

class StoreController extends Controller
{
    public function __construct(
        public CarService $carService
    )
    {
        
    }

    public function __invoke(StoreRequest $request)
    {
        $car = $this->carService->create($request);

        return response(['car' => new CarResource($car),]);
    }
}
