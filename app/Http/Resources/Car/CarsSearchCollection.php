<?php

namespace App\Http\Resources\Car;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CarsSearchCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [];
        foreach ($this->collection as $i => $car) {
            $data[$i] = new CarResource($car);
        }

        return $data;
    }
}
