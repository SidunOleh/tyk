<?php

namespace App\Services;

use App\Http\Requests\Admin\Orders\StoreRequest;
use App\Models\FoodShippingDetails;
use App\Models\Order;
use App\Models\ShippingDetails;
use App\Models\TaxiDetails;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function createByAdmin(StoreRequest $request): Order
    {
        DB::beginTransaction();

        if ($request->service == 'Доставка їжі') {
            $details = FoodShippingDetails::create([
                'to' => $request->details['food_to'],
            ]);
        } elseif ($request->service == 'Кур\'єр') {
            $details = ShippingDetails::create([
                'from' => $request->details['shipping_from'],
                'to' => $request->details['shipping_to'],
            ]);
        } elseif ($request->service == 'Таксі') {
            $details = TaxiDetails::create([
                'from' => $request->details['taxi_from'],
                'to' => $request->details['taxi_to'],
            ]);
        } else {
            throw new Exception('Невідомий сервіс.');
        }

        $order = $details->order()->create([
            'shipping_price' => $request->shipping_price ?? 0,
            'time' => $request->time ?? now()->format('Y-m-d H:i:s'),
            'notes' => $request->notes,
            'status' => 'Створено',
            'client_id' => $request->client_id,
        ]);

        if ($request->service == 'Доставка їжі') {
            $order->orderItems()->createMany($request->details['order_items']);
        }

        $order->updateAmount();

        DB::commit();

        return $order;
    }
}