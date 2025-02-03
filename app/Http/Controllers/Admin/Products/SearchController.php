<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductsSearchCollection;
use App\Services\Products\ProductService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct(
        public ProductService $productService
    )
    {
        
    }

    public function __invoke(Request $request)
    {
        $categoryId = $request->query('category_id', null);

        if ($categoryId) {
            $products = $this->productService->searchInCategory($request->query('s', ''), $categoryId);
        } else {
            $products = $this->productService->search($request->query('s', ''));
        }

        return response(new ProductsSearchCollection($products));
    }
}
