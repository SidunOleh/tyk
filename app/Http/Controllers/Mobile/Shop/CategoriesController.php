<?php

namespace App\Http\Controllers\Mobile\Shop;

use App\Http\Controllers\Controller;
use App\Services\Categories\CategoryService;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function __construct(
        public CategoryService $categoryService
    )
    {
        
    }

    public function __invoke(Request $request)
    {
        $categories = $this->categoryService->subtree(
            $request->query('zaklad_id', null)
        );

        return response($categories);
    }
}
