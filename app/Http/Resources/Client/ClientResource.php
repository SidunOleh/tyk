<?php

namespace App\Http\Resources\Client;

use App\Http\Resources\Order\OrderResource;
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
        foreach ($this->orders()
            ->orderBy('created_at', 'DESC')
            ->get() as $order) {
            $orders[] = new OrderResource($order);
        }

        return [
            'id' => $this->id,
            'phone' => $this->phone,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'addresses' => $this->addresses,
            'bonuses' => $this->bonuses,
            'orders' => $orders,
        ];
    }
}
