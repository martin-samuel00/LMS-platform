<?php

namespace Tests\Feature;

use App\Events\ClassroomMessageSent;
use App\Events\DirectMessageSent;
use App\Jobs\NotifyClassroomStudents;
use App\Models\Classroom;
use App\Models\User;
use App\Models\AppNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class RealTimeLmsTest extends TestCase
{
    use RefreshDatabase;

    public function test_teacher_can_post_classroom_message_and_event_broadcasts(): void
    {
        Event::fake([ClassroomMessageSent::class]);

        $teacher = User::factory()->create(['role' => 'teacher']);
        $classroom = Classroom::create([
            'teacher_id' => $teacher->id,
            'name' => 'Computer Science 101',
            'code' => 'CS101XYZ',
        ]);

        $response = $this->actingAs($teacher)
            ->postJson(route('teachers.classroom.message', $classroom), [
                'message' => 'Hello everyone, welcome to CS101!',
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => [
                    'message' => 'Hello everyone, welcome to CS101!',
                ]
            ]);

        $this->assertDatabaseHas('classroom_messages', [
            'classroom_id' => $classroom->id,
            'user_id' => $teacher->id,
            'message' => 'Hello everyone, welcome to CS101!',
        ]);

        Event::assertDispatched(ClassroomMessageSent::class);
    }

    public function test_user_can_send_direct_message_with_real_time_event(): void
    {
        Event::fake([DirectMessageSent::class]);

        $sender = User::factory()->create(['role' => 'student']);
        $receiver = User::factory()->create(['role' => 'teacher']);

        $response = $this->actingAs($sender)
            ->postJson(route('messages.store'), [
                'receiver_id' => $receiver->id,
                'message' => 'Hello Professor, I had a question about the assignment.',
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => [
                    'receiver_id' => $receiver->id,
                    'message' => 'Hello Professor, I had a question about the assignment.',
                ]
            ]);

        $this->assertDatabaseHas('direct_messages', [
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'message' => 'Hello Professor, I had a question about the assignment.',
        ]);

        Event::assertDispatched(DirectMessageSent::class);
    }

    public function test_announcement_dispatches_async_queued_fan_out_job(): void
    {
        Queue::fake([NotifyClassroomStudents::class]);

        $teacher = User::factory()->create(['role' => 'teacher']);
        $classroom = Classroom::create([
            'teacher_id' => $teacher->id,
            'name' => 'Physics 201',
            'code' => 'PHY201A',
        ]);

        $response = $this->actingAs($teacher)
            ->post(route('teachers.announcement.store', $classroom), [
                'title' => 'Midterm Next Week',
                'content' => 'Please review chapters 1 through 5.',
            ]);

        $response->assertRedirect();
        Queue::assertPushed(NotifyClassroomStudents::class);
    }
}
