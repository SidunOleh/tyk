<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Services\Categories\CategoryService;

class GetAllController extends Controller
{
    public function __construct(
        public CategoryService $categoryService
    )
    {
        
    }

    public function __invoke()
    {
        $categories = $this->categoryService->all();
        
        return response(['categories' => $categories,]);
    }
}
