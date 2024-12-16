<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'phone',
        'first_name',
        'last_name',
        'addresses',
        'bonuses',
    ];

    protected $casts = [
        'addresses' => 'array',
        'bonuses' => 'float',
    ];

    public function scopeSearch(Builder $query, string $s): void
    {
        $query->whereAny([
            'phone',
            'first_name',
            'last_name',
        ], 'like', "%{$s}%");
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
