<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\OrderCarRequest;
use App\Services\Orders\OrderService;

class OrderCarController extends Controller
{
    public function __invoke(OrderCarRequest $request)
    {
        $order = OrderService::make($request->service)->orderCar($request);

        return response(['id' => $order->id,]);
    }
}
