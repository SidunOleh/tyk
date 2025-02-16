<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\OrderItem\OrderItemResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = $this->orderToArray($this->resource);

        $data['client'] = [
            'id' => $this->client->id,
            'phone' => $this->client->phone,
            'full_name' => $this->client->full_name,
            'addresses' => $this->client->addresses,
            'description' => $this->description,
            'bonuses' => $this->client->bonuses,
            'history' => $this->history,
        ];

        foreach ($this->client->orders()
            ->with('courier')
            ->with('orderItems')
            ->orderBy('created_at', 'DESC')
            ->get() as $order) {
            $data['client']['orders'][] = $this->orderToArray($order);
        }

        return $data;
    }

    protected function orderToArray(Order $order): array
    {
        $data = [
            'id' => $order->id,
            'number' => $order->number,
            'type' => $order->type,
            'subtotal' => $order->subtotal,
            'shipping_price' => $order->shipping_price,
            'additional_costs' => $order->additional_costs,
            'bonuses' => $order->bonuses,
            'total' => $order->total,
            'time' => $order->time->format('Y-m-d H:i:s'),
            'duration' => $order->duration,
            'notes' => $order->notes,
            'details' => $order->details,
            'status' => $order->status,
            'paid' => $order->paid,
            'payment_method' => $order->payment_method,
            'created_at' => $order->created_at,
            'history' => $order->history,
            'courier' => $order->courier,
        ];

        if ($data['type'] == Order::FOOD_SHIPPING) {
            foreach ($order->orderItems as $orderItem) {
                $data['order_items'][] = new OrderItemResource($orderItem);
            }
        }

        return $data;
    }
}
