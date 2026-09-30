<?php

namespace App\Events;

use App\Models\AppNotification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AppNotificationSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $notification;

    public function __construct(AppNotification $notification)
    {
        $this->notification = [
            'id' => $notification->id,
            'user_id' => $notification->user_id,
            'title' => $notification->title,
            'message' => $notification->message,
            'link' => $notification->link,
            'type' => $notification->type,
            'created_at' => $notification->created_at ? $notification->created_at->diffForHumans() : 'Just now',
        ];
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->notification['user_id']),
        ];
    }

    public function broadcastAs(): string
    {
        return 'AppNotificationSent';
    }
}
