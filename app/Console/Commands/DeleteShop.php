<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;

class DeleteShop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shop:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete shop';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Product::getQuery()->delete();
        Category::getQuery()->delete();
    }
}
