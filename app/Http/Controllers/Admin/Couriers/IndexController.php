<?php

namespace App\Http\Controllers\Admin\Couriers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Courier\CouriersCollection;
use App\Services\Couriers\CourierService;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __construct(
        public CourierService $courierService
    )
    {
        
    }

    public function __invoke(Request $request)
    {
        $couriers = $this->courierService->index($request);

        return response(new CouriersCollection($couriers));
    }
}
