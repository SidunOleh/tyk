<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Products\ProductService;

class DeleteController extends Controller
{
    public function __construct(
        public ProductService $productService
    )
    {
        
    }

    public function __invoke(Product $product)
    {
        $this->productService->delete($product);

        return response(['message' => 'OK',]);
    }
}
