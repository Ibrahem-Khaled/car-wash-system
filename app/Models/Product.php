<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'small_car_price', 'medium_car_price', 'large_car_price', 'x_large_car_price', 'image', 'type', 'description'];

    public function cart()
    {
        return $this->hasMany(Cart::class, 'product_id');
    }

    public function subscriptions()
    {
        return $this->belongsToMany(Subscription::class, 'subscription_products');
    }

}
