<?php

namespace App\Services\Orders;

use App\Http\Requests\Admin\Orders\StoreRequest;
use App\Models\FoodShippingDetails;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class FoodShippingService extends OrderService
{
    public function createByAdmin(StoreRequest $request): Order
    {
        DB::beginTransaction();

        $details = FoodShippingDetails::create([
            'to' => $request->details['food_to'],
        ]);

        $order = $details->order()->create([
            'shipping_price' => $request->shipping_price ?? 0,
            'time' => $request->time ?? now()->format('Y-m-d H:i:s'),
            'notes' => $request->notes,
            'status' => 'Створено',
            'client_id' => $request->client_id,
        ]);

        $order->orderItems()->createMany($request->details['order_items']);

        DB::commit();

        return $order;
    }
}