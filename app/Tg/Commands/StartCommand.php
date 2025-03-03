<?php

namespace App\Tg\Commands;

use App\Models\Courier;
use TelegramBot\Api\Client;

class StartCommand
{
    public function __construct(
        public Client $client
    )
    {
        
    }

    public function handle($message)
    {
        $key = trim(str_replace('/start', '', $message->getText()));

        $courier = Courier::firstWhere('tg_key', $key);

        if ($courier) {
            $courier->update(['chat_id' => $message->getChat()->getId()]);

            $response = "Вітаю, {$courier->first_name} {$courier->last_name}.";
        } else {
            $response = 'Не знайдено.';
        }

        $this->client->sendMessage($message->getChat()->getId(), $response);
    }
}