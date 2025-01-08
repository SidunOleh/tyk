<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\Categories\CategoryService;

class GetProducts extends Controller
{
    public function __construct(
        public CategoryService $categoryService
    )
    {
        
    }

    public function __invoke(Category $category)
    {
        $products = $this->categoryService->getProducts($category);

        return response([
            'category' => $category,
            'products' => $products,
        ]);
    }
}
