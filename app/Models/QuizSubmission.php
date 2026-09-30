<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizSubmission extends Model
{
    protected $fillable = [
        'quiz_id',
        'user_id',
        'score',
        'total_questions',
        'percentage',
        'passed',
    ];

    protected function casts(): array
    {
        return [
            'passed' => 'boolean',
        ];
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
