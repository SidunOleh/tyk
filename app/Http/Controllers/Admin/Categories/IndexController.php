<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoriesCollection;
use App\Services\Categories\CategoryService;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __construct(
        public CategoryService $categoryService
    )
    {
        
    }

    public function __invoke(Request $request)
    {
        $categories = $this->categoryService->index($request);

        return response(new CategoriesCollection($categories));
    }
}
