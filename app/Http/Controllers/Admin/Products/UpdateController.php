<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\UpdateRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;

class UpdateController extends Controller
{
    public function __invoke(Product $product, UpdateRequest $request)
    {
        $product->update($request->except('categories'));

        $product->categories()->sync($request->categories);

        return response(['product' => new ProductResource($product),]);
    }
}
