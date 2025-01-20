<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Services\Cart\Cart;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function __construct(
        public Cart $cart
    )
    {
        
    }

    public function __invoke()
    {
        if (! $this->cart->items) {
            return redirect()->route('pages.zaklady');
        }

        $client = Auth::guard('web')->user();

        return view('pages.checkout', [
            'client' => $client,
            'cart' => $this->cart,
        ]);
    }
}
