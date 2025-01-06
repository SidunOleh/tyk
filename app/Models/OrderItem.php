<?php

namespace App\Models;

use App\Traits\History;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class OrderItem extends Model
{
    use SoftDeletes, History;

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

    protected $loggable = [
        'quantity',
    ];

    protected $with = [
        'product',
    ];

    protected static function booted(): void
    {
        static::created(function (self $orderItem) {
            $orderItem->order->log("добавлено товар {$orderItem->name}", Auth::user());
        });

        static::updated(function (self $orderItem) {
            $orderItem->order->log("змінено товар {$orderItem->name}", Auth::user(), $orderItem->getUpdates());
        });

        static::deleted(function (self $orderItem) {
            $orderItem->order->log("видалено товар {$orderItem->name}", Auth::user());
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
