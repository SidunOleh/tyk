<?php

namespace App\Http\Controllers\Admin\Categories\Tags;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\Tags\StoreRequest;
use App\Http\Resources\CategoryTag\CategoryTagResource;
use App\Services\Categories\CategoryService;

class StoreController extends Controller
{
    public function __construct(
        public CategoryService $categoryService
    )
    {
        
    }

    public function __invoke(StoreRequest $request)
    {
        $tag = $this->categoryService->createTag($request);

        return response(new CategoryTagResource($tag));
    }
}
