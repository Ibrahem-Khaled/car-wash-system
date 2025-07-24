<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceLog extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'scanned_by_user_id', 'is_reward', 'is_used', 'gifted_to_phone_number'];

    // علاقة السجل مع العميل
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    // علاقة السجل مع المستخدم الذي قام بالمسح
    public function scanner()
    {
        return $this->belongsTo(User::class, 'scanned_by_user_id');
    }
}
