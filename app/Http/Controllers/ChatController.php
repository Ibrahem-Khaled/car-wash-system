<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function fetchMessages()
    {
        $messages = ChatMessage::with(['user', 'originalMessage'])->orderBy('created_at', 'asc')->get();
        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $message = ChatMessage::create([
            'user_id' => auth()->id(),
            'message' => $request->message,
            'sender_type' => 'user',
        ]);

        return response()->json($message);
    }
}
