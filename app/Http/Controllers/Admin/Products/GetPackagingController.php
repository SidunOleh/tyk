<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductsSearchCollection;
use App\Services\Products\ProductService;

class GetPackagingController extends Controller
{
    public function __construct(
        public ProductService $productService
    )
    {
        
    }

    public function __invoke()
    {
        $packaging = $this->productService->getPackaging();

        return response(new ProductsSearchCollection($packaging));
    }
}
