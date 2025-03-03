<?php

namespace App\Http\Controllers\Tg;

use App\Http\Controllers\Controller;
use App\Tg\Commands\StartCommand;
use Closure;
use TelegramBot\Api\Client;

class HandlerController extends Controller
{
    public function __construct()
    {
        
    }

    public function __invoke()
    {
        $bot = new Client(config('services.tg.bot_token'));

        $bot->command('start', Closure::fromCallable([
            new StartCommand($bot), 
            'handle'
        ]));
        
        $bot->run();
    }
}
