<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class DeleteOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete orders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Order::getQuery()->delete();
    }
}
