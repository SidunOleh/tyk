<?php

namespace App\Http\Resources\CourierService;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CourierServiceSearchCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [];
        foreach ($this->collection as $i => $courierService) {
            $data[$i] = new CourierServiceResource($courierService);
        }

        return $data;
    }
}
