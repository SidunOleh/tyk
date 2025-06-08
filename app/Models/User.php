<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Contracts\ILogUser;
use App\Traits\History;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable implements ILogUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, History;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'role',
        'password',
        'phonet_number',
        'history',
        'courier_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'history' => 'array',
        ];
    }

    protected $loggable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'role',
        'password',
    ];

    public const ADMIN = 'адмін';

    public const DISPATCHER = 'диспетчер';

    public const COURIER = 'кур\'єр';

    protected static function booted(): void
    {
        static::created(function (self $user) {
            $user->log('створено', Auth::user());
        });

        static::updated(function (self $user) {
            $user->log('змінено', Auth::user(), $user->getUpdates());
        });

        static::deleted(function (self $user) {
            $user->log('видалено', Auth::user());
        });
    }

    public function scopeRoles(Builder $query, array $roles): void
    {
        if ($roles) {
            $query->whereIn('role', $roles);
        }
    }

    public function scopeSearch(Builder $query, string $s): void
    {
        $query->whereAny([
            'first_name',
            'last_name',
            'phone',
            'email',
        ], 'like', "%{$s}%");
    }

    public function logName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function isAdmin(): bool
    {
        return $this->role == self::ADMIN;
    }

    public function courier(): BelongsTo
    {
        return $this->belongsTo(Courier::class);
    }
}
