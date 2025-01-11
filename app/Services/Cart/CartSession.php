<?php

namespace App\Services\Cart;

use App\Models\CartItem;
use App\Models\Product;
use App\Services\Cart\CartItem as CartCartItem;
use Illuminate\Support\Facades\Auth;

class CartSession extends Cart
{
    public function retrieveItems(): void
    {
        $this->items = session('cart', []);
    }

    public function addItem(Product $product, int $quantity): CartCartItem
    {
        $cartItem = new CartCartItem(
            hexdec(uniqid()),
            $product,
            $quantity
        );

        $this->items[] = $cartItem;

        session(['cart' => $this->items,]);

        return $cartItem;
    }

    public function removeItem(int $itemId): bool
    {
        $deleted = false;
        $this->items = array_filter($this->items, function (CartCartItem $cartItem) use ($itemId, $deleted) {
            if ($cartItem->id != $itemId) {
                return true;
            } else {
                return ! $deleted = true;
            }
        });

        session(['cart' => $this->items,]);

        return $deleted ;
    }

    public function changeQuantity(int $itemId, int $quantity): bool
    {
        if (! $item = $this->getItem($itemId)) {
            return false;
        }

        if ($quantity > 0) {
            $item->quantity = $quantity;

            session(['cart' => $this->items,]);
        } else {
            $this->removeItem($itemId);
        }

        return true;
    }

    public function saveToDB(): array
    {
        return array_map(fn (CartCartItem $item) => CartItem::create([
            'quantity' => $item->id,
            'product_id' => $item->product->id,
            'client_id' => Auth::guard('web')->id(),
        ]), $this->items);
    }
}