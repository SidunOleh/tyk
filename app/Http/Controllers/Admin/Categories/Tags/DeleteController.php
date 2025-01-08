<?php

namespace App\Http\Controllers\Admin\Categories\Tags;

use App\Http\Controllers\Controller;
use App\Models\CategoryTag;
use App\Services\Categories\CategoryService;

class DeleteController extends Controller
{
    public function __construct(
        public CategoryService $categoryService
    )
    {
        
    }

    public function __invoke(CategoryTag $categoryTag)
    {
        $this->categoryService->deleteTag($categoryTag);

        return response(['message' => 'OK',]);
    }
}
