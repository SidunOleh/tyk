<?php

namespace App\Http\Resources\Category;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'image' => $this->image,
            'description' => $this->description,
            'tags' => $this->tags,
            'parent_id' => $this->parent_id,
            'visible' => $this->visible,
            'tags' => $this->tags,
            'upsells' => Product::whereIn('id', $this->upsells ?? [])
                ->with('categories')
                ->get(),
            'count' => $this->products()->count(),
            'history' => $this->history,
        ];
    }
}
