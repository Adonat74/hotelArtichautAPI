<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'password',
        'firstname',
        'lastname',
        'address',
        'city',
        'postal_code',
        'phone',
        'role_id',
        'is_pro',
        'is_vip',
        'token_version'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [
            'token_version' => $this->token_version,
            'id' => $this->id,
            'role_id' => $this->role_id,
            'is_pro' => $this->is_pro,
            'is_vip' => $this->is_vip,
        ];
    }


    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }


}
