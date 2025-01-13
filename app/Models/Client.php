<?php

namespace App\Models;

use App\Traits\History;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{
    use SoftDeletes, History;
    
    protected $fillable = [
        'phone',
        'first_name',
        'last_name',
        'addresses',
        'bonuses',
        'code',
        'history',
    ];

    protected $casts = [
        'addresses' => 'array',
        'bonuses' => 'float',
        'history' => 'array',
    ];

    protected $loggable = [
        'phone',
        'first_name',
        'last_name',
        'addresses',
    ];

    protected static function booted(): void
    {
        static::created(function (self $client) {
            $client->log('створено', Auth::user());
        });

        static::updated(function (self $client) {
            $client->log('змінено', Auth::user(), $client->getUpdates());
        });

        static::deleted(function (self $client) {
            $client->log('видалено', Auth::user());
        });
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $attributes['first_name'] . ' ' . ($attributes['last_name'] ?? ''),
        );
    }

    public function scopeSearch(Builder $query, string $s): void
    {
        $query->whereAny([
            'phone',
            'first_name',
            'last_name',
        ], 'like', "%{$s}%");
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
