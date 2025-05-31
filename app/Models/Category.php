<?php

namespace App\Models;

use App\Traits\History;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Mavinoo\Batch\Traits\HasBatch;
use Staudenmeir\EloquentJsonRelations\Relations\BelongsToJson;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class Category extends Model
{
    use SoftDeletes, History, HasBatch, HasJsonRelationships;

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
        'start_hour',
        'end_hour',
        'schedule',
    ];

    protected $casts = [
        'history' => 'array',
        'order' => 'integer',
        'visible' => 'boolean',
        'upsells' => 'array',
        'start_hour' => 'datetime:H:i:s',
        'end_hour' => 'datetime:H:i:s',
        'schedule' => 'array',
    ];

    protected $loggable = [
        'name',
    ];

    protected $touches = [
        'products',
    ];

    public const PLACEHOLDER_IMAGE = '/assets/img/placeholder.webp';

    public const PACKAGING_NAME = 'Пакування';

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
        $query->whereNull('parent_id')->whereNot('name', Category::PACKAGING_NAME);
    }

    public function scopeParents(Builder $query, array $parents): void
    {
        if ($parents) {
            $query->whereIn('parent_id', $parents);
        }
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(CategoryTag::class);
    }

    public function scopeEstablishment(Builder $query): void
    {
        $query->where('parent_id', null)->whereNot('name', Category::PACKAGING_NAME);
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

    public function isZakald(): bool
    {
        return $this->parent_id === null and $this->name != self::PACKAGING_NAME;
    }

    public function getZaklad(): self
    {
        if ($this->isZakald()) {
            return $this;
        }

        $parent = $this->parent;
        while ($parent->parent !== null) {
            $parent = $parent->parent;
        }

        return $parent;
    }

    public function closed(): bool
    {
        $schedule = $this->isZakald() ? $this->schedule : $this->getZaklad()->schedule;

        if (! $schedule) {
            return true;
        }

        $day = $schedule[now()->dayOfWeekIso-1];

        if (! $day['start'] or ! $day['end']) {
            return true;
        }

        $start = Carbon::createFromFormat('H:i', $day['start']);
        $end = Carbon::createFromFormat('H:i', $day['end']);

        if (now()->lt($start) or now()->gt($end)) {
            return true;
        }

        return false;
    }
}
