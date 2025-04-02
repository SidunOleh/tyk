<?php

namespace App\Services\Orders;

use App\DTO\Orders\CheckoutDTO;
use App\Models\Client;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\Cart\Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FoodShippingService extends OrderService
{
    public function create(FormRequest $request): Model
    {
        DB::beginTransaction();

        $data = $request->validated();

        $time = $data['time'] ?? now()->format('Y-m-d H:i:s');

        $details['food_to'] = $data['details']['food_to'];
        $details['cooking_time'] = $data['details']['cooking_time'] ?? null;

        $client = Client::find($data['client_id']);
        $client->addAddresses($details['food_to']);

        $order = Order::create([
            'type' => $data['service'],
            'shipping_price' => $data['shipping_price'] ?? 0,
            'additional_costs' => $data['additional_costs'] ?? 0,
            'time' => $time,
            'duration' => $data['duration'],
            'notes' => $data['notes'] ?? '',
            'status' => Order::CREATED,
            'client_id' => $data['client_id'],
            'paid' => $data['paid'],
            'payment_method' => $data['payment_method'],
            'details' => $details,
            'user_id' => Auth::guard('admin')->id(),
        ]);
        $order->orderItems()->createMany($request['order_items']);
        $order->updateAmount();

        if ($data['use_bonuses']) {
            $order->useBonuses();
        }

        DB::commit();

        return $order;
    }

    public function update(Model $order, FormRequest $request): void
    {
        DB::beginTransaction();

        $data = $request->validated();

        $details['food_to'] = $data['details']['food_to'];
        $details['cooking_time'] = $data['details']['cooking_time'] ?? null;

        $client = Client::find($data['client_id']);
        $client->addAddresses($details['food_to']);

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

        DB::commit();
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
    
    public function checkout(CheckoutDTO $dto): Order
    {
        DB::beginTransaction();

        $client = Client::firstOrCreate(['phone' => $dto->phone]);
        $client->update(['full_name' => $dto->fullName]);

        $address = $this->getLatLng($dto->address);
        $address['address'] = $dto->address;
        $client->addAddresses([$address]);

        $delivetyTime = $dto->deliveryTime ?? null;
        if ($delivetyTime) {
            $delivetyTime = now()
                ->hour((int) explode(':', $delivetyTime)[0])
                ->minute((int) explode(':', $delivetyTime)[1])
                ->format('Y-m-d H:i:s');
        } else {
            $delivetyTime = now()->format('Y-m-d H:i:s');
        }

        $order = Order::create([
            'type' => Order::FOOD_SHIPPING,
            'time' => $delivetyTime,
            'duration' => Order::DEFAULT_DURATION,
            'notes' => $validated['notes'] ?? '',
            'status' => Order::CREATED,
            'client_id' => $client->id,
            'payment_method' => $dto->paymentMethod,
            'details' => [
                'food_to' => [
                    $address
                ],
                'cooking_time' => null,
            ],
        ]);

        $orderItems = [];
        foreach ($dto->cartItems as $i => $cartItem) {
            $product = Product::find($cartItem['product_id']);

            $orderItems[$i]['name'] = $product->name;
            $orderItems[$i]['quantity'] = $cartItem['quantity'];
            $orderItems[$i]['amount'] = $product->price;
            $orderItems[$i]['order_id'] = $order->id;
            $orderItems[$i]['product_id'] = $product->id;
        }
        $order->orderItems()->createMany($orderItems);
        
        $order->updateAmount();

        if ($dto->useBonuses) {
            $order->useBonuses();
        }

        DB::commit();

        return $order;
    }
}