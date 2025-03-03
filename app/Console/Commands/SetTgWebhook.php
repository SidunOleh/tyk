<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SetTgWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tg:webhook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set tg webhook';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $response = Http::post('https://api.telegram.org/bot'.config('services.tg.bot_token').'/setWebhook?url='.config('services.tg.bot_webhook'));

        $data = $response->json();

        if (! $data['ok']) {
            throw new Exception($data['description']);
        }
    }
}
