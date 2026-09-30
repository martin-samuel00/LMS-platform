<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Classroom;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('classroom.{id}', function ($user, $id) {
    $classroom = Classroom::find($id);
    if (! $classroom) {
        return false;
    }
    if ($user->isAdmin() || (int) $classroom->teacher_id === (int) $user->id) {
        return true;
    }
    return $classroom->students()->where('user_id', $user->id)->exists();
});
