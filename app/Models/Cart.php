<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'factor_id',
        'product_id',
        'car_model',
        'car_color',
        'car_number',
        'car_wash',
        'status',
        'car_type',
        'price',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function factor()
    {
        return $this->belongsTo(User::class, 'factor_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function car()
    {
        return $this->belongsTo(Car::class, 'car_model', 'id');
    }
}
