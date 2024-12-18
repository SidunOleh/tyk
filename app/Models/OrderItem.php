<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'quantity',
        'amount',
        'order_id',
        'product_id',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'amount' => 'float',
    ];

    protected static function booted(): void
    {
        static::created(function (self $orderItem) {
            $orderItem->order->updateAmount();
        });

        static::updated(function (self $orderItem) {
            $orderItem->order->updateAmount();
        });

        static::deleted(function (self $orderItem) {
            $orderItem->order->updateAmount();
        });
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
