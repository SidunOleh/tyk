<?php

namespace App\Services\Cars;

use App\Models\Car;
use App\Services\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class CarService extends Service
{
    protected string $model = Car::class;

    public function index(Request $request): LengthAwarePaginator
    {
        $page = $request->query('page', 1);
        $perpage = $request->query('perpage', 15);
        $orderby = $request->query('orderby', 'created_at');
        $order = $request->query('order', 'DESC');
        $s = $request->query('s', '');

        $models = $this->model::with('owner')
            ->search($s)
            ->orderBy($orderby, $order)
            ->paginate($perpage, ['*'], 'page', $page);

        return $models;
    }
}