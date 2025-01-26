<?php

namespace App\Http\Controllers\Admin\Cars;

use App\Http\Controllers\Controller;
use App\Http\Resources\Car\CarsCollection;
use App\Services\Cars\CarService;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __construct(
        public CarService $carService
    )
    {
        
    }

    public function __invoke(Request $request)
    {
        $cars = $this->carService->index($request);

        return response(new CarsCollection($cars));
    }
}
