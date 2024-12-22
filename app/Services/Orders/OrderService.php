<?php

namespace App\Services\Orders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\Service;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

abstract class OrderService extends Service
{
    protected string $model = Order::class;

    public function create(FormRequest $request): Model
    {
        $data = $request->validated();

        $order = Order::create([
            'type' => $data['service'],
            'shipping_price' => $data['shipping_price'] ?? 0,
            'additional_costs' => $data['additional_costs'] ?? 0,
            'time' => $data['time'] ?? now()->format('Y-m-d H:i:s'),
            'duration' => $data['duration'],
            'notes' => $data['notes'] ?? '',
            'status' => 'Створено',
            'client_id' => $data['client_id'],
            'paid' => $data['paid'],
            'payment_method' => $data['payment_method'],
            'details' => $data['details'],
        ]);

        $order->updateAmount();

        return $order;
    }

    public function update(Model $order, FormRequest $request): void
    {
        $data = $request->validated();

        $order->update([
            'type' => $data['service'],
            'shipping_price' => $data['shipping_price'] ?? 0,
            'additional_costs' => $data['additional_costs'] ?? 0,
            'time' => $data['time'] ?? now()->format('Y-m-d H:i:s'),
            'duration' => $data['duration'],
            'notes' => $data['notes'] ?? '',
            'status' => 'Створено',
            'client_id' => $data['client_id'],
            'paid' => $data['paid'],
            'payment_method' => $data['payment_method'],
            'details' => $data['details'],
        ]);

        $order->orderItems->map(fn (OrderItem $orderItem) => $orderItem->delete());

        $order->updateAmount();
    }

    public function index(Request $request): LengthAwarePaginator
    {
        $page = $request->query('page', 1);
        $perpage = $request->query('perpage', 15);
        $orderby = $request->query('orderby', 'created_at');
        $order = $request->query('order', 'DESC');
        $s = $request->query('s', '');
        $types = $request->query('type', []);
        $statuses = $request->query('statuses', []);
        $paid = $request->query('paid', []);

        $models = $this->model::orderBy($orderby, $order)
            ->search($s)
            ->types($types)
            ->statuses($statuses)
            ->paid($paid)
            ->paginate($perpage, ['*'], 'page', $page);

        return $models;
    }

    public static function make(string $type): self
    {
        switch ($type) {
            case 'Доставка їжі':
                return new FoodShippingService;
            case 'Кур\'єр':
                return new ShippingService;
            case 'Таксі':
                return new TaxiService;
            default:
                throw new Exception('Unexpected type: ' . $type);
        }
    }
}