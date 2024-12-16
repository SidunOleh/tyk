<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Orders\StoreRequest;
use App\Http\Resources\Order\OrderResource;
use App\Services\OrderService;
use Exception;
use Illuminate\Support\Facades\Log;

class StoreController extends Controller
{
    public function __construct(
        public OrderService $orderService
    )
    {
        
    }

    public function __invoke(StoreRequest $request)
    {
        try {
            $order = $this->orderService->createByAdmin($request);

            return response(['order' => new OrderResource($order),]);
        } catch (Exception $e) {
            Log::error($e);

            return response(['message' => $e->getMessage(),], 400);
        }
    }
}
