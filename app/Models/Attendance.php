<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'classroom_id',
        'user_id',
        'date',
        'status', // present, absent, late, excused
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
