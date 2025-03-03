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
        
        $text = view('tg.driver-work-shift', [
            'driverWorkShift' => $event->driverWorkShift,
        ])->render();

        (new Client(config('services.tg.bot_token')))->sendMessage($courier->chat_id, $text, 'html');
    }
}
