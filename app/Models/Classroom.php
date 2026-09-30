<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = [
        'teacher_id',
        'name',
        'subject',
        'description',
        'code',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // Approved enrolled students
    public function students()
    {
        return $this->belongsToMany(User::class, 'classroom_user', 'classroom_id', 'user_id')
            ->withPivot('status')
            ->withTimestamps()
            ->wherePivot('status', 'approved');
    }

    // Students waiting for teacher approval
    public function pendingStudents()
    {
        return $this->belongsToMany(User::class, 'classroom_user', 'classroom_id', 'user_id')
            ->withPivot('status')
            ->withTimestamps()
            ->wherePivot('status', 'pending');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class)->latest('due_date');
    }

    public function messages()
    {
        return $this->hasMany(ClassroomMessage::class)->with('user')->oldest();
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function materials()
    {
        return $this->hasMany(ClassroomMaterial::class)->latest();
    }

    public function announcements()
    {
        return $this->hasMany(ClassroomAnnouncement::class)->latest();
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class)->latest('date');
    }
}
