<?php

namespace App\Http\Resources\Client;

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
        $data = parent::toArray($request);

        foreach ($this->ordersByDate as $i => $order) {
            $data['orders_by_date'][$i]['time'] = $order->time->format('Y-m-d H:i:s');
        }

        return $data;
    }
}
