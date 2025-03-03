<?php

namespace App\Listeners;

use App\Events\DriverWorkShiftClosed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use TelegramBot\Api\Client;

class SendToTgDriverWorkShiftStat
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
    public function handle(DriverWorkShiftClosed $event): void
    {
        $courier = $event->driverWorkShift->courier;

        if (! $courier->chat_id) {
            return;
        }

        $driverWorkShift = $event->driverWorkShift;
        
        $text = $driverWorkShift->start->format('d.m.Y H:i')." - ".$driverWorkShift->end->format('d.m.Y H:i')."
        
<b>Доставка їжі:</b> 
к-сть - {$driverWorkShift->food_shipping_count}, сума - ".number_format($driverWorkShift->food_shipping_total, 2)." грн
<b>Кур'єр:</b> 
к-сть - {$driverWorkShift->shipping_count}, сума - ".number_format($driverWorkShift->shipping_total, 2)." грн
<b>Таксі:</b> 
к-сть - {$driverWorkShift->taxi_count}, сума - ".number_format($driverWorkShift->taxi_total, 2)." грн";

        (new Client(config('services.tg.bot_token')))->sendMessage($courier->chat_id, $text, 'html');
    }
}
