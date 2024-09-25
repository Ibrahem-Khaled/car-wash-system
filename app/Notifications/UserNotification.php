<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use YieldStudio\LaravelExpoNotifier\ExpoNotificationsChannel;
use YieldStudio\LaravelExpoNotifier\Dto\ExpoMessage;

class UserNotification extends Notification
{
    use Queueable;

    private $title;
    private $body;
    private $expoTokens;

    /**
     * Create a new notification instance.
     */
    public function __construct($title, $body, $expoTokens)
    {
        $this->title = $title;
        $this->body = $body;
        $this->expoTokens = $expoTokens;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return [ExpoNotificationsChannel::class];
    }

    /**
     * Get the Expo notification representation of the notification.
     */
    public function toExpoNotification($notifiable): ExpoMessage
    {
        return (new ExpoMessage())
            ->to($this->expoTokens)  
            ->title($this->title)
            ->body($this->body)
            ->channelId('default');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
        ];
    }
}
