<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class ImportProductSlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:product-slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products slug';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $file = fopen(storage_path('products.csv'), 'r');
        if (! $file) {
            $this->error('Can\'t open file.');
            return;
        }

        $i = 0;
        while (($line = fgetcsv($file, null, ',')) !== false) {
            if ($i++ == 0) {
                continue;
            }

            if (! $line[1]) {
                $this->warn('Slug is empty');
                continue;
            }

            $product = Product::find($line[3]);
            
            $product->update(['slug' => $line[1]]);

            $this->info('update slug for ' . $product->name);
        }
    }
}
