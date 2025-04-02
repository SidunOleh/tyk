<?php

namespace App\Http\Controllers\Orders;

use App\DTO\Orders\CheckoutDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\CheckoutRequest;
use App\Services\Cart\Cart;
use App\Services\Cart\CartItem;
use App\Services\Orders\FoodShippingService;

class CheckoutController extends Controller
{
    public function __construct(
        public FoodShippingService $orderService,
        public Cart $cart
    )
    {
        
    }

    public function __invoke(CheckoutRequest $request)
    {
        $cartItems = array_map(fn (CartItem $cartItem) => [
            'product_id' => $cartItem->product->id,
            'quantity' => $cartItem->quantity,
        ], $this->cart->items);

        $order = $this->orderService->checkout(
            new CheckoutDTO(
                $request->full_name,
                $request->phone,
                $request->address,
                $request->delivery_time,
                $request->notes,
                $request->payment_method,
                $request->use_bonuses == 'on',
                $cartItems,
            )
        );

        $this->cart->empty();
        
        return response(['id' => $order->id]);
    }
}
