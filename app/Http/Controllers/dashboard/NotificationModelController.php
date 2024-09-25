<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\NotificationModel;
use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

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

        // Handle image upload with unique name
        $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
        $imagePath = $request->file('image')->storeAs('notifications', $imageName, 'public');

        // Save notification details
        NotificationModel::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        // Fetch user expo tokens and send notifications
        $expoPushTokens = User::whereNotNull('expo_push_token')->pluck('expo_push_token')->toArray();

        foreach (array_chunk($expoPushTokens, 100) as $tokensChunk) {
            Notification::send(null, new UserNotification($request->title, $request->description, $tokensChunk));
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

        // Handle image upload if provided and delete old image
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($notification->image && Storage::disk('public')->exists($notification->image)) {
                Storage::disk('public')->delete($notification->image);
            }

            // Store new image
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('notifications', $imageName, 'public');
            $notification->image = $imagePath;
        }

        // Update notification details
        $notification->update($request->only('title', 'description'));

        // Fetch user expo tokens and send notifications
        $expoPushTokens = User::whereNotNull('expo_push_token')->pluck('expo_push_token')->toArray();

        foreach (array_chunk($expoPushTokens, 100) as $tokensChunk) {
            Notification::send(null, new UserNotification($request->title, $request->description, $tokensChunk));
        }

        return redirect()->route('notifications.index')->with('success', 'Notification updated successfully.');
    }
    public function destroy(NotificationModel $notification)
    {
        $notification->delete();
        return redirect()->route('notifications.index');
    }
}
