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

        $client = $this->client()->withTrashed()->first();

        $data['client'] = [
            'id' => $client->id,
            'phone' => $client->phone,
            'first_name' => $client->first_name,
            'last_name' => $client->last_name,
            'addresses' => $client->addresses,
            'bonuses' => $client->bonuses,
            'history' => $this->history,
        ];

        foreach ($client->orders as $order) {
            $data['client']['orders'][] = $this->orderToArray($order);
        }

        return $data;
    }

    protected function orderToArray(Order $order): array
    {
        $data = [
            'id' => $order->id,
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
        ];

        if ($data['type'] == 'Доставка їжі') {
            foreach ($order->orderItems as $orderItem) {
                $data['order_items'][] = new OrderItemResource($orderItem);
            }
        }

        return $data;
    }
}
