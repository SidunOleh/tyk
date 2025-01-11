<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Services\Cart\Cart;

class CartController extends Controller
{
    public function __construct(
        public Cart $cart
    )
    {
        
    }

    public function __invoke()
    {
        return view('pages.cart', [
            'cart' => $this->cart,
        ]);
    }
}
