<?php

namespace App\Http\Controllers\Admin\Couriers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Couriers\UpdateRequest;
use App\Http\Resources\Courier\CourierResource;
use App\Models\Courier;

class UpdateController extends Controller
{
    public function __invoke(Courier $courier, UpdateRequest $request)
    {
        $courier->update($request->validated());
        
        return response(['courier' => new CourierResource($courier),]);
    }
}
