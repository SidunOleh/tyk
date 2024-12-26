<?php

namespace App\Services\Couriers;

use App\Http\Requests\Admin\Couriers\Cashes\StoreRequest as CashesStoreRequest;
use App\Http\Requests\Admin\Couriers\Cashes\UpdateRequest as CashesUpdateRequest;
use App\Models\Cash;
use App\Models\Courier;
use App\Services\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CourierService extends Service
{
    protected string $model = Courier::class;

    public function index(Request $request): LengthAwarePaginator
    {
        $page = $request->query('page', 1);
        $perpage = $request->query('perpage', 15);
        $orderby = $request->query('orderby', 'created_at');
        $order = $request->query('order', 'DESC');
        $s = $request->query('s', '');
        $vehicles = $request->query('vehicles', []);

        $models = $this->model::orderBy($orderby, $order)
            ->search($s)
            ->vehicles($vehicles)
            ->paginate($perpage, ['*'], 'page', $page);

        return $models;
    }

    public function all(): Collection
    {
        return Courier::all();
    }

    public function createCash(Courier $courier, CashesStoreRequest $request): Cash
    {
        $cash = $courier->cashes()->create($request->validated());

        return $cash;
    }

    public function updateCash(Courier $courier, Cash $cash, CashesUpdateRequest $request): void
    {
        $cash->update($request->validated());
    }

    public function deleteCash(Courier $courier, Cash $cash): void
    {
        $cash->delete();
    }
}