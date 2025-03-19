<?php

namespace App\Services\Orders;

use App\Models\Order;
use App\Services\Price\PriceService;
use App\Services\Service;
use App\Services\Settings\SettingsService;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

abstract class OrderService extends Service
{
    protected string $model = Order::class;

    public function __construct(
        protected PriceService $priceService,
        protected SettingsService $settingsService,
    )
    {
        
    }  

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

        $models = $this->model::with('orderItems')
            ->with('orderItems.product')
            ->with('orderItems.product.categories')
            ->with('client')
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
        $orders = Order::with('orderItems')
            ->with('orderItems.product')
            ->with('orderItems.product.categories')
            ->with('client')
            ->with('courier')
            ->betweenDate($start, $end)
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

    public function addBonusToClient(Order $order): void
    {
        $bonuses = 0;
        $settings = $this->settingsService->get();
        if ($order->type == Order::FOOD_SHIPPING) {
            $bonuses = $settings['bonuses_food_shipping'];
        } elseif ($order->type == Order::SHIPPING) {
            $bonuses = $settings['bonuses_shipping'];
        } elseif ($order->type == Order::TAXI) {
            $bonuses = $settings['bonuses_taxi'];
        }

        $order->client->addBonus($bonuses);
        $order->add_bonuses = $bonuses;
        $order->saveQuietly();
    }

    public function removeBonusFromClient(Order $order): void
    {
        $order->client->removeBonus($order->add_bonuses, true);
    }

    abstract public function repeat(Order $order): void;

    public static function make(string $type): self
    {
        switch ($type) {
            case Order::FOOD_SHIPPING:
                return app()->make(FoodShippingService::class);
            case Order::SHIPPING:
                return app()->make(ShippingService::class);
            case Order::TAXI:
                return app()->make(TaxiService::class);
            default:
                throw new Exception('Unexpected type: ' . $type);
        }
    }
}