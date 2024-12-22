<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\StoreRequest;
use App\Http\Resources\Product\ProductResource;
use App\Services\Products\ProductService;

class StoreController extends Controller
{
    public function __construct(
        public ProductService $productService
    )
    {
        
    }

    public function __invoke(StoreRequest $request)
    {
        $product = $this->productService->create($request);

        return response(['product' => new ProductResource($product),]);
    }
}
