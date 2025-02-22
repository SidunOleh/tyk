<?php

namespace App\Http\Resources\WorkShift;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class WorkShiftsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [];
        foreach ($this->collection as $i => $workShift) {
            $data[$i] = new WorkShiftResource($workShift);
        }

        $meta = [
            'current_page' => $this->currentPage(),
            'per_page' => $this->perPage(),
            'total' => $this->total(),
        ];

        return [
            'data' => $data,
            'meta' => $meta,
        ];
    }
}
