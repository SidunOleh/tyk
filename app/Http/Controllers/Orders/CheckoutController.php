<?php

namespace App\Http\Controllers\Orders;

use App\DTO\Orders\CheckoutDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\CheckoutRequest;
use App\Services\Cart\Cart;
use App\Services\Cart\CartItem;
use App\Services\Categories\CategoryService;
use App\Services\Orders\FoodShippingService;

class CheckoutController extends Controller
{
    public function __construct(
        public FoodShippingService $orderService,
        public Cart $cart,
        public CategoryService $categoryService
    )
    {
        
    }

    public function __invoke(CheckoutRequest $request)
    {
        $cartItems = array_map(fn (CartItem $cartItem) => [
            'product_id' => $cartItem->product->id,
            'quantity' => $cartItem->quantity,
        ], $this->cart->items);

        $productsIds = array_map(fn ($item) => $item['product_id'], $cartItems);

        if ($closed = $this->categoryService->closedZaklady($productsIds)) {
            return response(['message' => implode(', ', array_map(fn ($zaklad) => $zaklad->name, $closed)) . (count($closed) > 1 ? ' закриті' : ' закритий') . '. Повторіть замовлення в робочі години.'], 400);
        }

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
                $request->callback == 'on'
            )
        );

        $this->cart->empty();
        
        return response(['id' => $order->id]);
    }
}
