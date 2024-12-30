<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'message',
        'sender_type',
        'reply_to',
        'support_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function originalMessage()
    {
        return $this->belongsTo(ChatMessage::class, 'reply_to');
    }

    public function support()
    {
        return $this->belongsTo(User::class, 'support_id');
    }
}
