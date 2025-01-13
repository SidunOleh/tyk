<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\FoodShippingRequest;
use App\Services\Orders\OrderService;

class FoodShippingController extends Controller
{
    public function __construct(
        public OrderService $orderService
    )
    {
        
    }

    public function __invoke(FoodShippingRequest $request)
    {
        
    }
}
