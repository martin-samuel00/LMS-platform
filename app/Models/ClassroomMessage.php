<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassroomMessage extends Model
{
    public function getConnectionName()
    {
        return env('DB_CHAT_CONNECTION') ?: parent::getConnectionName();
    }

    protected $fillable = [
        'classroom_id',
        'user_id',
        'message',
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
