<?php

namespace App\Services\Orders;

use App\Models\Client;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

class ShippingService extends OrderService
{
    public function create(FormRequest $request): Model
    {
        $data = $request->validated();

        $time = $data['time'] ?? now()->format('Y-m-d H:i:s');

        $details['shipping_type'] = $data['details']['shipping_type']; 
        $details['shipping_from'] = array_merge(['address' => $data['details']['shipping_from']], $this->getLatLng($data['details']['shipping_from']));
        $addresses = [];
        foreach ($data['details']['shipping_to'] as $address) {
            $addresses[] = array_merge(['address' => $address], $this->getLatLng($address));
        }
        $details['shipping_to'] = $addresses;

        Client::find($data['client_id'])->addAddresses([
            $details['shipping_from'],
            ...$details['shipping_to'],
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

        $details['shipping_type'] = $data['details']['shipping_type']; 
        $details['shipping_from'] = array_merge(['address' => $data['details']['shipping_from']], $this->getLatLng($data['details']['shipping_from']));
        $addresses = [];
        foreach ($data['details']['shipping_to'] as $address) {
            $addresses[] = array_merge(['address' => $address], $this->getLatLng($address));
        }
        $details['shipping_to'] = $addresses;

        Client::find($data['client_id'])->addAddresses([
            $details['shipping_from'],
            ...$details['shipping_to'],
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