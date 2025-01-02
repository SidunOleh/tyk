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

        $cartItems = session('cart', []);
        $cartItems[] = $cartItem;
        session(['cart' => $cartItems,]);

        $this->retrieveItems();

        return $cartItem;
    }

    public function removeItem(int $itemId): bool
    {
        $cartItems = session('cart', []);
        $newCartItems = array_filter($cartItems, fn (CartCartItem $cartItem) => $cartItem->id != $itemId);
        session(['cart' => $newCartItems,]);

        $this->retrieveItems();

        return count($newCartItems) != count($cartItems);
    }

    public function changeQuantity(int $itemId, int $quantity): bool
    {
        $cartItems = session('cart', []);
        foreach ($cartItems as $cartItem) {
            if ($cartItem->id == $itemId) {
                $cartItem->quantity = $quantity;
                session(['cart' => $cartItems,]);

                $this->retrieveItems();

                return true;
            }
        }
        
        return false;
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