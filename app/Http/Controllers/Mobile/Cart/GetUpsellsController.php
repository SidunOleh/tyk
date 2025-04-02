<?php

namespace App\Http\Controllers\Mobile\Cart;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductsSearchCollection;
use App\Services\Products\ProductService;
use Illuminate\Http\Request;

class GetUpsellsController extends Controller
{
    public function __construct(
        public ProductService $productService
    )
    {
        
    }

    public function __invoke(Request $request)
    {
        $upsells = $this->productService->upsells($request->query('products', []));

        return response(new ProductsSearchCollection($upsells));
    }
}
