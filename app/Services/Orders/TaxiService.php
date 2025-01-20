<?php

namespace App\Services\Orders;

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

        $details['taxi_from'] = array_merge(['address' => $data['details']['taxi_from']], $this->getLatLng($data['details']['taxi_from']));
        $addresses = [];
        foreach ($data['details']['taxi_to'] as $address) {
            $addresses[] = array_merge(['address' => $address], $this->getLatLng($address));
        }
        $details['taxi_to'] = $addresses;

        Client::find($data['client_id'])->addAddresses([
            $details['taxi_from'],
            ...$details['taxi_to'],
        ]);

        $order = Order::create([
            'type' => $data['service'],
            'shipping_price' => $data['shipping_price'] ?? 0,
            'additional_costs' => $data['additional_costs'] ?? 0,
            'time' => $time,
            'duration' => $data['duration'],
            'notes' => $data['notes'] ?? '',
            'status' => 'Створено',
            'client_id' => $data['client_id'],
            'paid' => $data['paid'],
            'payment_method' => $data['payment_method'],
            'details' => $details,
        ]);

        $order->updateAmount();

        return $order;
    }

    public function update(Model $order, FormRequest $request): void
    {
        $data = $request->validated();

        $details['taxi_from'] = array_merge(['address' => $data['details']['taxi_from']], $this->getLatLng($data['details']['taxi_from']));
        $addresses = [];
        foreach ($data['details']['taxi_to'] as $address) {
            $addresses[] = array_merge(['address' => $address], $this->getLatLng($address));
        }
        $details['taxi_to'] = $addresses;

        Client::find($data['client_id'])->addAddresses([
            $details['taxi_from'],
            ...$details['taxi_to'],
        ]);

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
    }

    public function repeat(Order $order): void
    {

    }
}