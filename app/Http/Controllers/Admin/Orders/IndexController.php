<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrdersCollection;
use App\Services\Orders\OrderService;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $orders = OrderService::make('Таксі')->index($request);

        return response(new OrdersCollection($orders));
    }
}
