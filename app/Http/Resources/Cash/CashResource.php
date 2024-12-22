<?php

namespace App\Http\Resources\Cash;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CashResource extends JsonResource
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
            'received' => $this->received, 
            'returned' => $this->returned, 
            'courier_id' => $this->courier_id, 
            'created_at' => $this->created_at,
        ];
    }
}
