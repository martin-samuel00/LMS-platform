<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    protected $fillable = [
        'quiz_id',
        'question_type',
        'time_limit_seconds',
        'question_text',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_option',
        'correct_answer_text',
        'matching_pairs',
        'points',
    ];

    protected $casts = [
        'matching_pairs' => 'array',
        'time_limit_seconds' => 'integer',
        'points' => 'integer',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
