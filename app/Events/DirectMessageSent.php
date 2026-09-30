<?php

namespace App\Events;

use App\Models\DirectMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DirectMessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $message;

    public function __construct(DirectMessage $message)
    {
        $message->loadMissing(['sender', 'receiver']);

        $this->message = [
            'id' => $message->id,
            'sender_id' => $message->sender_id,
            'receiver_id' => $message->receiver_id,
            'sender_name' => $message->sender->name ?? 'User',
            'sender_role' => $message->sender->role ?? 'student',
            'message' => $message->message,
            'created_at' => $message->created_at ? $message->created_at->format('M d, g:i A') : now()->format('M d, g:i A'),
            'timestamp' => $message->created_at ? $message->created_at->toIso8601String() : now()->toIso8601String(),
        ];
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->message['receiver_id']),
            new PrivateChannel('user.' . $this->message['sender_id']),
        ];
    }

    public function broadcastAs(): string
    {
        return 'DirectMessageSent';
    }
}
