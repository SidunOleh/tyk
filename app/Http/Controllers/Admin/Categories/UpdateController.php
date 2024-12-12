<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\UpdateRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;

class UpdateController extends Controller
{
    public function __invoke(Category $category, UpdateRequest $request)
    {
        $category->update($request->validated());

        return response(['category' => new CategoryResource($category),]);
    }
}
