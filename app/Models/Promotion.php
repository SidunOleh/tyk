<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'image',
        'title',
        'slug',
        'subtitle',
        'text',
    ];

    public function scopeSearch(Builder $query, string $s): void
    {
        $query->whereAny([
            'title',
        ], 'like', "%{$s}%");
    }
}
