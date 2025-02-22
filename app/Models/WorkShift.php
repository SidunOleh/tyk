<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class WorkShift extends Model
{
    protected $fillable = [
        'status',
        'start',
        'end',
        'food_shipping_count',
        'shipping_count',
        'taxi_count',
        'food_shipping_total',
        'shipping_total',
        'taxi_total',
    ];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    public function drivers(): HasMany
    {
        return $this->hasMany(DriverWorkShift::class, 'work_shift_id');
    }

    public function zakladyReports(): HasMany
    {
        return $this->hasMany(ZakladReport::class);
    }

    public function scopeOpen(Builder $query): void
    {
        $query->where('status', 'open');
    }

    public function scopeClose(Builder $query): void
    {
        $query->where('status', 'close');
    }

    public function allDriversWorkShiftsClosed(): bool
    {
        foreach ($this->drivers as $driver) {
            if ($driver->status == 'open') {
                return false;
            }
        }

        return true;
    }

    public function scopeSearch(Builder $query, string $s): void
    {
        $query->whereAny([
            'status',
        ], 'like', "%{$s}%");
    }
}
