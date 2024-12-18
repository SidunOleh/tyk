<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\OrderItem\OrderItemResource;
use App\Models\FoodShippingDetails;
use App\Models\OrderItem;
use App\Models\ShippingDetails;
use App\Models\TaxiDetails;
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
        $data = [
            'id' => $this->id,
            'subtotal' => $this->subtotal,
            'shipping_price' => $this->shipping_price,
            'bonuses' => $this->bonuses,
            'total' => $this->total,
            'time' => $this->time,
            'notes' => $this->notes,
            'details' => $this->details,
            'status' => $this->status,
            'paid' => $this->paid,
            'payment_method' => $this->payment_method,
            'created_at' => $this->created_at,
        ];

        switch ($this->details_type) {
            case FoodShippingDetails::class:
                $data['type'] = 'Доставка їжі';
            break;
            case ShippingDetails::class:
                $data['type'] = 'Кур\'єр';
            break;
            case TaxiDetails::class:
                $data['type'] = 'Таксі';
            break;
        }

        if ($data['type'] == 'Доставка їжі') {
            foreach ($this->orderItems as $orderItem) {
                $data['order_items'][] = new OrderItemResource($orderItem);
            }
        }

        return $data;
    }
}
