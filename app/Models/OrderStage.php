<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderStage extends Model
{
    protected $fillable = [
        'order_id',
        'courier_id',
        'stage',
    ];

    protected $appends = [
        'stage_value',
    ];

    public const STATUS = [
        'set' => 'Поставлено на кур\'єра',
        'changed' => 'Змінено кур\'єра',
    ];

    protected function stageValue(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => self::STATUS[$attributes['stage']],
        );
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function courier(): BelongsTo
    {
        return $this->belongsTo(Courier::class);
    }
}
