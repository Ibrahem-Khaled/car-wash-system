<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\NotificationModel;
use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class NotificationModelController extends Controller
{
    public function index()
    {
        $notifications = NotificationModel::all();
        return view('dashboard.notifications', compact('notifications'));
    }

    // Store a new notification
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|image',
        ]);

        // Handle image upload
        $imagePath = $request->file('image')->store('notifications');

        NotificationModel::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        $expoPushTokens = User::pluck('expo_push_token')->toArray();

        foreach (array_chunk($expoPushTokens, 100) as $tokensChunk) {
            Notification::send(null, new UserNotification($request->title, $request->body, $tokensChunk));
        }

        return redirect()->back()->with('success', 'Notification created successfully.');
    }

    public function update(Request $request, NotificationModel $notification)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|image',
        ]);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('notifications');
            $notification->image = $imagePath;
        }

        $notification->update($request->only('title', 'description'));
        $expoPushTokens = User::pluck('expo_push_token')->toArray();

        foreach (array_chunk($expoPushTokens, 100) as $tokensChunk) {
            Notification::send(null, new UserNotification($request->title, $request->body, $tokensChunk));
        }
        return redirect()->route('notifications.index');
    }
    public function destroy(NotificationModel $notification)
    {
        $notification->delete();
        return redirect()->route('notifications.index');
    }
}
