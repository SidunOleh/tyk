<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ImportCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import product categories';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $file = fopen(storage_path('product_categories.csv'), 'r');
        if (! $file) {
            $this->error('Can\'t open file.');
            return;
        }

        $data = [];
        while (($line = fgetcsv($file, null, ',')) !== false) {
            $data[] = $line;
        }
        unset($data[0]);

        $this->import($data, 0);
    }

    private function import(array $data, int $parent)
    {
        foreach ($data as $line) {
            if ($line[5] == $parent) {
                Category::upsert([[
                    'id' => $line[0],
                    'name' => $line[1],
                    'slug' => $line[2],
                    'image' => $line[6] ? $this->uploadImage($line[6]) : null,
                    'description' => $line[3],
                    'parent_id' => $line[5] == 0 ? null : $line[5],
                ],], uniqueBy: ['id'], update: ['name', 'slug', 'image', 'description', 'parent_id',]);

                $this->info('upsert ' . $line[1]);
                
                $this->import($data, $line[0]);
            }
        }
    }

    private function uploadImage(string $url): string
    {
        $ext = pathinfo(parse_url($url)['path'], PATHINFO_EXTENSION);
        $name = md5($url) . '.' . $ext;
        $path = "/storage/{$name}";

        if (Storage::exists($name)) {
            return $path;
        }

        $response = Http::get($url);

        Storage::put($name, $response->getBody()->getContents());

        return $path;
    }
}
