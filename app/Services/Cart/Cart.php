<?php

namespace App\Services\Cart;

use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Product;
use Exception;
use Illuminate\Database\Eloquent\Collection;

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

    public function formattedTotal(): string
    {
        return number_format($this->total(), 2);
    }

    public function upsells(): Collection
    {
        $productIds = array_map(
            fn (CartItem $item) => $item->product->id, 
            $this->items
        );
        
        $categoryIds = CategoryProduct::whereIn('product_id', $productIds)
            ->get()
            ->pluck('category_id')
            ->toArray();
        $categories = Category::whereIn('id', $categoryIds)->get();

        $upsells = Product::whereIn('id', $categories->pluck('upsells')->flatten())
            ->whereNotIn('id', $productIds)
            ->get(); 

        return $upsells;
    }

    public static function make(string $driver): self
    {
        switch ($driver) {
            case 'session':
                return new CartSession;
            case 'db':
                return new CartDB;
            default:
                throw new Exception('Not found driver.');
        }
    }
}