<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'classroom_id',
        'title',
        'description',
        'pass_percentage',
        'duration_minutes',
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class);
    }

    public function submissions()
    {
        return $this->hasMany(QuizSubmission::class);
    }
}
