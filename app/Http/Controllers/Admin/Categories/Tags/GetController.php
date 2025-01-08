<?php

namespace App\Http\Controllers\Admin\Categories\Tags;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryTag\CategoryTagsCollection;
use App\Services\Categories\CategoryService;

class GetController extends Controller
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
