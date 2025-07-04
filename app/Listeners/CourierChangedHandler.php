<?php

namespace App\Listeners;

use App\Events\CourierChanged;
use App\Models\OrderStage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CourierChangedHandler
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
    public function handle(CourierChanged $event): void
    {
        $event->order->refresh();
        
        if ($event->prevCourier?->id and $event->prevCourier->id != $event->order->courier?->id) {
            OrderStage::create([
                'order_id' => $event->order->id,
                'courier_id' => $event->prevCourier->id,
                'stage' => 'changed',
            ]);
        }
        
        if ($event->order->courier?->id and $event->prevCourier?->id != $event->order->courier->id) {
            OrderStage::create([
                'order_id' => $event->order->id,
                'courier_id' => $event->order->courier->id,
                'stage' => 'set',
            ]);
        }
    }
}
