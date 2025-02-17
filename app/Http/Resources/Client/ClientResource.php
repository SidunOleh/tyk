<?php

namespace App\Http\Resources\Client;

use App\Http\Resources\Courier\CourierResource;
use App\Http\Resources\OrderItem\OrderItemResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $orders = [];
        foreach ($this->ordersByDate as $order) {
            $orders[] = $this->orderToArray($order);
        }

        $client = $this->clientData();
        $client['orders'] = $orders;

        foreach ($client['orders'] as &$order) {
            $order['client'] = $this->clientData();
            $order['client']['orders'] = $orders;
        }

        return $client;
    }

    protected function clientData(): array
    {
        return [
            'id' => $this->id,
            'phone' => $this->phone,
            'full_name' => $this->full_name,
            'addresses' => $this->addresses,
            'description' => $this->description,
            'bonuses' => $this->bonuses,
            'history' => $this->history,
        ];
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
