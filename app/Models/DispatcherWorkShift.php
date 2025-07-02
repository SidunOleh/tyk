<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DispatcherWorkShift extends Model
{
    protected $fillable = [
        'status',
        'start',
        'end',
        'work_shift_id',
        'dispatcher_id',
        'food_shipping_count',
        'shipping_count',
        'taxi_count',
        'food_shipping_total',
        'shipping_total',
        'taxi_total',
    ];

    protected $casts = [
        'start' => 'datetime:Y-m-d H:i:s',
        'end' => 'datetime:Y-m-d H:i:s',
        'food_shipping_count' => 'integer',
        'shipping_count' => 'integer',
        'taxi_count' => 'integer',
        'food_shipping_total' => 'float',
        'shipping_total' => 'float',
        'taxi_total' => 'float',
    ];

    public const OPEN = 'open';

    public const CLOSE = 'close';

    public function dispatcher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dispatcher_id');
    }

    public function workShift(): BelongsTo
    {
        return $this->belongsTo(WorkShift::class);
    }
}
