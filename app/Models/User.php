<?php

namespace App\Models;

use App\Models\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property string $phone
 * @property string $password
 * @property string $role
 * @property string $status
 * @property string|null $address
 * @property string|null $city
 * @property string|null $image
 * @property float $points
 * @property string|null $expo_push_token
 * @property string|null $qr_code_identifier
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int $services_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Cart[] $userCart
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Cart[] $factorCart
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Subscription[] $subscriptions
 * // ... أضف باقي العلاقات هنا بنفس الطريقة
 */
class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /*
    |--------------------------------------------------------------------------
    | Eloquent Configuration
    |--------------------------------------------------------------------------
    */

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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
        'gender',
        'image',
        'expo_push_token',
        'qr_code_identifier',
        'points',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'points' => 'float',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'services_count'
    ];


    /*
    |--------------------------------------------------------------------------
    | Accessors & Mutators
    |--------------------------------------------------------------------------
    */

    /**
     * حساب عدد الخدمات التي لم تكن هدية للعميل.
     *
     * @return int
     */
    public function getServicesCountAttribute(): int
    {
        if ($this->isCustomer()) {
            return $this->serviceLogs()->where('is_reward', false)->count();
        }
        return 0;
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

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

    public function serviceLogs()
    {
        return $this->hasMany(ServiceLog::class, 'customer_id', 'id');
    }


    /*
    |--------------------------------------------------------------------------
    | JWT Authentication
    |--------------------------------------------------------------------------
    */

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
