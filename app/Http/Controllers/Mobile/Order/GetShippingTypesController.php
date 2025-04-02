<?php

namespace App\Http\Controllers\Mobile\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;

class GetShippingTypesController extends Controller
{
    public function __invoke()
    {
        return response(Order::SHIPPING_TYPES);
    }
}
