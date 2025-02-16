<?php

namespace App\Http\Resources\Tariff;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TariffResource extends JsonResource
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
            'name' => $this->name,
            'fixed' => $this->fixed,
            'fixed_price' => $this->fixed_price,
            'per_km' => $this->per_km,
            'color' => $this->color,
            'default' => $this->default,
        ];
    }
}
