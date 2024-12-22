<?php

namespace App\Models;

use App\Traits\History;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{
    use SoftDeletes, History;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
        'parent_id',
        'history',
    ];

    protected $casts = [
        'history' => 'array',
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
            'description',
        ], 'like', "%{$s}%");
    }
}
