<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Models\Category;

class GetAllController extends Controller
{
    public function __invoke()
    {
        $categories = Category::select('id', 'name', 'parent_id')->get();
        
        return response(['categories' => $categories,]);
    }
}
