<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'price', 'status', 'image', 'duration'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'subscription_prpducts', 'subscription_id', 'product_id')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_subscriptions', 'subscription_id', 'user_id');
    }
}
