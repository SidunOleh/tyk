<?php

namespace App\Http\Controllers\Mobile\Shop;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryTag\CategoryTagsCollection;
use App\Services\Categories\CategoryService;

class TagsController extends Controller
{
    public function __construct(
        public CategoryService $categoryService
    )
    {
        
    }

    public function __invoke()
    {
        $tags = $this->categoryService->getTags();

        return response(new CategoryTagsCollection($tags));
    }
}
