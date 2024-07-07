<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
    ];

    public function cart()
    {
        return $this->hasMany(Cart::class, 'car_model', 'id');
    }
}
