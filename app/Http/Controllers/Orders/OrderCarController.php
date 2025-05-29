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
            new OrderCarDTO(
                $request->service,
                $request->from,
                $request->to,
                $request->date,
                $request->time,
                $request->shipping_type,
                $request->comment,
                $request->payment_method,
                $request->use_bonuses,
                $request->callback
            ), 
            Auth::guard('web')->user()
        );
        
        return response(['id' => $order->id]);
    }
}
