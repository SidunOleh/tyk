<?php

namespace App\Http\Controllers\Fragments;

use App\Http\Controllers\Controller;
use App\Services\Cart\Cart;
use Illuminate\Support\Facades\Auth;

class RefreshController extends Controller
{
    public function __construct(
        public Cart $cart
    )
    {
        
    }

    public function __invoke()
    {
        $client = Auth::guard('web')->user();

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
            '.cart_btn' => view('templates.cart-icon', [
                'cartTotal' => $this->cart->formattedTotal(),
            ])->render(),
            '.save-address' => view('templates.addresses', [
                'addresses' => $client?->addresses ?? [],
            ])->render(),
        ]);
    }
}
