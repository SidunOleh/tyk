<?php

namespace App\Http\Resources\Tariff;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AllTariffsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [];
        foreach ($this->collection as $i => $tariff) {
            $data[$i] = new TariffResource($tariff);
        }

        return $data;
    }
}
