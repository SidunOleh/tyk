<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    protected $fillable = [
        'name',
        'fixed',
        'fixed_price',
        'per_km',
        'color',
        'default',
    ];

    protected $casts = [
        'fixed' => 'boolean',
        'fixed_price' => 'float',
        'per_km' => 'float',
        'default' => 'boolean',
    ];

    public function scopeSearch(Builder $query, string $s): void
    {
        $query->whereAny([
            'name',
        ], 'like', "%{$s}%");
    }

    public function calcPrice(float $km = 0): int
    {
        if ($this->fixed) {
            return (int) $this->fixed_price;
        } else {
            return (int) $this->per_km * $km;
        }
    }

    public static function getDefault(): ?self
    {
        return self::where('default', true)->firstOrFail();
    }
}
