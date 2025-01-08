<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Services\Categories\CategoryService;

class GetTreeController extends Controller
{
    public function __construct(
        public CategoryService $categoryService
    )
    {
        
    }

    public function __invoke()
    {
        $tree = $this->categoryService->tree();

        return response($tree);
    }
}
