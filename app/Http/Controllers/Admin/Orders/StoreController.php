<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Orders\StoreRequest;
use App\Http\Resources\Order\OrderResource;
use App\Services\Orders\OrderService;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $order = OrderService::make($request->service)->create($request);

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
