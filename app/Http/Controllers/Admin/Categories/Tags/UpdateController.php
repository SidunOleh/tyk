<?php

namespace App\Http\Controllers\Admin\Categories\Tags;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\Tags\UpdateRequest;
use App\Http\Resources\CategoryTag\CategoryTagResource;
use App\Models\CategoryTag;
use App\Services\Categories\CategoryService;

class UpdateController extends Controller
{
    public function __construct(
        public CategoryService $categoryService
    )
    {
        
    }

    public function __invoke(CategoryTag $categoryTag, UpdateRequest $request)
    {
        $this->categoryService->updateTag($categoryTag, $request);

        return response(new CategoryTagResource($categoryTag));
    }
}
