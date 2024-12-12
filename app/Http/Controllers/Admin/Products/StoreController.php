<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\StoreRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $product = Product::create($request->except('categories'));

        $product->categories()->sync($request->categories);

        return response(['product' => new ProductResource($product),]);
    }
}
