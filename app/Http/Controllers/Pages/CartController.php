<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Services\Cart\Cart;
use App\Services\Products\ProductService;

class CartController extends Controller
{
    public function __construct(
        public Cart $cart,
        public ProductService $productService
    )
    {
        
    }

    public function __invoke()
    {
        $upsells = $this->productService->upsells($this->cart->getProductsIds());

        return view('pages.cart', [
            'cart' => $this->cart,
            'upsells' => $upsells,
        ]);
    }
}
