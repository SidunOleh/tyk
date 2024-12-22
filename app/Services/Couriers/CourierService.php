<?php

namespace App\Services\Couriers;

use App\Http\Requests\Admin\Couriers\Cashes\StoreRequest as CashesStoreRequest;
use App\Http\Requests\Admin\Couriers\Cashes\UpdateRequest as CashesUpdateRequest;
use App\Models\Cash;
use App\Models\Courier;
use App\Services\Service;

class CourierService extends Service
{
    protected string $model = Courier::class;

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