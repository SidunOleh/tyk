<?php

namespace App\Models;

use App\Traits\History;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Mavinoo\Batch\Traits\HasBatch;

class Category extends Model
{
    use SoftDeletes, History, HasBatch;

    protected $fillable = [
        'id',
        'name',
        'slug',
        'image',
        'description',
        'parent_id',
        'history',
        'order',
        'visible',
        'upsells',
    ];

    protected $casts = [
        'history' => 'array',
        'order' => 'integer',
        'visible' => 'boolean',
        'upsells' => 'array',
    ];

    protected $loggable = [
        'name',
    ];

    protected $touches = [
        'products',
    ];

    protected static function booted(): void
    {
        static::created(function (self $category) {
            $category->log('створено', Auth::user());
        });

        static::updated(function (self $category) {
            $category->log('змінено', Auth::user(), $category->getUpdates());
        });

        static::deleted(function (self $category) {
            $category->log('видалено', Auth::user());
        });
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function scopeSearch(Builder $query, string $s): void
    {
        $query->whereAny([
            'name',
        ], 'like', "%{$s}%");
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(CategoryTag::class);
    }
}
