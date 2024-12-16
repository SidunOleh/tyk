<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'price',
        'image',
        'description',
        'ingredients',
        'weight',
    ];

    protected $casts = [
        'price' => 'float',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function scopeSearch(Builder $query, string $s): void
    {
        $query->whereAny([
            'name',
            'price',
            'description',
            'ingredients',
            'weight',
        ], 'like', "%{$s}%");
    }

    public function scopeCategories(Builder $query, array $categories): void
    {
        if (! $categories) {
            return;
        }

        $query->whereHas('categories', fn (Builder $query) => $query->whereIn('categories.id', $categories));
    }
}
