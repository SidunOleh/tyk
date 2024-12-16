<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductsSearchCollection;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $s = $request->query('s', '');
        
        if ($s) {
            $products = Product::search($s)->get();
        } else {
            $products = [];
        }

        return response(new ProductsSearchCollection($products));
    }
}
