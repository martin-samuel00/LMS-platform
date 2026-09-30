<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassroomMaterial extends Model
{
    protected $fillable = [
        'classroom_id',
        'title',
        'description',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}
