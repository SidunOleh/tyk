<?php

namespace App\Http\Controllers\Admin\Cars;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Cars\UpdateRequest;
use App\Http\Resources\Car\CarResource;
use App\Models\Car;
use App\Services\Cars\CarService;

class UpdateController extends Controller
{
    public function __construct(
        public CarService $carService
    )
    {
        
    }

    public function __invoke(Car $car, UpdateRequest $request)
    {
        $this->carService->update($car, $request);

        return response(['car' => new CarResource($car),]);
    }
}
