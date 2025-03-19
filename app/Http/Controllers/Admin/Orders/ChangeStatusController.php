<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Orders\ChangeStatusRequest;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order;
use App\Services\Orders\OrderService;

class ChangeStatusController extends Controller
{
    public function __invoke(Order $order, ChangeStatusRequest $request)
    {
        OrderService::make($order->type)->changeStatus($order, $request->status);

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
