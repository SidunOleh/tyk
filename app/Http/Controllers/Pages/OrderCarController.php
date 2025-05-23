<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\CourierServices\CourierServiceService;
use Illuminate\Http\Request;

class OrderCarController extends Controller
{
    public function __construct(
        public CourierServiceService $courierServiceService
    )
    {
        
    }

    public function __invoke(Request $request)
    {
        $order = null;

        if ($orderId = $request->query('order')) {
            $order = Order::findOrFail($orderId);
        }

        $courierServices = $this->courierServiceService->visible();

        return view('pages.order-car', [
            'order' => $order,
            'courierServices' => $courierServices,
        ]);
    }
}
