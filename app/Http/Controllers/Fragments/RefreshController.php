<?php

namespace App\Http\Controllers\Fragments;

use App\Http\Controllers\Controller;
use App\Services\Cart\Cart;
use App\Services\Products\ProductService;
use Illuminate\Support\Facades\Auth;

class RefreshController extends Controller
{
    public function __construct(
        public Cart $cart,
        public ProductService $productService
    )
    {
        
    }

    public function __invoke()
    {
        $client = Auth::guard('web')->user();

        $upsells = $this->productService->upsells($this->cart->getProductsIds());

        return response([
            '.cart-section' => view('templates.cart', [
                'cart' => $this->cart,
            ])->render(),
            '.upsells' => view('templates.upsells', [
                'upsells' => $upsells,
            ])->render(),
            '.cartSubtotal' => view('templates.subtotal', [
                'cart' => $this->cart,
            ])->render(),
            '.cart_btn' => view('templates.cart-icon', [
                'cartTotal' => format_price($this->cart->total()),
            ])->render(),
            '.save-address' => view('templates.addresses', [
                'addresses' => $client?->addresses ?? [],
            ])->render(),
        ]);
    }
}
