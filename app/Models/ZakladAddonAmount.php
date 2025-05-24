<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ZakladAddonAmount extends Model
{
    protected $fillable = [
        'zaklad_id',
        'order_id',
        'amount',
    ];

    protected $casts = [
        'amount' => 'float',
    ];

    public function zaklad(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'zaklad_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
