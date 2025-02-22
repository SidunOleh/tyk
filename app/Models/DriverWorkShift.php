<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    ];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
        'exchange_office' => 'float',
        'returned_amount' => 'float',
        'food_shipping_count' => 'integer',
        'shipping_count' => 'integer',
        'taxi_count' => 'integer',
        'food_shipping_total' => 'float',
        'shipping_total' => 'float',
        'taxi_total' => 'float',
        'additional_costs' => 'float',
    ];

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
}
