<?php

namespace App\Services\Orders;

use App\Http\Requests\Orders\OrderCarRequest;
use App\Models\Client;
use App\Models\Order;
use App\Services\Price\PriceService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ShippingService extends OrderService
{
    public function __construct(
        private PriceService $priceService
    )
    {
        
    }    

    public function create(FormRequest $request): Model
    {
        $data = $request->validated();

        $time = $data['time'] ?? now()->format('Y-m-d H:i:s');

        $details['shipping_type'] = $data['details']['shipping_type']; 
        $details['shipping_from'] = $data['details']['shipping_from'];
        $details['shipping_to'] = $data['details']['shipping_to'];

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
            'user_id' => Auth::guard('admin')->id(),
        ]);
        $order->updateAmount();

        $client = Client::find($data['client_id']);
        $client->addAddresses([$details['shipping_from'], ...$details['shipping_to'],]);

        return $order;
    }

    public function update(Model $order, FormRequest $request): void
    {
        $data = $request->validated();
        
        $details['shipping_type'] = $data['details']['shipping_type']; 
        $details['shipping_from'] = $data['details']['shipping_from'];
        $details['shipping_to'] = $data['details']['shipping_to'];

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
        $client->addAddresses([$details['shipping_from'], ...$details['shipping_to'],]);
    }

    public function repeat(Order $order): void
    {
        
    }

    public function orderCar(OrderCarRequest $request): Order
    {
        $data = $request->validated();

        $time = "{$data['date']} {$data['time']}:00";
        $duration = 30;

        $details['shipping_from'] = $data['from'];
        $details['shipping_to'] = $data['to'];
        $details['shipping_type'] = $data['shipping_type'] ?? '';

        $shippingPrice = $this->priceService->calcForRoute([
            'service' => $data['service'],
            'route' => [$data['from'], ...$data['to'],],
            'courier_service' => $data['shipping_type'] ?? '',
        ]);
        $total = $shippingPrice;

        $client = auth('web')->user();

        $order = Order::create([
            'type' => $data['service'],
            'time' => $time,
            'duration' => $duration,
            'status' => Order::CREATED,
            'client_id' => $client->id,
            'payment_method' => $data['payment_method'],
            'notes' => $data['comment'],
            'shipping_price' => $shippingPrice,
            'total' => $total,
            'details' => $details,
        ]);

        $client->addAddresses([$details['shipping_from'], ...$details['shipping_to'],]);

        return $order;
    }
}