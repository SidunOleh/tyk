<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\UpdateRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Services\Products\ProductService;

class UpdateController extends Controller
{
    public function __construct(
        public ProductService $productService
    )
    {
        
    }

    public function __invoke(Product $product, UpdateRequest $request)
    {
        $this->productService->update($product, $request->validated());

        return response(['product' => new ProductResource($product),]);
    }
}
