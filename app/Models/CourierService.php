<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CourierService extends Model
{
    protected $fillable = [
        'name',
        'price',
        'visibility',
    ];

    protected $casts = [
        'price' => 'float',
        'visibility' => 'boolean',
    ];

    public function scopeVisible(Builder $query)
    {
        $query->where('visibility', true);
    }
}
