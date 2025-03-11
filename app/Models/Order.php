<?php

namespace App\Models;

use App\Services\Orders\OrderService;
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
        // 'details',
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

    protected static function booted(): void
    {
        static::creating(function (self $order) {
            $day = now()->format('d');
            
            $count = Order::whereDate('created_at', now()->format('Y-m-d'))->count() + 1;
            $count = str_pad($count, 3, '0', STR_PAD_LEFT);

            $order->number = "{$day}{$count}";
        });

        static::created(function (self $order) {
            $order->log('створено', Auth::user());
        });

        static::updated(function (self $order) {
            if ($order->status == Order::DONE and $order->getOriginal('status') != Order::DONE) {
                OrderService::make($order->type)->addBonusToClient($order);
            }
    
            if ($order->status != Order::DONE and $order->getOriginal('status') == Order::DONE) {
                OrderService::make($order->type)->removeBonusFromClient($order);
            }

            $order->log('змінено', Auth::user(), $order->getUpdates());
        });

        static::deleted(function (self $order) {
            $order->log('видалено', Auth::user());
        });
    }

    public function getUpdates(): array
    {
        $data = [];
        foreach ($this->loggable as $field) {
            if (
                ($field != 'details' and $this->wasChanged($field)) or
                ($field == 'details' and $this->wereDetailsChanged())
            ) {
                if ($field == 'details') {
                    $prev = [];
                    foreach ($this->getOriginal('details') as $name => $val) {
                        $prev[] = __('validation.attributes.'.$name) . ' - ' . implode(', ', array_map(fn (array $address) => $address['address'], $val ?? []));
                    }
                    $prev = implode(', ', $prev);

                    $curr = [];
                    foreach ($this->details as $name => $val) {
                        $curr[] =  __('validation.attributes.'.$name) . ' - ' . implode(', ', array_map(fn (array $address) => $address['address'], $val ?? []));
                    }
                    $curr = implode(', ', $curr);

                    $data['деталі'] = "з {$prev} на {$curr}";
                } elseif ($field == 'client_id') {
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

    protected function wereDetailsChanged(): bool
    {
        $prev = $this->getOriginal('details');
        $curr = $this->details;
        ksort($prev);
        ksort($curr);
        
        return json_encode($prev) != json_encode($curr);
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
        return $this->hasMany(OrderItem::class);
    }

    public function updateAmount(): bool
    {
        $this->refresh();

        $subtotal = $this->orderItems->reduce(function (float $carry, OrderItem $orderItem) {
            return $carry + $orderItem->amount * $orderItem->quantity;
        }, 0);

        $total = $subtotal + $this->shipping_price + $this->additional_costs;

        return $this->updateQuietly([
            'subtotal' => $subtotal,
            'total' => $total,
        ]);
    }

    public function courier(): BelongsTo
    {
        return $this->belongsTo(Courier::class);
    }

    public function totalFormatted(string $symb = '₴'): string
    {
        return number_format($this->total, 2) . $symb;
    }
    
    public function bonusesFormatted(string $symb = '₴'): string
    {
        return number_format($this->bonuses, 2) . $symb;
    } 
}
