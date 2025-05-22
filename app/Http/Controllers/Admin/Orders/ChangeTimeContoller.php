<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Orders\ChangeTimeRequest;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order;
use App\Services\Orders\OrderService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChangeTimeContoller extends Controller
{
    public function __invoke(Order $order, ChangeTimeRequest $request)
    {
        OrderService::make($order->type)->changeTime(
            $order, 
            Carbon::createFromFormat('Y-m-d H:i:s', $request->time),
            $request->duration
        );

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
