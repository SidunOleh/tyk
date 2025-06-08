<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Orders\UpdateRequest;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order;
use App\Services\Orders\OrderService;

class UpdateController extends Controller
{
    public function __invoke(Order $order, UpdateRequest $request)
    {
        OrderService::make($request->service)->update($order, $request->validated());

        $order->load([
            'orderItems',
            'orderItems.product',
            'orderItems.product.categories',
            'client',
            'courier',
        ]);

        return response(['order' => new OrderResource($order),]);
    }
}
