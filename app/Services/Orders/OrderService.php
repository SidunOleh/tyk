<?php

namespace App\Services\Orders;

use App\Models\Order;
use App\Services\Google\MapsService;
use App\Services\Options\OptionService;
use App\Services\Price\PriceService;
use App\Services\Service;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

abstract class OrderService extends Service
{
    protected string $model = Order::class;

    public function index(Request $request): LengthAwarePaginator
    {
        $page = $request->query('page', 1);
        $perpage = $request->query('perpage', 15);
        $orderby = $request->query('orderby', 'created_at');
        $order = $request->query('order', 'DESC');
        $s = $request->query('s', '');
        $types = $request->query('type', []);
        $statuses = $request->query('status', []);
        $paid = $request->query('paid', []);
        $paid = array_map(fn ($paid) => $paid == 'true' ? true : false, $paid);

        $models = $this->model::with('client')
            ->with('client.ordersByDate')
            ->with('client.ordersByDate.courier')
            ->with('courier')
            ->orderBy($orderby, $order)
            ->search($s)
            ->types($types)
            ->statuses($statuses)
            ->paid($paid)
            ->paginate($perpage, ['*'], 'page', $page);

        return $models;
    }

    public function getBetween(string $start, string $end): Collection
    {
        $orders = Order::betweenDate($start, $end)
            ->orderBy('created_at', 'DESC')
            ->get();

        return $orders;
    }

    public function changeStatus(Order $order, string $status): void
    {
        $order->update(['status' => $status]);
    }

    public function changeCourier(Order $order, ?int $courierId): void
    {
        $order->update(['courier_id' => $courierId]);
    }

    abstract public function repeat(Order $order): void;

    public static function make(string $type): self
    {
        switch ($type) {
            case Order::FOOD_SHIPPING:
                return new FoodShippingService;
            case Order::SHIPPING:
                return new ShippingService(new PriceService(new MapsService, new OptionService));
            case Order::TAXI:
                return new TaxiService(new PriceService(new MapsService, new OptionService));
            default:
                throw new Exception('Unexpected type: ' . $type);
        }
    }
}