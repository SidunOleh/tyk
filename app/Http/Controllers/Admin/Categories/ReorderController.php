<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\ReorderRequest;
use App\Services\Categories\CategoryService;

class ReorderController extends Controller
{
    public function __construct(
        public CategoryService $categoryService
    )
    {
        
    }

    public function __invoke(ReorderRequest $request)
    {
        $this->categoryService->reorder($request);

        return response(['message' => 'OK',]);
    }
}
