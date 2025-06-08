<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\StoreRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Services\Categories\CategoryService;

class StoreController extends Controller
{
    public function __construct(
        public CategoryService $categoryService
    )
    {
        
    }

    public function __invoke(StoreRequest $request)
    {
        $category = $this->categoryService->create($request->validated());

        return response(['category' => new CategoryResource($category),]);
    }
}
