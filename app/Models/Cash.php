<?php

namespace App\Models;

use App\Traits\History;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Cash extends Model
{
    use History;

    protected $fillable = [
        'received',
        'returned',
        'courier_id',
    ];

    protected $casts = [
        'received' => 'float',
        'returned' => 'float',
    ];

    protected $loggable = [
        'received',
        'returned',
    ];

    protected static function booted(): void
    {
        static::created(function (self $cash) {
            $cash->courier->log('створено касу', Auth::user());
        });

        static::updated(function (self $cash) {
            $cash->courier->log('змінено касу за ' . $cash->created_at->format('d.m.Y'), Auth::user(), $cash->getUpdates());
        });

        static::deleted(function (self $cash) {
            $cash->courier->log('видалено касу за ' . $cash->created_at->format('d.m.Y'), Auth::user());
        });
    }

    public function courier(): BelongsTo
    {
        return $this->belongsTo(Courier::class);
    }
}
