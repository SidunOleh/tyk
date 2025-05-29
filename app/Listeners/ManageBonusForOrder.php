<?php

namespace App\Listeners;

use App\Events\OrderStatusChanged;
use App\Models\Order;
use App\Services\Orders\OrderService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ManageBonusForOrder
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderStatusChanged $event): void
    {
        $order = $event->order;
        $oldStatus = $event->oldStatus;

        if ($oldStatus != Order::DONE and $order->status == Order::DONE) {
            OrderService::make($order->type)->addBonusesForOrder($order);
        }

        if ($oldStatus == Order::DONE and $order->status != Order::DONE) {
            OrderService::make($order->type)->removeBonusesForOrder($order);
        }

        if ($oldStatus != Order::CANCELED and $order->status == Order::CANCELED) {
            OrderService::make($order->type)->resetUsedBonuses($order);
        }
    }
}
