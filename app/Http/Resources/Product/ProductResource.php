<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Category\CategoryResource;
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
        $categories = [];
        foreach ($this->categories as $category) {
            $categories[] = new CategoryResource($category);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price,
            'image' => $this->image,
            'description' => $this->description,
            'ingredients' => $this->ingredients,
            'weight' => $this->weight,
            'categories' => $categories,
            'history' => $this->history,
        ];
    }
}
