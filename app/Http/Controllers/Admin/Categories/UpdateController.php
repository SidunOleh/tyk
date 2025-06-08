<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\UpdateRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use App\Services\Categories\CategoryService;

class UpdateController extends Controller
{
    public function __construct(
        public CategoryService $categoryService
    )
    {
        
    }

    public function __invoke(Category $category, UpdateRequest $request)
    {
        $this->categoryService->update($category, $request->validated());

        return response(['category' => new CategoryResource($category),]);
    }
}
