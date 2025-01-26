<?php

namespace App\Http\Controllers\Admin\Cars;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Services\Cars\CarService;

class DeleteController extends Controller
{
    public function __construct(
        public CarService $carService
    )
    {
        
    }

    public function __invoke(Car $car)
    {
        $this->carService->delete($car);

        return response(['message' => 'OK',]);
    }
}
