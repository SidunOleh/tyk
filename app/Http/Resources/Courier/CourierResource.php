<?php

namespace App\Http\Resources\Courier;

use App\Http\Resources\Cash\CashResource;
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
        $cashes = [];
        foreach ($this->cashes()
            ->orderBy('created_at', 'DESC')
            ->get() as $cash) {
            $cashes[] = new CashResource($cash);
        }

        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'tg' => $this->tg,
            'vehicles' => $this->vehicles,
            'cashes' => $cashes,
            'history' => $this->history,
        ];
    }
}
