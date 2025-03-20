<?php

namespace App\Models;

use App\Traits\History;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Prunable;

class Product extends Model
{
    use SoftDeletes, History, Prunable;

    protected $fillable = [
        'id',
        'name',
        'slug',
        'price',
        'image',
        'description',
        'ingredients',
        'weight',
        'history',
    ];

    protected $casts = [
        'price' => 'float',
        'history' => 'array',
    ];

    protected $loggable = [
        'name',
        'price',
    ];

    public const PLACEHOLDER_IMAGE = '/assets/img/placeholder.webp';

    protected static function booted(): void
    {
        static::created(function (self $product) {
            $product->log('створено', Auth::user());
        });

        static::updated(function (self $product) {
            $product->log('змінено', Auth::user(), $product->getUpdates());
        });

        static::deleted(function (self $product) {
            $product->log('видалено', Auth::user());
        });
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function scopeSearch(Builder $query, string $s): void
    {
        $query->whereAny([
            'name',
        ], 'like', "%{$s}%");
    }

    public function scopeCategories(Builder $query, array $categories): void
    {
        if ($categories) {
            $query->whereHas('categories', fn (Builder $query) => $query->whereIn('categories.id', $categories));
        }
    }

    public function formattedPrice(string $symb = '₴'): string
    {
        return number_format($this->price, 2) . $symb;
    }

    public function imageUrl(): string
    {
        return $this->image ?: asset(self::PLACEHOLDER_IMAGE);
    }
}
