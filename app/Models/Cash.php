<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
    protected $fillable = [
        'received',
        'returned',
        'courier_id',
    ];

    protected $casts = [
        'received' => 'float',
        'returned' => 'float',
    ];
}
