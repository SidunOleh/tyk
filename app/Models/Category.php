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
use Staudenmeir\EloquentJsonRelations\Relations\BelongsToJson;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
use Illuminate\Database\Eloquent\Prunable;

class Category extends Model
{
    use SoftDeletes, History, HasBatch, HasJsonRelationships, Prunable;

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

    public const PLACEHOLDER_IMAGE = '/assets/img/placeholder.webp';

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

    public function scopeZaklad(Builder $query): void
    {
        $query->whereNull('parent_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(CategoryTag::class);
    }

    public function scopeEstablishment(Builder $query): void
    {
        $query->where('parent_id', null);
    }

    public function scopeVisible(Builder $query): void
    {
        $query->where('visible', true);
    }

    public function imageUrl(): string
    {
        return $this->image ?: asset(self::PLACEHOLDER_IMAGE);
    }

    public function upsells(): BelongsToJson
    {
        return $this->belongsToJson(Product::class, 'upsells');
    }

    public function prunable()
	{
		return static::whereNotNull('deleted_at');
	}
}
