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

        $client = Client::find($data['client_id']);

        $time = $data['time'] ?? now()->format('Y-m-d H:i:s');

        $details = [];

        $details['food_to'] = $data['details']['food_to'];
        $client->addAddresses($details['food_to']);
        
        $details['cooking_time'] = $data['details']['cooking_time'] ?? null;

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

        $order->refresh();

        $this->addPackaging($order);
        
        $order->updateAmount();

        if ($data['use_bonuses']) {
            $order->useBonuses();
        }

        DB::commit();

        return $order;
    }

    private function addPackaging(Order $order): void
    {
        foreach ($order->orderItems as $orderItem) {
            $packagingOrderItems = $orderItem->packaging;
            $packagingProducts = $orderItem->product->packagingProducts;
            foreach ($packagingProducts as $packagingProduct) {
                $data = [
                    'name' => $packagingProduct->name,
                    'amount' => $packagingProduct->price,
                    'quantity' => $orderItem->quantity,
                    'order_id' => $order->id,
                    'product_id' => $packagingProduct->id,
                    'packaging_for' => $orderItem->id,
                ];
                $packagingOrderItem = $packagingOrderItems->first(
                    fn ($orderItem) => $orderItem->product->id == $packagingProduct->id
                );
                if ($packagingOrderItem) {
                    $packagingOrderItem->update($data);
                } else {
                    $order->allOrderItems()->create($data);
                }
            }
        }
    }

    public function update(Model $order, FormRequest $request): void
    {
        DB::beginTransaction();

        $data = $request->validated();

        $client = Client::find($data['client_id']);

        $details = [];

        $details['food_to'] = $data['details']['food_to'];
        $client->addAddresses($details['food_to']);

        $details['cooking_time'] = $data['details']['cooking_time'] ?? null;

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

        $oldOrderItemsIds = [];
        foreach ($data['order_items'] as $orderItemData) {
            if (isset($orderItemData['id'])) {
                $oldOrderItemsIds[] = $orderItemData['id'];
            }
        }
        $deletedOrderItems = $order->orderItems()
            ->whereNotIn('id', $oldOrderItemsIds)
            ->get();
        foreach ($deletedOrderItems as $deletedOrderItem) {
            $deletedOrderItem->delete();
        }

        foreach ($data['order_items'] as $orderItemData) {
            $orderItemData['order_id'] = $order->id;
            if (isset($orderItemData['id'])) {
                $orderItem = OrderItem::find($orderItemData['id']);
                $orderItem->update($orderItemData);
            } else {
                $orderItem = OrderItem::create($orderItemData);
            }
        }
        
        $order->refresh();

        $this->addPackaging($order);

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

        $delivetyTime = $dto->deliveryTime 
            ? now()->hour((int) explode(':', $dto->deliveryTime)[0])->minute((int) explode(':', $dto->deliveryTime)[1]) 
            : now();

        $details = [];

        $details['food_to'] = [];
        $details['food_to'][0] = $this->getLatLng($dto->address);
        $details['food_to'][0]['address'] = $dto->address;
        $client->addAddresses($details['food_to']);

        $details['cooking_time'] = null;

        $order = Order::create([
            'type' => Order::FOOD_SHIPPING,
            'time' => $delivetyTime->format('Y-m-d H:i:s'),
            'duration' => Order::DEFAULT_DURATION,
            'notes' => $validated['notes'] ?? '',
            'status' => Order::CREATED,
            'client_id' => $client->id,
            'payment_method' => $dto->paymentMethod,
            'details' => $details,
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

        $order->refresh();
        
        $this->addPackaging($order);
        
        $order->updateAmount();

        if ($dto->useBonuses) {
            $order->useBonuses();
        }

        DB::commit();

        return $order;
    }
}