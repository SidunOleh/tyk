<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\BulkDeleteRequest;
use App\Services\Products\ProductService;

class BulkDeleteController extends Controller
{
    public function __construct(
        public ProductService $productService
    )
    {
        
    }

    public function __invoke(BulkDeleteRequest $request)
    {
        $this->productService->bulkDelete($request->ids);

        return response(['message' => 'OK',]);
    }
}
