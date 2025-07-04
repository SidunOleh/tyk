<?php

namespace App\Http\Controllers\Orders;

use App\DTO\Orders\OrderCarDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\OrderCarRequest;
use App\Services\Orders\OrderService;
use Illuminate\Support\Facades\Auth;

class OrderCarController extends Controller
{
    public function __invoke(OrderCarRequest $request)
    {
        $order = OrderService::make($request->service)->orderCar(
            OrderCarDTO::createFromWebRequest($request),
            Auth::guard('web')->user()
        );
        
        return response(['id' => $order->id]);
    }
}
