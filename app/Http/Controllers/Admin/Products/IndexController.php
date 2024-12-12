<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductsCollection;
use App\Models\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $page = $request->query('page', 1);
        $perpage = $request->query('perpage', 15);
        $orderby = $request->query('orderby', 'created_at');
        $order = $request->query('order', 'DESC');
        $s = $request->query('s', '');
        $categories = $request->query('categories', []);

        $products = Product::orderBy($orderby, $order)
            ->search($s)
            ->categories($categories)
            ->paginate($perpage, ['*'], 'page', $page);

        return response(new ProductsCollection($products));
    }
}
