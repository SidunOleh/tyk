<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class FoodShippingDetails extends Model
{
    use SoftDeletes;

    protected $table = 'food_shipping_details';

    protected $fillable = [
        'to',
        'cook_time',
    ];

    protected $casts = [
        'cook_time' => 'datetime',
    ];

    public function order(): MorphOne
    {
        return $this->morphOne(Order::class, 'details');
    }
}
