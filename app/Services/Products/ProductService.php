<?php

namespace App\Services\Products;

use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Services\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ProductService extends Service
{
    protected string $model = Product::class;

    public function create(FormRequest $request): Model
    {
        $model = $this->model::create($request->except('categories'));

        $model->categories()->sync($request->categories);

        return $model;
    }

    public function update(Model $model, FormRequest $request): void
    {
        $model->update($request->except('categories'));

        $model->categories()->sync($request->categories);
    }
    
    public function index(Request $request): LengthAwarePaginator
    {
        $page = $request->query('page', 1);
        $perpage = $request->query('perpage', 15);
        $orderby = $request->query('orderby', 'created_at');
        $order = $request->query('order', 'DESC');
        $s = $request->query('s', '');
        $categories = $request->query('categories', []);

        $models = $this->model::with('categories')
            ->with('packagingProducts')
            ->orderBy($orderby, $order)
            ->search($s)
            ->categories($categories)
            ->paginate($perpage, ['*'], 'page', $page);

        return $models;
    }

    public function searchInCategories(string $s, array $categoriesIds): Collection
    {        
        return Product::with([
            'categories', 
            'packagingProducts',
        ])->search($s)->categories($categoriesIds)->get();
    }

    public function search(string $s): Collection
    {        
        if ($s) {
            $products = Product::with([
                'categories', 
                'packagingProducts',
            ])->search($s)->get();
        } else {
            $products = new Collection;
        }

        return $products;
    }

    public function upsells(array $productIds): Collection
    {        
        $categoryIds = CategoryProduct::whereIn('product_id', $productIds)->get()
            ->pluck('category_id')
            ->toArray();
        $categories = Category::whereIn('id', $categoryIds)->get();

        $upsells = Product::whereIn('id', $categories->pluck('upsells')->flatten())
            ->whereNotIn('id', $productIds)
            ->with([
                'categories', 
                'packagingProducts',
            ])->get(); 

        return $upsells;
    }

    public function getPackaging(): Collection
    {
        $packaging = Product::whereHas('categories', function (Builder $q) {
            $q->where('name', Category::PACKAGING_NAME);
        })->get();

        return $packaging;
    }
}