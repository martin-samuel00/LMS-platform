<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppNotification extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'link',
        'type',
        'is_read',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Helper to quickly dispatch notification
     */
    public static function send($userId, $title, $message, $link = null, $type = 'general')
    {
        $notification = self::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'link' => $link,
            'type' => $type,
            'is_read' => false,
        ]);

        try {
            broadcast(new \App\Events\AppNotificationSent($notification));
        } catch (\Throwable $e) {
            // Fail gracefully if websocket server is not started
        }

        return $notification;
    }
}
