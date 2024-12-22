<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\BulkDeleteRequest;
use App\Services\Categories\CategoryService;

class BulkDeleteController extends Controller
{
    public function __construct(
        public CategoryService $categoryService
    )
    {
        
    }

    public function __invoke(BulkDeleteRequest $request)
    {
        $this->categoryService->bulkDelete($request->ids);

        return response(['message' => 'OK',]);
    }
}
