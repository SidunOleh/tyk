<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Orders\OrderService;

class DeleteController extends Controller
{
    public function __invoke(Order $order)
    {
        OrderService::make($order->type)->delete($order);

        return response(['message' => 'OK',]);
    }
}
