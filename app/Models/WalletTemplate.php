<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'platform',
        'pass_type_id',
        'logo_text',
        'background_color',
        'foreground_color',
        'label_color',
        'is_active',
    ];

    /**
     * تحويل أنواع البيانات للحقول المحددة.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];
}
