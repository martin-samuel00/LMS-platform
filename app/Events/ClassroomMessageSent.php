<?php

namespace App\Events;

use App\Models\ClassroomMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ClassroomMessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $message;

    public function __construct(ClassroomMessage $message)
    {
        $message->loadMissing('user');

        $this->message = [
            'id' => $message->id,
            'classroom_id' => $message->classroom_id,
            'user_id' => $message->user_id,
            'user_name' => $message->user->name ?? 'User',
            'user_role' => $message->user->role ?? 'student',
            'message' => $message->message,
            'created_at' => $message->created_at ? $message->created_at->format('M d, g:i A') : now()->format('M d, g:i A'),
            'timestamp' => $message->created_at ? $message->created_at->toIso8601String() : now()->toIso8601String(),
        ];
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('classroom.' . $this->message['classroom_id']),
        ];
    }

    public function broadcastAs(): string
    {
        return 'ClassroomMessageSent';
    }
}
