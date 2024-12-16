<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'subtotal',
        'shipping_price',
        'bonuses',
        'total',
        'time',
        'notes',
        'status',
        'details_id',
        'details_type',
        'client_id',
    ];

    protected $casts = [
        'subtotal' => 'float',
        'shipping_price' => 'float',
        'bonuses' => 'float',
        'total' => 'float',
        'time' => 'datetime',
    ];

    public function details(): MorphTo
    {
        return $this->morphTo();
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function updateAmount(): bool
    {
        $subtotal = $this->orderItems->reduce(function (float $carry, OrderItem $orderItem) {
            return $carry + $orderItem->amount * $orderItem->quantity;
        }, 0);

        $total = $subtotal + $this->shipping_price - $this->bonuses;

        return $this->update([
            'subtotal' => $subtotal,
            'total' => $total,
        ]);
    }
}
