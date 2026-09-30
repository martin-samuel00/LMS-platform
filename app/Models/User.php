<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'is_banned',
        'ban_reason',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_banned' => 'boolean',
        ];
    }

    public function isTeacher(): bool
    {
        return $this->role === 'teacher' || $this->isAdmin() || $this->taughtClassrooms()->exists();
    }

    public function isStudent(): bool
    {
        return $this->role === 'student' || $this->isAdmin();
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'moderator']);
    }

    public function isModerator(): bool
    {
        return in_array($this->role, ['admin', 'moderator']);
    }

    // Classrooms created by teacher
    public function taughtClassrooms()
    {
        return $this->hasMany(Classroom::class, 'teacher_id');
    }

    // Classrooms a student is enrolled in (approved)
    public function enrolledClassrooms()
    {
        return $this->belongsToMany(Classroom::class, 'classroom_user', 'user_id', 'classroom_id')
            ->withPivot('status')
            ->withTimestamps()
            ->wherePivot('status', 'approved');
    }

    // Classrooms where student has a pending join request
    public function pendingClassrooms()
    {
        return $this->belongsToMany(Classroom::class, 'classroom_user', 'user_id', 'classroom_id')
            ->withPivot('status')
            ->withTimestamps()
            ->wherePivot('status', 'pending');
    }

    // Quizzes taken by student
    public function quizSubmissions()
    {
        return $this->hasMany(QuizSubmission::class);
    }

    // Assignment submissions
    public function assignmentSubmissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    // Classroom chat messages
    public function classroomMessages()
    {
        return $this->hasMany(ClassroomMessage::class);
    }

    // Certificates earned by student
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    // In-app notifications
    public function notifications()
    {
        return $this->hasMany(AppNotification::class)->latest();
    }

    public function unreadNotifications()
    {
        return $this->hasMany(AppNotification::class)->where('is_read', false)->latest();
    }

    // Attendance records
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    // Direct Messages
    public function sentDirectMessages()
    {
        return $this->hasMany(DirectMessage::class, 'sender_id');
    }

    public function receivedDirectMessages()
    {
        return $this->hasMany(DirectMessage::class, 'receiver_id');
    }
}
