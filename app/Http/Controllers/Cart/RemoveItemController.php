<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\RemoveItemRequest;
use App\Services\Cart\Cart;

class RemoveItemController extends Controller
{
    public function __construct(
        public Cart $cart
    )
    {
        
    }

    public function __invoke(RemoveItemRequest $request)
    {
        $this->cart->removeItem($request->item_id);
    
        return response([
            '.cart-section' => view('templates.cart', [
                'cart' => $this->cart,
            ])->render(),
            '.cartSubtotal' => view('templates.subtotal', [
                'cart' => $this->cart,
            ])->render(),
        ]);
    }
}
