<?php

namespace App\Services\Categories;

use App\Http\Requests\Admin\Categories\ReorderProductsRequest;
use App\Http\Requests\Admin\Categories\ReorderRequest;
use App\Http\Requests\Admin\Categories\Tags\ReorderRequest as TagsReorderRequest;
use App\Http\Requests\Admin\Categories\Tags\StoreRequest;
use App\Http\Requests\Admin\Categories\Tags\UpdateRequest;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\CategoryTag;
use App\Services\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryService extends Service
{
    protected string $model = Category::class;

    public function index(Request $request): LengthAwarePaginator
    {
        $page = $request->query('page', 1);
        $perpage = $request->query('perpage', 15);
        $orderby = $request->query('orderby', 'created_at');
        $order = $request->query('order', 'DESC');
        $s = $request->query('s', '');
        $parents = $request->query('parent', []);

        $models = $this->model::orderBy($orderby, $order)
            ->with('tags')
            ->with('upsells')
            ->with('upsells.categories')
            ->search($s)
            ->parents($parents)
            ->paginate($perpage, ['*'], 'page', $page);

        return $models;
    }

    public function create(FormRequest $request): Model
    {
        $category = Category::create($request->except('tags'));

        $category->tags()->sync($request->tags ?? []);

        return $category;
    }

    public function update(Model $category, FormRequest $request): void
    {
        $category->update($request->except('tags'));

        $category->tags()->sync($request->tags ?? []);
    }

    public function all(): Collection
    {
        return Category::select('id', 'name', 'parent_id')->get();
    }

    public function tree(): array
    {
        $categories = Category::select('id', 'name', 'parent_id')
            ->orderByRaw('-categories.order DESC')
            ->get();

        return $this->makeTree($categories->toArray(), 0);
    }

    public function subtree(int $parentId)
    {
        $subtree = DB::select("
            WITH RECURSIVE cte AS
            (
                SELECT c1.id, c1.name, c1.slug, c1.image, c1.description, c1.parent_id, c1.order
                    FROM categories c1
                    WHERE parent_id=:parent_id AND visible=true AND deleted_at IS NULL
                UNION ALL
                SELECT c2.id, c2.name, c2.slug, c2.image, c2.description, c2.parent_id, c2.order
                    FROM categories c2
                    JOIN cte
                    ON cte.id=c2.parent_id
                    WHERE visible=true AND deleted_at IS NULL
            )
            SELECT * FROM cte ORDER BY -cte.order DESC;
        ", ['parent_id' => $parentId,]);

        return $this->makeTree($subtree, $parentId);
    }

    private function makeTree(
        array $categories, 
        int $parentId
    ): array
    {
        $tree = [];
        foreach ($categories as $category) {
            $category = (array) $category;
            if ($category['parent_id'] == $parentId) {
                $category['children'] = $this->makeTree(
                    $categories, 
                    $category['id']
                );
                $tree[] = $category;
            }
        }

        return $tree;
    }

    public function reorder(ReorderRequest $request): void
    {
        $data = $request->validated();

        Category::batchUpdate($this->makeReorderUpdates($data['tree']), 'id');
    }

    private function makeReorderUpdates(
        array $tree, 
        ?int $parentId = null
    ): array
    {
        $updates = [];
        foreach ($tree as $i => $item) {
            $updates[] = [
                'id' => $item['id'],
                'parent_id' => $parentId,
                'order' => $i+1,
            ];
            
            if ($item['children']) {
                $updates = array_merge(
                    $updates, 
                    $this->makeReorderUpdates(
                        $item['children'],
                         $item['id']
                    )
                );
            }
        }

        return $updates;
    }

    public function getProducts(Category $category): Collection
    {
        $products = $category->products()
            ->select('products.id', 'products.name', 'products.image', 'products.price')
            ->orderByRaw('-category_product.order DESC')
            ->get();

        return $products;
    }

    public function reorderProducts(
        Category $category, 
        ReorderProductsRequest $request
    ): void
    {
        $data = $request->validated();
        $updates = [];
        foreach ($data['products'] as $i => $product) {
            $updates[] = [
                'category_id' => $category->id,
                'product_id' => $product['id'],
                'order' => $i+1,
            ];
        }

        batch()->updateWithTwoIndex(
            new CategoryProduct, 
            $updates, 
            'product_id', 
            'category_id'
        );
    }

    public function searchZaklady(string $s): Collection
    {
        if ($s) {
            $categories = Category::zaklad()->search($s)->get();
        } else {
            $categories = new Collection;
        }

        return $categories;
    }

    public function getTags(): Collection
    {
        return CategoryTag::orderByRaw('-category_tags.order DESC')->get();
    }

    public function createTag(StoreRequest $request): CategoryTag
    {
        return CategoryTag::create($request->validated());
    }

    public function updateTag(CategoryTag $tag, UpdateRequest $request): void
    {
        $tag->update($request->validated());
    }

    public function deleteTag(CategoryTag $tag): void
    {
        $tag->delete();
    }

    public function reorderTags(TagsReorderRequest $request): void
    {
        $data = $request->validated();
        $updates = [];
        foreach ($data['tags'] as $i => $tag) {
            $updates[] = [
                'id' => $tag['id'],
                'order' => $i+1,
            ];
        }

        CategoryTag::batchUpdate($updates, 'id');
    }

    public function zaklady(): Collection
    {
        $zaklady = Category::with('tags')->zaklad()->visible()->get();

        return $zaklady;
    }
}