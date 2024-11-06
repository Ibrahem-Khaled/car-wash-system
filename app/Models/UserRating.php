<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'factor_id',
        'cart_id',
        'rating',
        'comment',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function factor()
    {
        return $this->belongsTo(User::class, 'factor_id');
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }
}
