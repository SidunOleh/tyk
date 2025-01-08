<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\ReorderProductsRequest;
use App\Models\Category;
use App\Services\Categories\CategoryService;

class ReorderProductsController extends Controller
{
    public function __construct(
        public CategoryService $categoryService
    )
    {
        
    }

    public function __invoke(Category $category, ReorderProductsRequest $request)
    {
        $this->categoryService->reorderProducts($category, $request);

        return response(['message' => 'OK',]);
    }
}
