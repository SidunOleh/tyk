<?php

namespace App\Models;

use App\Contracts\ILogUser;
use App\Exceptions\NotEnoughBonusesException;
use App\Traits\History;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable implements ILogUser
{
    use SoftDeletes, History;
    
    protected $fillable = [
        'phone',
        'full_name',
        'addresses',
        'description',
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
        'full_name',
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

    public function scopeSearch(Builder $query, string $s): void
    {
        $query->whereAny([
            'phone',
            'full_name',
        ], 'like', "%{$s}%");
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function ordersByDate(): HasMany
    {
        return $this->hasMany(Order::class)->orderBy('created_at', 'desc');
    }

    public function formattedBonuses(string $symb = '₴'): string
    {
        return number_format($this->bonuses, 2) . $symb;
    }

    public function logName(): string
    {
        return $this->full_name ?? $this->phone;
    }

    public function addAddresses(array $addresses): void
    {
        $new = [];
        foreach ($addresses ?? [] as $address) {
            if (! $this->hasAddress($address)) {
                $new[] = $address;
            }
        }

        if ($new) {
            $this->update(['addresses' => array_merge($new, $this->addresses ?? [])]);
        }
    }

    public function hasAddress(array $address): bool
    {
        foreach ($this->addresses ?? [] as $val) {
            if ($val['address'] == $address['address']) {
                return true;
            }
        }

        return false;
    }

    public function hasEnouphBonuses($amount): bool
    {
        return $this->bonuses >= $amount;
    }

    public function addBonus(float $amount): bool
    {
        return $this->update(['bonuses' => $this->bonuses + $amount]);
    }

    public function removeBonus(float $amount, bool $canBeMinus = false): bool
    {
        if ($amount > $this->bonuses and ! $canBeMinus) {
            throw new NotEnoughBonusesException('client ' . $this->id);
        }

        return $this->update(['bonuses' => $this->bonuses - $amount]);
    }
}
