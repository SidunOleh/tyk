<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\OrderItem\OrderItemResource;
use App\Models\FoodShippingDetails;
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
        switch ($this->details_type) {
            case FoodShippingDetails::class:
                $type = 'Доставка їжі';
            break;
            case ShippingDetails::class:
                $type = 'Кур\'єр';
            break;
            case TaxiDetails::class:
                $type = 'Таксі';
            break;
            default:
                $type = '';
        }

        $data = [
            'id' => $this->id,
            'subtotal' => $this->subtotal,
            'shipping_price' => $this->shipping_price,
            'bonuses' => $this->bonuses,
            'total' => $this->total,
            'time' => $this->time,
            'notes' => $this->notes,
            'type' => $type,
            'details' => $this->details,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ];

        if ($this->details_type == FoodShippingDetails::class) {
            $data['order_items'] = [];
            foreach ($this->orderItems as $orderItem) {
                $data['order_items'][] = new OrderItemResource($orderItem);
            }
        }

        return $data;
    }
}
