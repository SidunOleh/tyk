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
        return $this->product->price * $this->quantity;
    }

    public function formattedAmount(): string
    {
        return number_format($this->amount(), 2);
    }
}