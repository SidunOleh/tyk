<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\CourierRequest;
use App\Services\Orders\OrderService;

class CourierController extends Controller
{
    public function __construct(
        public OrderService $orderService
    )
    {
        
    }

    public function __invoke(CourierRequest $request)
    {
        
    }
}
