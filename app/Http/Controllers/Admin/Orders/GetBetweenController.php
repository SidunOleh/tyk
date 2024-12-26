<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrdersSearchCollection;
use App\Services\Orders\OrderService;
use Illuminate\Http\Request;

class GetBetweenController extends Controller
{
    public function __invoke(Request $request)
    {
        $orders = OrderService::make('Таксі')->getBetween(
            $request->query('start'),
            $request->query('end')
        );

        return response(new OrdersSearchCollection($orders));
    }
}
