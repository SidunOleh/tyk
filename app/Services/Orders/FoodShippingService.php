<?php

namespace App\Services\Orders;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

class FoodShippingService extends OrderService
{
    public function create(FormRequest $request): Model
    {
        $data = $request->validated();

        $order = Order::create([
            'type' => $data['service'],
            'shipping_price' => $data['shipping_price'] ?? 0,
            'additional_costs' => $data['additional_costs'] ?? 0,
            'time' => $data['time'] ?? now()->format('Y-m-d H:i:s'),
            'duration' => $data['duration'],
            'notes' => $data['notes'] ?? '',
            'status' => 'Створено',
            'client_id' => $data['client_id'],
            'paid' => $data['paid'],
            'payment_method' => $data['payment_method'],
            'details' => $data['details'],
        ]);

        $order->orderItems()->createMany($request['order_items']);

        $order->updateAmount();

        return $order;
    }

    public function update(Model $order, FormRequest $request): void
    {
        $data = $request->validated();

        $order->update([
            'type' => $data['service'],
            'shipping_price' => $data['shipping_price'] ?? 0,
            'additional_costs' => $data['additional_costs'] ?? 0,
            'time' => $data['time'] ?? now()->format('Y-m-d H:i:s'),
            'duration' => $data['duration'],
            'notes' => $data['notes'] ?? '',
            'client_id' => $data['client_id'],
            'paid' => $data['paid'],
            'payment_method' => $data['payment_method'],
            'details' => $data['details'],
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
}