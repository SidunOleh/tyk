<?php

namespace App\Services\Orders;

use App\Http\Requests\Orders\OrderCarRequest;
use App\Models\Client;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

class TaxiService extends OrderService
{
    public function create(FormRequest $request): Model
    {
        $data = $request->validated();

        $time = $data['time'] ?? now()->format('Y-m-d H:i:s');

        $details['taxi_from'] = $data['details']['taxi_from'];
        $details['taxi_to'] = $data['details']['taxi_to'];

        $order = Order::create([
            'type' => $data['service'],
            'shipping_price' => $data['shipping_price'] ?? 0,
            'additional_costs' => $data['additional_costs'] ?? 0,
            'time' => $time,
            'duration' => $data['duration'],
            'notes' => $data['notes'] ?? '',
            'status' => Order::CREATED,
            'client_id' => $data['client_id'],
            'paid' => $data['paid'],
            'payment_method' => $data['payment_method'],
            'details' => $details,
        ]);
        $order->updateAmount();

        $client = Client::find($data['client_id']);
        $client->addAddresses([$details['taxi_from'], ...$details['taxi_to'],]);

        return $order;
    }

    public function update(Model $order, FormRequest $request): void
    {
        $data = $request->validated();
        
        $details['taxi_from'] = $data['details']['taxi_from'];
        $details['taxi_to'] = $data['details']['taxi_to'];

        $order->update([
            'type' => $data['service'],
            'shipping_price' => $data['shipping_price'] ?? 0,
            'additional_costs' => $data['additional_costs'] ?? 0,
            'time' => $data['time'],
            'duration' => $data['duration'],
            'notes' => $data['notes'] ?? '',
            'client_id' => $data['client_id'],
            'paid' => $data['paid'],
            'payment_method' => $data['payment_method'],
            'details' => $details,
        ]);
        $order->updateAmount();

        $client = Client::find($data['client_id']);
        $client->addAddresses([$details['taxi_from'], ...$details['taxi_to'],]);
    }

    public function repeat(Order $order): void
    {
 
    }

    public function orderCar(OrderCarRequest $request): Order
    {
        $data = $request->validated();

        $time = $data['time'] ?? now()->format('Y-m-d H:m:i');
        $duration = 30;

        $details['taxi_from'] = $data['from'];
        $details['taxi_to'] = [$data['to']];

        $client = auth('web')->user();

        $order = Order::create([
            'type' => $data['service'],
            'time' => $time,
            'duration' => $duration,
            'status' => Order::CREATED,
            'client_id' => $client->id,
            'payment_method' => $data['payment_method'],
            'details' => $details,
        ]);

        $client->addAddresses([$details['taxi_from'], ...$details['taxi_to'],]);

        return $order;
    }
}