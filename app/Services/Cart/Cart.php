<?php

namespace App\Services\Cart;

use App\Models\Product;

abstract class Cart
{
    public array $items;

    public function __construct()
    {
        $this->retrieveItems();
    }

    abstract public function retrieveItems(): void;

    abstract public function addItem(Product $product, int $quantity): CartItem;

    abstract public function removeItem(int $itemId): bool;

    abstract public function changeQuantity(int $itemId, int $quantity): bool;

    public function total(): float
    {
        return array_reduce($this->items, fn (int $acc, CartItem $item) => $acc += $item->amount(), 0);
    }
}