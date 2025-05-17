<?php

namespace App\Http\Controllers\Mobile\Shop;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoriesSearchCollection;
use App\Services\Categories\CategoryService;

class ZakladyController extends Controller
{
    public function __construct(
        public CategoryService $categoryService
    )
    {
        
    }

    public function __invoke()
    {
        $zaklady = $this->categoryService->zakladyMobile();

        return response(new CategoriesSearchCollection($zaklady));
    }
}
