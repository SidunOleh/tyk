<?php

namespace App\Services\Products;

use App\Models\Product;
use App\Services\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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

        $models = $this->model::orderBy($orderby, $order)
            ->search($s)
            ->categories($categories)
            ->paginate($perpage, ['*'], 'page', $page);

        return $models;
    }

    public function searchInCategory(string $s, int $categoryId): Collection
    {        
        return Product::search($s)->categories([$categoryId])->get();
    }
}