<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;

class PermanentDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'model:permanent-delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permanent delete';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Category::withTrashed()->restore();
        Product::withTrashed()->restore();
    }
}
