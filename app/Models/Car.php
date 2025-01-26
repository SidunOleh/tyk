<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'brand',
        'number',
        'mapon_id',
    ];

    public function scopeSearch(Builder $query, string $s): void
    {
        $query->whereAny([
            'brand',
            'number',
        ], 'like', "%{$s}%");
    }
}
