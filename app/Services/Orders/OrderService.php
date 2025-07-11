<?php

namespace App\Services\Orders;

use App\Events\CourierChanged;
use App\Events\OrderStatusChanged;
use App\Exceptions\UnexpectedOrderTypeException;
use App\Models\Order;
use App\Services\Price\PriceService;
use App\Services\Service;
use App\Services\Settings\SettingsService;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $models = $this->model::with([
                'orderItems',
                'orderItems.packaging',
                'orderItems.product',
                'orderItems.product.categories',
                'client',
                'courier',
                'zakladAddonAmounts',
                'orderStages',
                'orderStages.courier',
            ])
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
        $orders = Order::with([
                'orderItems',
                'orderItems.packaging',
                'orderItems.product',
                'orderItems.product.categories',
                'client',
                'courier',
                'zakladAddonAmounts',
                'orderStages',
                'orderStages.courier',
            ])
            ->betweenDate($start, $end)
            ->orderBy('created_at', 'DESC')
            ->get();

        return $orders;
    }

    public function changeStatus(Order $order, string $status): void
    {
        $oldStatus = $order->status;

        $order->update(['status' => $status]);

        OrderStatusChanged::dispatch($order, $oldStatus);
    }

    public function changeCourier(Order $order, ?int $courierId): void
    {        
        $prevCourier = $order->courier;

        $order->update(['courier_id' => $courierId]);

        CourierChanged::dispatch($order, $prevCourier);
    }

    public function changeTime(Order $order, Carbon $time, int $duration): void
    {
        $order->update([
            'time' => $time->format('Y-m-d H:i:s'),
            'duration' => $duration,
        ]);
    }

    public function addBonuses(Order $order): void
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

        DB::beginTransaction();

        $order->client->addBonus($bonuses);

        $order->update(['add_bonuses' => $bonuses]);

        DB::commit();
    }

    public function removeBonuses(Order $order): void
    {
        DB::beginTransaction();

        $order->client->removeBonus($order->add_bonuses, true);

        $order->update(['add_bonuses' => 0]);

        DB::commit();
    }

    public function resetUsedBonuses(Order $order): void
    {
        DB::beginTransaction();

        $order->client->addBonus($order->bonuses);

        $order->update(['bonuses' => 0]);

        DB::commit();
    }

    public function review(Order $order): void
    {
        $order->update(['reviewed' => true]);
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
                throw new UnexpectedOrderTypeException($type);
        }
    }
}