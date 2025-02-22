<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ZakladReport extends Model
{
    protected $fillable = [
        'category_id',
        'work_shift_id',
        'total',
        'returned_amount',
        'payment_method',
        'comment',
    ];

    protected $casts = [
        'total' => 'float',
        'returned_amount' => 'float',
    ];

    public function zaklad(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function workShift(): BelongsTo
    {
        return $this->belongsTo(WorkShift::class);
    }
}
