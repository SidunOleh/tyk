<?php

namespace App\Http\Controllers\Mobile\Order;

use App\DTO\Orders\CheckoutDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\Order\CheckoutRequest;
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
        $order = $this->orderService->checkout(
            new CheckoutDTO(
                $request->full_name,
                $request->phone,
                $request->address,
                $request->delivery_time,
                $request->notes,
                $request->payment_method,
                $request->use_bonuses,
                $request->cart_items,
            )
        );
        
        return response(['id' => $order->id]);
    }
}
