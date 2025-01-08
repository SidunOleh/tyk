<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $file = fopen(storage_path('products\'.csv'), 'r');
        if (! $file) {
            $this->error('Can\'t open file.');
            return;
        }

        $i = 0;
        while (($line = fgetcsv($file, null, ',')) !== false) {
            if ($i++ == 0) {
                continue;
            }

            $product = $this->upsert($line);

            $this->info('upsert ' . $product->name);
        }
    }

    private function upsert(array $data): Product
    {
        $product = Product::find($data[0]);

        $productData = [
            'id' => $data[0],
            'image' => $data[29] ? $this->uploadImage($data[29]) : null,
            'name' => $this->extractName($data[3]),
            // 'slug' => $this->makeSlug($data[3]),
            'slug' => $data[0],
            'price' => (float) $data[25],
            'ingredients' => $this->extractIngredients($data),
            'weight' => $this->extractWeight($data[3]),
        ];

        if ($product) {
            $product->update($productData);
        } else {
            $product = Product::create($productData);
        }

        $catIds = $this->getCatIds($data[26]);

        $product->categories()->sync($catIds);

        return $product;
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

    private function extractName(string $name): string
    {
        $arr = explode(' | ', $name);

        return preg_replace('/<br><div class="ingradient">.*?<\/div>/', '', $arr[0]);
    }

    private function makeSlug(string $name): string
    {
        $slug = Str::slug($name);
        $i = 1;
        while (true) {
            $exists = Product::where('slug', $slug . ($i == 1 ? '' : "-{$i}"))->exists();

            if (! $exists) {
                break;
            }

            $i++;
        }

        return $slug . ($i == 1 ? '' : "-{$i}");
    }

    private function extractIngredients(array $data): string
    {
        if ($data[8]) {
            return strip_tags($data[8]);
        } elseif ($data[7]) {
            return strip_tags($data[7]);
        } else {
            preg_match('/<div class="ingradient">(.*?)<\/div>/', $data[3], $matches);

            return $matches[1] ?? '';
        }
    }

    private function extractWeight(string $name): string
    {
        $arr = explode('|', $name);

        return preg_replace('/<br><div class="ingradient">.*?<\/div>/', '', $arr[1] ?? '');
    }

    private function getCatIds(string $catStr): array
    {
        $ids = [];
        $cats = explode(', ', $catStr);
        foreach ($cats as $cat) {
            $cat = explode(' > ', $cat);
            $parentId = null; 
            $lastCat = null;
            foreach ($cat as $parentCat) {
                $lastCat = Category::where([
                    'name' => $parentCat,
                    'parent_id' => $parentId,
                ])->first();

                if (! $lastCat) {
                    break;
                }
        
                $parentId = $lastCat->id;
            }

            if ($lastCat) {
                $ids[] = $lastCat->id;
            }

            $parentId = null;
        }

        return $ids;
    }
}
