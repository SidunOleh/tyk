<?php

namespace App\Http\Resources\WorkShift;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkShiftResource extends JsonResource
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
            'status' => $this->status,
            'start' => $this->start,
            'end' => $this->end,
            'food_shipping_count' => $this->food_shipping_count,
            'shipping_count' => $this->shipping_count,
            'taxi_count' => $this->taxi_count,
            'food_shipping_total' => $this->food_shipping_total,
            'shipping_total' => $this->shipping_total,
            'taxi_total' => $this->taxi_total,
            'drivers' => $this->drivers,
            'dispatchers' => $this->dispatchers,
            'zaklady_reports' => $this->zakladyReports,
        ];

        return $data;
    }
}
