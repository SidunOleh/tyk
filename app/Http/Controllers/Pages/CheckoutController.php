<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Services\Cart\Cart;

class CheckoutController extends Controller
{
    public function __construct(
        public Cart $cart
    )
    {
        
    }

    public function __invoke()
    {
        return view('pages.checkout', [
            'cart' => $this->cart,
        ]);
    }
}
