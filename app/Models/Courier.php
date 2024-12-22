<?php

namespace App\Models;

use App\Traits\History;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Courier extends Model
{
    use SoftDeletes, History;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'tg',
        'vehicles',
        'history',
    ];

    protected $casts = [
        'vehicles' => 'array',
        'history' => 'array',
    ];

    protected $loggable = [
        'first_name',
        'last_name',
        'phone',
        'tg',
        'vehicles',
    ];

    protected static function booted(): void
    {
        static::created(function (self $courier) {
            $courier->log('створено', Auth::user());
        });

        static::updated(function (self $courier) {
            $courier->log('змінено', Auth::user(), $courier->getUpdates());
        });

        static::deleted(function (self $courier) {
            $courier->log('видалено', Auth::user());
        });
    }

    public function scopeSearch(Builder $query, string $s): void
    {
        $query->whereAny([
            'first_name',
            'last_name',
            'phone',
            'tg',
            'vehicles',
        ], 'like', "%{$s}%");
    }

    public function scopeVehicles(Builder $query, array $vehicles): void
    {
        if ($vehicles) {
            $query->whereJsonContains('vehicles', $vehicles);
        }
    }

    public function cashes(): HasMany
    {
        return $this->hasMany(Cash::class);
    }
}
