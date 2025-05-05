<?php

namespace App\Models;

use App\Traits\History;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Courier extends Model
{
    use SoftDeletes, History;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'tg',
        'vehicles',
        'tg_key',
        'chat_id',
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

    protected $appends = [
        'tg_link',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $courier) {
            $courier->tg_key = self::generateTgKey();
        });

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

    public static function generateTgKey(): string
    {
        do {
            $key = Str::random(10);
        } while (Courier::firstWhere('tg_key', $key));

        return $key;
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

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $attributes['first_name'] . ' ' . $attributes['last_name'],
        );
    }

    protected function tgLink(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => 'https://t.me/'.config('services.tg.bot_username').'?start='.$attributes['tg_key'],
        );
    }

    public function scopeVehicles(Builder $query, array $vehicles): void
    {
        if ($vehicles) {
            $query->whereJsonContains('vehicles', $vehicles);
        }
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    } 
}
