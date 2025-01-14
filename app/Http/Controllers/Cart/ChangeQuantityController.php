<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\ChangeQuantityRequest;
use App\Models\Product;
use App\Services\Cart\Cart;

class ChangeQuantityController extends Controller
{
    public function __construct(
        public Cart $cart
    )
    {
        
    }

    public function __invoke(ChangeQuantityRequest $request)
    {
        if ($cartItem = $this->cart->getItemByProductId($request->product_id)) {
            $this->cart->changeQuantity($cartItem->id, $request->quantity);
        }

        if (! $cartItem and $request->quantity > 0) {
            $this->cart->addItem(Product::find($request->product_id), $request->quantity);
        }

        return response([
            '.cart-section' => view('templates.cart', [
                'cart' => $this->cart,
            ])->render(),
            '.upsells' => view('templates.upsells', [
                'cart' => $this->cart,
            ])->render(),
            '.cartSubtotal' => view('templates.subtotal', [
                'cart' => $this->cart,
            ])->render(),
        ]);
    }
}
