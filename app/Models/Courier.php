<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Courier extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'tg',
        'vehicles',
    ];

    protected $casts = [
        'vehicles' => 'array',
    ];

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
        if (! $vehicles) {
            return;
        }

        $query->whereJsonContains('vehicles', $vehicles);
    }

    public function cashes(): HasMany
    {
        return $this->hasMany(Cash::class);
    }
}
