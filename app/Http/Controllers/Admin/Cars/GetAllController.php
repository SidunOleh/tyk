<?php

namespace App\Http\Controllers\Admin\Cars;

use App\Http\Controllers\Controller;
use App\Http\Resources\Car\CarsSearchCollection;
use App\Services\Cars\CarService;

class GetAllController extends Controller
{
    public function __construct(
        public CarService $carService
    )
    {
        
    }
    public function __invoke()
    {
        $cars = $this->carService->all();

        return response(new CarsSearchCollection($cars));
    }
}
