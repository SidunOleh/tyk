<?php

namespace App\Models;

use App\Traits\History;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'packaging_for',
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

    protected $appends = [
        'packagingAmount',
    ];

    protected function getPackagingAmountAttribute(): float
    {
        return (float) $this->packaging->reduce(fn (float $carry, $orderItem) => $carry + $orderItem->amount * $orderItem->quantity, 0);
    }

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

            $orderItem->packaging()->delete();
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

    public function packagingFor(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class, 'packaging_for');
    }

    public function packaging(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'packaging_for');
    }
}
