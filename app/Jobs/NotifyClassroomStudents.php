<?php

namespace App\Jobs;

use App\Models\Classroom;
use App\Models\AppNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyClassroomStudents implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $classroomId,
        public string $title,
        public string $message,
        public ?string $link = null,
        public string $type = 'general'
    ) {}

    public function handle(): void
    {
        $classroom = Classroom::with('students:id,name,email')->find($this->classroomId);
        if (! $classroom) {
            return;
        }

        foreach ($classroom->students as $student) {
            AppNotification::send(
                $student->id,
                $this->title,
                $this->message,
                $this->link,
                $this->type
            );
        }
    }
}
