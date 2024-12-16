<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class ShippingDetails extends Model
{
    protected $table = 'shipping_details';

    protected $fillable = [
        'from',
        'to',
    ];

    protected $casts = [
        'to' => 'array',
    ];

    public function order(): MorphOne
    {
        return $this->morphOne(Order::class, 'details');
    }
}
