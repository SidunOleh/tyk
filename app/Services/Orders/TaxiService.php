<?php

namespace App\Services\Orders;

use App\Http\Requests\Admin\Orders\StoreRequest;
use App\Models\Order;
use App\Models\TaxiDetails;
use Illuminate\Support\Facades\DB;

class TaxiService extends OrderService
{
    public function createByAdmin(StoreRequest $request): Order
    {
        DB::beginTransaction();

        $details = TaxiDetails::create([
            'from' => $request->details['taxi_from'],
            'to' => $request->details['taxi_to'],
        ]);

        $order = $details->order()->create([
            'shipping_price' => $request->shipping_price ?? 0,
            'time' => $request->time ?? now()->format('Y-m-d H:i:s'),
            'notes' => $request->notes,
            'status' => 'Створено',
            'client_id' => $request->client_id,
        ]);

        DB::commit();

        return $order;
    }
}