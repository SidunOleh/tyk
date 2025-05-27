<?php

namespace App\Services\Orders;

use App\DTO\Orders\OrderCarDTO;
use App\Models\Client;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaxiService extends OrderService
{
    public function create(FormRequest $request): Model
    {
        DB::beginTransaction();

        $data = $request->validated();

        $client = Client::find($data['client_id']);

        $time = $data['time'] ?? now()->format('Y-m-d H:i:s');

        $createdAt = $data['created_at'] ?? now()->format('Y-m-d H:i:s');

        $details = [];

        $details['taxi_from'] = $data['details']['taxi_from'];
        $details['taxi_to'] = $data['details']['taxi_to'];
        $client->addAddresses([$details['taxi_from'], ...$details['taxi_to'],]);

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
            'paid_by_card' => $data['paid_by_card'] ?? null,
            'paid_by_cash' => $data['paid_by_cash'] ?? null,
            'details' => $details,
            'user_id' => Auth::guard('admin')->id(),
            'reviewed' => true,
            'created_at' => $createdAt,
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
        
        $details['taxi_from'] = $data['details']['taxi_from'];
        $details['taxi_to'] = $data['details']['taxi_to'];
        $client->addAddresses([$details['taxi_from'], ...$details['taxi_to'],]);

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
            'paid_by_card' => $data['paid_by_card'] ?? null,
            'paid_by_cash' => $data['paid_by_cash'] ?? null,
            'details' => $details,
            'created_at' => $data['created_at'],
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
        
        $details['taxi_from'] = $dto->from;
        $details['taxi_to'] = $dto->to;
        $client->addAddresses([$details['taxi_from'], ...$details['taxi_to'],]);
        
        $shippingPrice = $this->priceService->calcForRoute([
            'service' => $dto->service,
            'route' => [$dto->from, ...$dto->to,],
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