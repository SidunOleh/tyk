<?php

namespace App\Console\Commands;

use App\Models\Client;
use Illuminate\Console\Command;

class ReturnDeletedClients extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'return-deleted-clients';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Return deleted clients';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Client::onlyTrashed()->restore();
    }
}
