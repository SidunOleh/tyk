<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mavinoo\Batch\Traits\HasBatch;

class CategoryTag extends Model
{
    use HasBatch;

    protected $fillable = [
        'name',
        'image',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];
}
