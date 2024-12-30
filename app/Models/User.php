<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'latitude',
        'longitude',
        'address',
        'city',
        'status',
        'role',
        'image',
        'expo_push_token',
        'points',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userCart()
    {
        return $this->hasMany(Cart::class, 'customer_id', 'id');
    }

    public function factorCart()
    {
        return $this->hasMany(Cart::class, 'factor_id', 'id');
    }

    public function userRating()
    {
        return $this->hasMany(UserRating::class, 'user_id');
    }

    public function factorRating()
    {
        return $this->hasMany(UserRating::class, 'factor_id');
    }

    public function subscriptions()
    {
        return $this->belongsToMany(Subscription::class, 'user_subscriptions', 'user_id', 'subscription_id')
            ->withPivot('status');
    }

    public function userSubscriptionProducts()
    {
        return $this->hasMany(UserSubscriptionProduct::class, 'user_id');
    }

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class, 'user_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
