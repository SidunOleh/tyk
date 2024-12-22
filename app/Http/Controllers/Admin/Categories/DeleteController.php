<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\Categories\CategoryService;

class DeleteController extends Controller
{
    public function __construct(
        public CategoryService $categoryService
    )
    {
        
    }

    public function __invoke(Category $category)
    {
        $this->categoryService->delete($category);

        return response(['message' => 'OK',]);
    }
}
