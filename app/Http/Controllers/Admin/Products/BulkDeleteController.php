<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\BulkDeleteRequest;
use App\Models\Product;

class BulkDeleteController extends Controller
{
    public function __invoke(BulkDeleteRequest $request)
    {
        Product::destroy($request->ids);

        return response(['message' => 'OK',]);
    }
}
