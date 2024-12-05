<?php

namespace App\Http\Controllers\Couriers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Couriers\StoreRequest;
use App\Http\Resources\Courier\CourierResource;
use App\Models\Courier;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $courier = Courier::create($request->validated());

        return response(['courier' => new CourierResource($courier),]);
    }
}
