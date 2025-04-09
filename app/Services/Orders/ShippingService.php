<?php

namespace App\Services\Orders;

use App\DTO\Orders\OrderCarDTO;
use App\Models\Client;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShippingService extends OrderService
{
    public function create(FormRequest $request): Model
    {
        DB::beginTransaction();

        $data = $request->validated();

        $client = Client::find($data['client_id']);
        
        $time = $data['time'] ?? now()->format('Y-m-d H:i:s');

        $details = [];

        $details['shipping_type'] = $data['details']['shipping_type'];

        $details['shipping_from'] = $data['details']['shipping_from'];
        $details['shipping_to'] = $data['details']['shipping_to'];
        $client->addAddresses([$details['shipping_from'], ...$details['shipping_to'],]);

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

        if ($data['use_bonuses']) {
            $order->useBonuses();
        }

        DB::commit();

        return $order;
    }

    public function update(Model $order, FormRequest $request): void
    {
        DB::beginTransaction();

        $data = $request->validated();
        
        $client = Client::find($data['client_id']);

        $details = [];

        $details['shipping_type'] = $data['details']['shipping_type']; 
        
        $details['shipping_from'] = $data['details']['shipping_from'];
        $details['shipping_to'] = $data['details']['shipping_to'];
        $client->addAddresses([$details['shipping_from'], ...$details['shipping_to'],]);

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
        
        DB::commit();
    }

    public function repeat(Order $order): void
    {
        
    }

    public function orderCar(OrderCarDTO $dto, Client $client): Order
    {
        DB::beginTransaction();

        $time = "{$dto->date} {$dto->time}:00";

        $details = [];

        $details['shipping_from'] = $dto->from;
        $details['shipping_to'] = $dto->to;
        $client->addAddresses([$details['shipping_from'], ...$details['shipping_to'],]);
        
        $details['shipping_type'] = $dto->shippingType;

        $shippingPrice = $this->priceService->calcForRoute([
            'service' => $dto->service,
            'route' => [$dto->from, ...$dto->to,],
            'courier_service' => $dto->shippingType ?? '',
        ]);

        $order = Order::create([
            'type' => $dto->service,
            'time' => $time,
            'duration' => Order::DEFAULT_DURATION,
            'status' => Order::CREATED,
            'client_id' => $client->id,
            'payment_method' => $dto->paymentMethod,
            'notes' => $dto->comment,
            'shipping_price' => $shippingPrice,
            'details' => $details,
        ]);

        $order->updateAmount();

        if ($dto->useBonuses) {
            $order->useBonuses();
        }

        DB::commit();

        return $order;
    }
}