<?php

namespace App\Http\Resources\CategoryTag;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryTagsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [];
        foreach ($this->collection as $tag) {
            $data[] = new CategoryTagResource($tag);
        }

        return $data;
    }
}
