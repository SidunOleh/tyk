<?php

namespace App\Models;

use App\Traits\History;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    use SoftDeletes, History;

    protected $fillable = [
        'number',
        'type',
        'subtotal',
        'shipping_price',
        'additional_costs',
        'add_bonuses',
        'bonuses',
        'total',
        'time',
        'duration',
        'notes',
        'status',
        'paid',
        'payment_method',
        'details',
        'client_id',
        'courier_id',
        'user_id',
        'reviewed',
        'history',
    ];

    protected $casts = [
        'subtotal' => 'float',
        'additional_costs' => 'float',
        'shipping_price' => 'float',
        'bonuses' => 'float',
        'add_bonuses' => 'float',
        'total' => 'float',
        'time' => 'datetime',
        'duration' => 'integer',
        'paid' => 'boolean',
        'details' => 'array',
        'reviewed' => 'boolean',
        'history' => 'array',
    ];   
    
    protected $loggable = [
        'type',
        'subtotal',
        'shipping_price',
        'additional_costs',
        'bonuses',
        'total',
        'time',
        'duration',
        'notes',
        'status',
        'paid',
        'payment_method',
        'client_id',
        'courier_id',
    ];

    protected $with = [
        'orderItems',
    ];

    public const FOOD_SHIPPING = 'Доставка їжі';

    public const SHIPPING = 'Кур\'єр';

    public const TAXI = 'Таксі';
    
    public const CREATED = 'Створено';

    public const COOKING = 'Готується';

    public const DELIVERING = 'Доставляється';

    public const DONE = 'Виконано';

    public const CANCELED = 'Скасовано';

    public const CASH = 'Готівка';

    public const CARD = 'Карта';

    public const SPEND_BONUS_AMOUNT = 50;

    public const DEFAULT_DURATION = 30;

    protected static function booted(): void
    {
        static::creating(function (self $order) {
            $order->number = self::makeOrderNumber();
        });

        static::created(function (self $order) {
            $order->log('створено', Auth::user());
        });

        static::updated(function (self $order) {
            $order->log('змінено', Auth::user(), $order->getUpdates());
        });

        static::deleted(function (self $order) {
            $order->log('видалено', Auth::user());
        });
    }

    public static function makeOrderNumber(): string
    {
        $day = now()->format('d');
            
        $count = Order::whereDate('created_at', now()->format('Y-m-d'))->count() + 1;
        $count = str_pad($count, 3, '0', STR_PAD_LEFT);

        return "{$day}{$count}";
    }

    public function getUpdates(): array
    {
        $data = [];
        foreach ($this->loggable as $field) {
            if ($this->wasChanged($field)) {
                if ($field == 'client_id') {
                    $data[__('validation.attributes.'.$field)] = 
                        'з ' . Client::find($this->getOriginal('client_id'))->fullName . ' на ' . $this->client->fullName;
                } elseif ($field == 'courier_id') {
                    $data[__('validation.attributes.'.$field)] = 
                        'з ' . (Courier::find($this->getOriginal('courier_id'))?->fullName ?? '_') . ' на ' . ($this->courier?->fullName ?? '_');
                } else {
                    $data[__('validation.attributes.'.$field)] = 
                        'з ' . ($this->formatValue($this->getOriginal($field)) ?? '_') . ' на ' . ($this->formatValue($this->{$field}) ?? '_');
                }
            }
        }

        return $data;
    }

    public function scopeSearch(Builder $query, string $s): void
    {
        $query->whereAny([
            'type',
            'notes',
        ], 'like', "%{$s}%");
    }

    public function scopeTypes(Builder $query, array $types): void
    {
        if ($types) {
            $query->whereIn('type', $types);
        }
    }

    public function scopePaid(Builder $query, array $paid): void
    {
        if ($paid) {
            $query->whereIn('paid', $paid);
        }
    }

    public function scopeStatuses(Builder $query, array $statuses): void
    {
        if ($statuses) {
            $query->whereIn('status', $statuses);
        }
    }

    public function scopeBetweenDate(Builder $query, string $start, string $end): void
    {
        $query->whereRaw('DATE(created_at) BETWEEN ? AND ?', [$start, $end]);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class)->whereNull('packaging_for');
    }

    public function allOrderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function courier(): BelongsTo
    {
        return $this->belongsTo(Courier::class);
    }

    public function updateAmount(): bool
    {
        $subtotal = $this->allOrderItems->reduce(function (float $carry, OrderItem $orderItem) {
            return $carry + $orderItem->amount * $orderItem->quantity;
        }, 0);

        $total = $subtotal + $this->shipping_price + $this->additional_costs;

        return $this->updateQuietly([
            'subtotal' => $subtotal,
            'total' => $total,
        ]);
    }

    public function useBonuses(): bool
    {
        if (! $this->client->hasEnouphBonuses(self::SPEND_BONUS_AMOUNT)) {
            return false;
        }

        $bonuses = $this->total < self::SPEND_BONUS_AMOUNT ? $this->total : self::SPEND_BONUS_AMOUNT;
        
        $this->client->removeBonus($bonuses);

        return $this->update(['bonuses' => $bonuses]);
    }
}
