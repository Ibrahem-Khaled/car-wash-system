<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $users = User::withCount([
            'chatMessages as total_messages' => function ($query) {
                $query->where('sender_type', 'user');
            },
            'chatMessages as unreplied_messages' => function ($query) {
                $query->where('sender_type', 'user')->whereNull('reply_to');
            }
        ])->get();

        return view('dashboard.chat', compact('users'));
    }

    public function getUserMessages($userId)
    {
        $messages = ChatMessage::with('user')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    public function replyToMessage(Request $request)
    {
        $request->validate([
            'reply_to' => 'required|exists:chat_messages,id',
            'message' => 'required|string',
        ]);

        $message = ChatMessage::create([
            'user_id' => ChatMessage::find($request->reply_to)->user_id,
            'message' => $request->message,
            'sender_type' => 'support',
            'reply_to' => $request->reply_to,
            'support_id' => auth()->id(),
        ]);

        return response()->json($message);
    }
}
