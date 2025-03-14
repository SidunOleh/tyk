<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\Cart\Cart;
use App\Services\Categories\CategoryService;

class ProductsController extends Controller
{
    public function __construct(
        public CategoryService $categoryService,
        public Cart $cart
    )
    {
        
    }

    public function __invoke(Category $category)
    {
        $categoryTree = $this->categoryService->subtree($category->id);
        $products = $this->categoryService->getProducts($category);

        return view('pages.products', [
            'category' => $category,
            'categoryTree' => $categoryTree,
            'products' => $products,
            'cart' => $this->cart,
        ]);
    }
}
