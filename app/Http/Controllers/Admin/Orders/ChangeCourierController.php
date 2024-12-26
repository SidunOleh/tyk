<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Orders\ChangeCourierRequest;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order;
use App\Services\Orders\OrderService;

class ChangeCourierController extends Controller
{
    public function __invoke(Order $order, ChangeCourierRequest $request)
    {
        OrderService::make($order->type)->changeCourier($order, $request->courier_id);

        return response(['order' => new OrderResource($order),]);
    }
}
