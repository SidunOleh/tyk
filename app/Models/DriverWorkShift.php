<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class DriverWorkShift extends Model
{
    protected $fillable = [
        'status',
        'start',
        'end',
        'courier_id',
        'work_shift_id',
        'car_id',
        'exchange_office',
        'returned_amount',
        'food_shipping_count',
        'shipping_count',
        'taxi_count',
        'food_shipping_total',
        'shipping_total',
        'taxi_total',
        'additional_costs',
        'approximate_end',
    ];

    protected $casts = [
        'start' => 'datetime:Y-m-d H:i:s',
        'end' => 'datetime:Y-m-d H:i:s',
        'exchange_office' => 'float',
        'returned_amount' => 'float',
        'food_shipping_count' => 'integer',
        'shipping_count' => 'integer',
        'taxi_count' => 'integer',
        'food_shipping_total' => 'float',
        'shipping_total' => 'float',
        'taxi_total' => 'float',
        'additional_costs' => 'float',
        'approximate_end' => 'datetime:Y-m-d H:i:s',
    ];

    public const OPEN = 'open';

    public const CLOSE = 'close';

    public function courier(): BelongsTo
    {
        return $this->belongsTo(Courier::class);
    }

    public function workShift(): BelongsTo
    {
        return $this->belongsTo(WorkShift::class);
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function scopeOpen(Builder $query): void
    {
        $query->where('status', self::OPEN);
    }

    public function scopeClose(Builder $query): void
    {
        $query->where('status', self::CLOSE);
    }

    public function scopeCourier(Builder $query, Courier $courier): void
    {
        $query->where('courier_id', $courier->id);
    }
}
