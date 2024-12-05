<?php

namespace App\Http\Resources\Courier;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'tg' => $this->tg,
            'vehicles' => $this->vehicles,
            'cashes' => $this->cashes()
                ->select('id', 'received', 'returned', 'courier_id', 'created_at')
                ->orderBy('created_at', 'DESC')
                ->get(),
        ];
    }
}
