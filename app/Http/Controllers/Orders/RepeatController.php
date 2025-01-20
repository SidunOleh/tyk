<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Cart\Cart;
use App\Services\Orders\OrderService;

class RepeatController extends Controller
{
    public function __construct(
        public Cart $cart
    )
    {
        
    }

    public function __invoke(Order $order)
    {
        OrderService::make($order->type)->repeat($order);

        $this->cart->retrieveItems();

        return response([
            '.cart_btn' => view('templates.cart-icon', [
                'cartTotal' => $this->cart->formattedTotal(),
            ])->render(),
        ]);
    }
}
