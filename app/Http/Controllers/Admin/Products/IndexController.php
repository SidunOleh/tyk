<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductsCollection;
use App\Models\Product;
use App\Services\Products\ProductService;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __construct(
        public ProductService $productService
    )
    {
        
    }

    public function __invoke(Request $request)
    {
        $products = $this->productService->index($request);

        return response(new ProductsCollection($products));
    }
}
