<?php

namespace App\Http\Controllers\Couriers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Couriers\UpdateRequest;
use App\Http\Resources\Courier\CourierResource;
use App\Models\Courier;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function __invoke(Courier $courier, UpdateRequest $request)
    {
        $courier->update($request->validated());
        
        return response(['courier' => new CourierResource($courier),]);
    }
}
