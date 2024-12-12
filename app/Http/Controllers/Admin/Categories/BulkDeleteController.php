<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\BulkDeleteRequest;
use App\Models\Category;

class BulkDeleteController extends Controller
{
    public function __invoke(BulkDeleteRequest $request)
    {
        Category::destroy($request->ids);

        return response(['message' => 'OK',]);
    }
}
