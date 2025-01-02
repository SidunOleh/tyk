<?php

namespace App\Services\Cart;

use App\Models\CartItem;
use App\Models\Product;
use App\Services\Cart\CartItem as CartCartItem;
use Illuminate\Support\Facades\Auth;

class CartDB extends Cart
{
    public function retrieveItems(): void
    {
        $cartItemModels = CartItem::where('client_id', Auth::guard('web')->id())->get();
        
        $this->items = $cartItemModels->map(fn (CartItem $cartItemModel) => new CartCartItem(
            $cartItemModel->id,
            $cartItemModel->product,
            $cartItemModel->quantity
        ));
    }
    
    public function addItem(Product $product, int $quantity): CartCartItem
    {
        $cartItemModel = CartItem::create([
            'quantity' => $quantity,
            'product_id' => $product->id,
            'client_id' => Auth::guard('web')->id(),
        ]);

        $cartItem = new CartCartItem(
            $cartItemModel->id,
            $product,
            $quantity
        );

        $this->retrieveItems();

        return $cartItem;
    }

    public function removeItem(int $itemId): bool
    {
        if (! $cartItemModel = CartItem::find($itemId)) {
            return false;
        }

        $cartItemModel->delete();

        $this->retrieveItems();

        return true;
    }

    public function changeQuantity(int $itemId, int $quantity): bool
    {
        if (! $cartItemModel = CartItem::find($itemId)) {
            return false;
        }

        $cartItemModel->update(['quantity' => $quantity,]);

        $this->retrieveItems();

        return true;
    }
}