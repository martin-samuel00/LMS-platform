<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DirectMessage extends Model
{
    public function getConnectionName()
    {
        return env('DB_CHAT_CONNECTION') ?: parent::getConnectionName();
    }

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'classroom_id',
        'message',
        'is_read',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
        ];
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}
