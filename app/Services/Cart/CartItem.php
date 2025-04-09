<?php

namespace App\Services\Cart;

use App\Models\Product;

class CartItem
{
    public function __construct(
        public int $id,
        public Product $product,
        public int $quantity
    )
    {
        
    }

    public function amount(): float
    {
        return ($this->product->price + $this->product->packagingPrice()) * $this->quantity;
    }

    public function packagingPrice(): float
    {
        return $this->product->packagingPrice();
    }
}