<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassroomAnnouncement extends Model
{
    protected $fillable = [
        'classroom_id',
        'teacher_id',
        'title',
        'content',
        'is_pinned',
    ];

    protected function casts(): array
    {
        return [
            'is_pinned' => 'boolean',
        ];
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
