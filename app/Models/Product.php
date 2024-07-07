<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'small_car_price', 'medium_car_price', 'large_car_price', 'image', 'type', 'parent_id', 'description'];

    public function parent()
    {
        return $this->belongsTo(Product::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Product::class, 'parent_id');
    }

    public function cart()
    {
        return $this->hasMany(Cart::class, 'product_id');
    }

}
