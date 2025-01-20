<?php

namespace App\Services\Orders;

use App\Http\Requests\Orders\CheckoutRequest;
use App\Models\Client;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\Cart\Cart;
use App\Services\Cart\CartItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class FoodShippingService extends OrderService
{
    public function create(FormRequest $request): Model
    {
        $data = $request->validated();

        $time = $data['time'] ?? now()->format('Y-m-d H:i:s');

        $addresses = [];
        foreach ($data['details']['food_to'] as $address) {
            $addresses[] = array_merge(['address' => $address], $this->getLatLng($address));
        }
        $details['food_to'] = $addresses;
        $details['delivery_time'] = 
            $data['details']['delivery_time'] ?? null;

        Client::find($data['client_id'])->addAddresses($details['food_to']);

        $order = Order::create([
            'type' => $data['service'],
            'shipping_price' => $data['shipping_price'] ?? 0,
            'additional_costs' => $data['additional_costs'] ?? 0,
            'time' => $time,
            'duration' => $data['duration'],
            'notes' => $data['notes'] ?? '',
            'status' => 'Створено',
            'client_id' => $data['client_id'],
            'paid' => $data['paid'],
            'payment_method' => $data['payment_method'],
            'details' => $details,
        ]);

        $order->orderItems()->createMany($request['order_items']);

        $order->updateAmount();

        return $order;
    }

    public function update(Model $order, FormRequest $request): void
    {
        $data = $request->validated();

        $addresses = [];
        foreach ($data['details']['food_to'] as $address) {
            $addresses[] = array_merge(['address' => $address], $this->getLatLng($address));
        }
        $details['food_to'] = $addresses;
        $details['delivery_time'] = 
            $data['details']['delivery_time'] ?? null;

        Client::find($data['client_id'])->addAddresses($details['food_to']);

        $order->update([
            'type' => $data['service'],
            'shipping_price' => $data['shipping_price'] ?? 0,
            'additional_costs' => $data['additional_costs'] ?? 0,
            'time' => $data['time'],
            'duration' => $data['duration'],
            'notes' => $data['notes'] ?? '',
            'client_id' => $data['client_id'],
            'paid' => $data['paid'],
            'payment_method' => $data['payment_method'],
            'details' => $details,
        ]);

        $order->orderItems()
            ->whereNotIn('id', array_filter(array_map(fn (array $item) => $item['id'] ?? null, $data['order_items']), fn ($val) => isset($val)))
            ->get()
            ->map(fn (OrderItem $item) => $item->delete());

        $orderItems = array_map(function (array $data) use($order) {
            $data['order_id'] = $order->id;
            if (isset($data['id'])) {
                $orderItem = OrderItem::find($data['id']);
                unset($data['id']);
                $orderItem->update($data);
            } else {
                $orderItem = OrderItem::create($data);
            }

            return $orderItem;
        }, $data['order_items']);

        $order->updateAmount();
    }

    public function repeat(Order $order): void
    {
        $cart = app()->make(Cart::class);
        foreach ($order->orderItems as $orderItem) {
            if (! $orderItem->product) {
                continue;
            }

            $cartItem = $cart->getItemByProductId($orderItem->product->id);

            if ($cartItem) {
                $cart->changeQuantity($cartItem->id, $orderItem->quantity);
            } else {
                $cart->addItem($orderItem->product, $orderItem->quantity);
            }
        }
    }
    
    public function checkout(CheckoutRequest $request): Order
    {
        $validated = $request->validated();

        if (Auth::guard('web')->check()) {
            $client = Auth::guard('web')->user();
        } else {
            $client = Client::firstOrCreate([
                'phone' => $validated['phone']
            ]);
        }

        $client->update([
            'full_name' => $request['full_name']
        ]);

        $foodTo = $this->getLatLng($validated['address']);
        $foodTo['address'] = $validated['address'];

        $client->addAddresses([$foodTo]);

        $delivetyTime = $validated['delivery_time'];
        if ($delivetyTime) {
            $delivetyTime = now()
                ->hour((int) explode(':', $delivetyTime)[0])
                ->minute((int) explode(':', $delivetyTime)[1])
                ->format('Y-m-d H:i:s');
        }

        $order = Order::create([
            'type' => Order::FOOD_SHIPPING,
            'time' => now()->format('Y-m-d H:i:s'),
            'duration' => 30,
            'notes' => $validated['notes'] ?? '',
            'status' => 'Створено',
            'client_id' => $client->id,
            'payment_method' => $validated['payment_method'],
            'details' => [
                'food_to' => [
                    $foodTo
                ],
                'delivery_time' => $delivetyTime,
            ],
        ]);

        $cart = app()->make(Cart::class);

        $order->orderItems()->createMany(array_map(fn (CartItem $cartItem) => [
            'name' => $cartItem->product->name,
            'quantity' => $cartItem->quantity,
            'amount' => $cartItem->product->price,
            'order_id' => $order->id,
            'product_id' => $cartItem->product->id,
        ], $cart->items));
        $order->updateAmount();

        $cart->empty();

        return $order;
    }
}