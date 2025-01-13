<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\TaxiRequest;
use App\Services\Orders\OrderService;

class TaxiController extends Controller
{
    public function __construct(
        public OrderService $orderService
    )
    {
        
    }

    public function __invoke(TaxiRequest $request)
    {
        
    }
}
