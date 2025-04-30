<?php

namespace App\Services\Cart;

use App\Exceptions\NotFoundCartDriver;
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

    abstract public function empty(): void;

    public function getItem(int $id): ?CartItem
    {
        foreach ($this->items as $item) {
            if ($item->id == $id) {
                return $item;
            }
        }

        return null;
    }

    public function getItemByProductId(int $productId): ?CartItem
    {
        foreach ($this->items  as $item) {
            if ($item->product->id == $productId) {
                return $item;
            }
        }

        return null;
    }

    public function quantity(int $productId): int
    {
        return ($item = $this->getItemByProductId($productId)) ? $item->quantity : 0;
    }

    public function total(): float
    {
        return array_reduce($this->items, fn (int $acc, CartItem $item) => $acc += $item->amount(), 0);
    }

    public function getProductsIds(): array
    {
        return array_map(fn (CartItem $cartItem) => $cartItem->product->id, $this->items);
    }

    public static function make(string $driver): self
    {
        switch ($driver) {
            case 'session':
                return new CartSession;
            case 'db':
                return new CartDB;
            default:
                throw new NotFoundCartDriver();
        }
    }
}