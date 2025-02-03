<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoriesSearchCollection;
use App\Services\Categories\CategoryService;
use Illuminate\Http\Request;

class SearchZakladyController extends Controller
{
    public function __construct(
        public CategoryService $categoryService
    )
    {
        
    }

    public function __invoke(Request $request)
    {
        $zaklady = $this->categoryService->searchZaklady($request->query('s', ''));

        return response(new CategoriesSearchCollection($zaklady));
    }
}
