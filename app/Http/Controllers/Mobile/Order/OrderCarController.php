<?php

namespace App\Http\Controllers\Mobile\Order;

use App\DTO\Orders\OrderCarDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\Order\OrderCarRequest;
use App\Services\Orders\OrderService;
use Illuminate\Support\Facades\Auth;

class OrderCarController extends Controller
{
    public function __invoke(OrderCarRequest $request)
    {
        $order = OrderService::make($request->service)->orderCar(
            OrderCarDTO::createFromMobileRequest($request),
            Auth::user()
        );
        
        return response(['id' => $order->id]);
    }
}
