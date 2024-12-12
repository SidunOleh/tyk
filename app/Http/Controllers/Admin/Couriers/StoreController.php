<?php

namespace App\Http\Controllers\Admin\Couriers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Couriers\StoreRequest;
use App\Http\Resources\Courier\CourierResource;
use App\Models\Courier;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $courier = Courier::create($request->validated());

        return response(['courier' => new CourierResource($courier),]);
    }
}
