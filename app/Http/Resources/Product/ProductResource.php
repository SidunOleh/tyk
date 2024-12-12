<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'slug' => $this->slug,
            'price' => $this->price,
            'image' => $this->image,
            'description' => $this->description,
            'ingredients' => $this->ingredients,
            'weight' => $this->weight,
            'categories' => $this->categories()
                ->select('categories.id', 'name')
                ->get(),
        ];
    }
}
