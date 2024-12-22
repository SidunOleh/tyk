<?php

namespace App\Services\Categories;

use App\Models\Category;
use App\Services\Service;
use Illuminate\Database\Eloquent\Collection;

class CategoryService extends Service
{
    protected string $model = Category::class;

    public function all(): Collection
    {
        $categories = Category::select('id', 'name', 'parent_id')->get();

        return $categories;
    }
}