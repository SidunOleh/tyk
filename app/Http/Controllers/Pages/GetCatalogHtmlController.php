<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\Cart\Cart;
use App\Services\Categories\CategoryService;

class GetCatalogHtmlController extends Controller
{
    public function __construct(
        public CategoryService $categoryService,
        public Cart $cart
    )
    {
        
    }

    public function __invoke(Category $category)
    {
        $products = $this->categoryService->getProducts($category);

        return response(view('templates.catalog', [
            'category' => $category,
            'products' => $products,
            'cart' => $this->cart,
        ])->render());
    }
}
