<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\CheckoutRequest;
use App\Services\Orders\FoodShippingService;

class CheckoutController extends Controller
{
    public function __construct(
        public FoodShippingService $orderService
    )
    {
        
    }

    public function __invoke(CheckoutRequest $request)
    {
        $order = $this->orderService->checkout($request);

        return response(['id' => $order->id,]);
    }
}
