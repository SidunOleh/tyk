<?php

namespace App\Models;

use App\Exceptions\UnexpectedTariffTypeException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    protected $fillable = [
        'name',
        'type',
        'fixed_price',
        'fixed_up_to_km',
        'per_km',
        'color',
        'default',
    ];

    protected $casts = [
        'fixed_price' => 'float',
        'fixed_up_to_km' => 'float',
        'per_km' => 'float',
        'default' => 'boolean',
    ];

    public const FIXED = 'Фіксований';

    public const PER_KM = 'За км';

    public const MIXED = 'Змішаний';

    public function scopeSearch(Builder $query, string $s): void
    {
        $query->whereAny([
            'name',
        ], 'like', "%{$s}%");
    }

    public function calcPrice(float $km = 0): int
    {
        if ($this->type == Tariff::FIXED) {
            return (int) $this->fixed_price;
        } elseif ($this->type == Tariff::PER_KM) {
            return (int) $this->per_km * $km;
        } elseif ($this->type == Tariff::MIXED) {
            if ($km > $this->fixed_up_to_km) {
                return (int) $this->per_km * $km;
            } else {
                return (int) $this->fixed_price;
            }
        } else {
            throw new UnexpectedTariffTypeException();
        }
    }

    public static function getDefault(): ?self
    {
        return self::where('default', true)->firstOrFail();
    }
}
