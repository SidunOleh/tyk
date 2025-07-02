<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Car extends Model
{
    protected $fillable = [
        'brand',
        'number',
        'mapon_id',
        'owner_id',
    ];

    public function scopeSearch(Builder $query, string $s): void
    {
        $query->whereAny([
            'brand',
            'number',
        ], 'like', "%{$s}%");
    }

    public function owner(): BelongsTo 
    {
        return $this->belongsTo(Courier::class);
    }
}
