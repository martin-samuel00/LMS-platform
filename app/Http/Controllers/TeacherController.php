<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\ClassroomMaterial;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\ClassroomMessage;
use App\Models\ClassroomAnnouncement;
use App\Models\Attendance;
use App\Models\AppNotification;
use App\Models\Quiz;
use App\Models\Certificate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Jobs\NotifyClassroomStudents;

class TeacherController extends Controller
{
    /**
     * Authorize teacher or platform administrator
     */
    protected function authorizeTeacherOrAdmin(Classroom $classroom): void
    {
        if ($classroom->teacher_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access to this classroom.');
        }
    }

    // Show teacher's main classrooms dashboard
    public function index()
    {
        $user = Auth::user();
        if (!$user->isTeacher()) {
            return redirect()->route('students.index')->with('error', 'Only teachers and administrators can access the teacher portal.');
        }

        $classrooms = Classroom::where('teacher_id', $user->id)
            ->withCount(['students', 'pendingStudents', 'assignments', 'materials', 'quizzes', 'certificates', 'announcements'])
            ->latest()
            ->get();

        return view('teachers.index', compact('classrooms'));
    }

    // Create a new classroom
    public function storeClassroom(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        // Generate a unique 6-character classroom code
        do {
            $code = strtoupper(Str::random(6));
        } while (Classroom::where('code', $code)->exists());

        Classroom::create([
            'teacher_id' => Auth::id(),
            'name' => $request->name,
            'subject' => $request->subject,
            'description' => $request->description,
            'code' => $code,
        ]);

        return redirect()->route('teachers.index')->with('success', "Classroom '{$request->name}' created! Class Code: {$code}");
    }

    // View specific classroom
    public function showClassroom(Classroom $classroom)
    {
        $this->authorizeTeacherOrAdmin($classroom);

        $classroom->load([
            'students',
            'pendingStudents',
            'assignments.submissions.user',
            'materials',
            'announcements.teacher',
            'attendances.student',
            'messages.user',
            'quizzes.submissions.user',
            'certificates.user',
        ]);

        // Group attendances by date for easy summary
        $attendancesByDate = $classroom->attendances->groupBy(function ($item) {
            return $item->date->format('Y-m-d');
        });

        return view('teachers.classroom', compact('classroom', 'attendancesByDate'));
    }

    // Post message to classroom chat
    public function postMessage(Request $request, Classroom $classroom)
    {
        $this->authorizeTeacherOrAdmin($classroom);

        $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $msg = $classroom->messages()->create([
            'user_id' => Auth::id(),
            'message' => trim($request->message),
        ]);

        try {
            broadcast(new \App\Events\ClassroomMessageSent($msg))->toOthers();
        } catch (\Throwable $e) {
            // Fail gracefully if websocket server is not started
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => [
                    'id' => $msg->id,
                    'classroom_id' => $classroom->id,
                    'user_id' => Auth::id(),
                    'user_name' => Auth::user()->name,
                    'user_role' => Auth::user()->role,
                    'message' => $msg->message,
                    'created_at' => $msg->created_at ? $msg->created_at->format('M d, g:i A') : now()->format('M d, g:i A'),
                ]
            ]);
        }

        return back()->with('success', 'Message posted to class chat!');
    }

    // Create Assignment with optional PDF / Doc attachment
    public function storeAssignment(Request $request, Classroom $classroom)
    {
        $this->authorizeTeacherOrAdmin($classroom);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'due_date' => ['required', 'date', 'after:now'],
            'points' => ['required', 'integer', 'min:1', 'max:1000'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,doc,docx,ppt,pptx,txt,zip,png,jpg,jpeg', 'max:20480'],
        ]);

        $filePath = null;
        $fileName = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = $file->getClientOriginalName();
            $filePath = $file->store('assignments', 'public');
        }

        $assignment = $classroom->assignments()->create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'due_date' => $request->due_date,
            'points' => $request->points,
        ]);

        // Dispatch async background notification to all enrolled students
        NotifyClassroomStudents::dispatch(
            $classroom->id,
            "📌 New Assignment in {$classroom->name}",
            "{$assignment->title} (Due: " . $assignment->due_date->format('M d, h:i A') . ")",
            route('students.classroom', $classroom),
            'assignment'
        );

        return redirect()->route('teachers.classroom', $classroom)->with('success', 'Assignment created successfully with attachment!');
    }

    // Upload course materials (independent of assignments)
    public function storeMaterial(Request $request, Classroom $classroom)
    {
        $this->authorizeTeacherOrAdmin($classroom);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'file' => ['required', 'file', 'mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,txt,zip,png,jpg,jpeg,mp4,webm,mov', 'max:102400'],
        ]);

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $fileType = strtolower($file->getClientOriginalExtension());
        
        $bytes = $file->getSize();
        if ($bytes >= 1048576) {
            $fileSize = round($bytes / 1048576, 1) . ' MB';
        } else {
            $fileSize = round($bytes / 1024, 1) . ' KB';
        }

        $filePath = $file->store('materials', 'public');

        $classroom->materials()->create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_type' => $fileType,
            'file_size' => $fileSize,
        ]);

        // Dispatch async background notification to enrolled students
        NotifyClassroomStudents::dispatch(
            $classroom->id,
            "📚 New Study Material in {$classroom->name}",
            "{$request->title} ({$fileName})",
            route('students.classroom', $classroom),
            'material'
        );

        return redirect()->route('teachers.classroom', $classroom)->with('success', "Material '{$fileName}' uploaded successfully!");
    }

    // Delete a classroom material
    public function deleteMaterial(Classroom $classroom, ClassroomMaterial $material)
    {
        $this->authorizeTeacherOrAdmin($classroom);
        if ($material->classroom_id !== $classroom->id) {
            abort(403);
        }

        if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        return back()->with('success', 'Material removed successfully.');
    }

    // Store official announcement
    public function storeAnnouncement(Request $request, Classroom $classroom)
    {
        $this->authorizeTeacherOrAdmin($classroom);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);

        $announcement = $classroom->announcements()->create([
            'teacher_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'is_pinned' => true,
        ]);

        // Dispatch async background notification to all enrolled students
        NotifyClassroomStudents::dispatch(
            $classroom->id,
            "📢 Announcement: {$request->title}",
            Str::limit($request->content, 90),
            route('students.classroom', $classroom),
            'announcement'
        );

        return redirect()->route('teachers.classroom', $classroom)->with('success', 'Announcement published and pinned!');
    }

    // Delete announcement
    public function deleteAnnouncement(Classroom $classroom, ClassroomAnnouncement $announcement)
    {
        $this->authorizeTeacherOrAdmin($classroom);
        if ($announcement->classroom_id !== $classroom->id) {
            abort(403);
        }

        $announcement->delete();
        return back()->with('success', 'Announcement removed.');
    }

    // Record / Update Attendance
    public function storeAttendance(Request $request, Classroom $classroom)
    {
        $this->authorizeTeacherOrAdmin($classroom);

        $request->validate([
            'date' => ['required', 'date'],
            'attendance' => ['required', 'array'],
        ]);

        $date = $request->date;
        $count = 0;

        foreach ($request->attendance as $studentId => $status) {
            if (in_array($status, ['present', 'absent', 'late', 'excused'])) {
                Attendance::updateOrCreate(
                    [
                        'classroom_id' => $classroom->id,
                        'user_id' => $studentId,
                        'date' => $date,
                    ],
                    [
                        'status' => $status,
                    ]
                );
                $count++;
            }
        }

        return back()->with('success', "Attendance saved for {$date} ({$count} students recorded).");
    }

    // Grade student's assignment submission
    public function gradeSubmission(Request $request, AssignmentSubmission $submission)
    {
        $classroom = $submission->assignment->classroom;
        $this->authorizeTeacherOrAdmin($classroom);

        $request->validate([
            'grade' => ['required', 'integer', 'min:0', 'max:' . $submission->assignment->points],
            'feedback' => ['nullable', 'string', 'max:1000'],
        ]);

        $submission->update([
            'grade' => $request->grade,
            'feedback' => $request->feedback,
            'status' => 'graded',
        ]);

        // Send notification to the student
        AppNotification::send(
            $submission->user_id,
            "🎯 Assignment Graded: {$submission->assignment->title}",
            "Score: {$request->grade} / {$submission->assignment->points} points" . ($request->feedback ? " - Feedback: {$request->feedback}" : ""),
            route('students.classroom', $classroom),
            'grade'
        );

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => "Submission for {$submission->user->name} graded successfully!",
                'grade' => $submission->grade,
                'feedback' => $submission->feedback,
                'submission_status' => 'graded'
            ]);
        }

        return back()->with('success', "Submission for {$submission->user->name} graded successfully!");
    }

    // Accept or Decline a student's join request
    public function handleJoinRequest(Request $request, Classroom $classroom, User $student)
    {
        $this->authorizeTeacherOrAdmin($classroom);

        $action = $request->input('action');

        if ($action === 'accept') {
            $classroom->pendingStudents()->updateExistingPivot($student->id, ['status' => 'approved']);

            // Notify student
            AppNotification::send(
                $student->id,
                "🎉 Join Request Approved!",
                "You are now enrolled in {$classroom->name}.",
                route('students.classroom', $classroom),
                'join_request'
            );

            return back()->with('success', "Accepted {$student->name} into the classroom!");
        } elseif ($action === 'decline') {
            $classroom->pendingStudents()->detach($student->id);

            AppNotification::send(
                $student->id,
                "Join Request Declined",
                "Your request to join {$classroom->name} was not approved.",
                route('students.index'),
                'join_request'
            );

            return back()->with('success', "Declined join request from {$student->name}.");
        }

        return back();
    }

    // Remove a student from classroom
    public function removeStudent(Classroom $classroom, User $student)
    {
        $this->authorizeTeacherOrAdmin($classroom);

        $classroom->students()->detach($student->id);

        return back()->with('success', "Student '{$student->name}' has been removed from this classroom.");
    }

    // Show form to create a quiz
    public function createQuiz(Classroom $classroom)
    {
        $this->authorizeTeacherOrAdmin($classroom);

        return view('teachers.create-quiz', compact('classroom'));
    }

    // Store a new quiz with multi-format questions and timers
    public function storeQuiz(Request $request, Classroom $classroom)
    {
        $this->authorizeTeacherOrAdmin($classroom);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'pass_percentage' => ['required', 'integer', 'min:1', 'max:100'],
            'duration_minutes' => ['nullable', 'integer', 'min:1', 'max:360'],
            'questions' => ['required', 'array', 'min:1'],
            'questions.*.text' => ['required', 'string'],
            'questions.*.type' => ['nullable', 'string', 'in:choose,true_false,complete,match,essay,scientific_term'],
            'questions.*.timer' => ['nullable', 'integer', 'min:5', 'max:600'],
        ]);

        $quiz = $classroom->quizzes()->create([
            'title' => $request->title,
            'description' => $request->description,
            'pass_percentage' => $request->pass_percentage,
            'duration_minutes' => $request->duration_minutes,
        ]);

        foreach ($request->questions as $q) {
            $type = $q['type'] ?? 'choose';
            $timer = !empty($q['timer']) ? (int) $q['timer'] : null;
            $points = !empty($q['points']) ? (int) $q['points'] : 1;

            $questionData = [
                'question_type' => $type,
                'time_limit_seconds' => $timer,
                'question_text' => $q['text'],
                'points' => $points,
                'option_a' => $q['option_a'] ?? '-',
                'option_b' => $q['option_b'] ?? '-',
                'option_c' => $q['option_c'] ?? '-',
                'option_d' => $q['option_d'] ?? '-',
                'correct_option' => $q['correct'] ?? 'a',
                'correct_answer_text' => null,
                'matching_pairs' => null,
            ];

            if ($type === 'true_false') {
                $questionData['option_a'] = 'True';
                $questionData['option_b'] = 'False';
                $questionData['option_c'] = '-';
                $questionData['option_d'] = '-';
                $questionData['correct_option'] = strtolower($q['correct'] ?? 'true') === 'true' ? 'a' : 'b';
            } elseif ($type === 'complete' || $type === 'scientific_term' || $type === 'essay') {
                $questionData['option_a'] = '-';
                $questionData['option_b'] = '-';
                $questionData['option_c'] = '-';
                $questionData['option_d'] = '-';
                $questionData['correct_answer_text'] = trim($q['answer_text'] ?? '');
                $questionData['correct_option'] = 'text';
            } elseif ($type === 'match') {
                $pairs = [];
                if (!empty($q['match_left']) && is_array($q['match_left'])) {
                    foreach ($q['match_left'] as $idx => $leftItem) {
                        $rightItem = $q['match_right'][$idx] ?? '';
                        if (!empty($leftItem) && !empty($rightItem)) {
                            $pairs[] = [
                                'left' => trim($leftItem),
                                'right' => trim($rightItem)
                            ];
                        }
                    }
                }
                $questionData['matching_pairs'] = $pairs;
                $questionData['correct_option'] = 'match';
            }

            $quiz->questions()->create($questionData);
        }

        // Notify enrolled students
        foreach ($classroom->students as $student) {
            AppNotification::send(
                $student->id,
                "📝 New Quiz in {$classroom->name}",
                "{$quiz->title} (Pass mark: {$quiz->pass_percentage}%)",
                route('students.quiz.take', $quiz),
                'quiz'
            );
        }

        return redirect()->route('teachers.classroom', $classroom)->with('success', 'Comprehensive quiz created and published successfully!');
    }

    // Issue a certificate to an enrolled student
    public function issueCertificate(Request $request, Classroom $classroom)
    {
        $this->authorizeTeacherOrAdmin($classroom);

        $request->validate([
            'student_id' => ['required', 'exists:users,id'],
            'title' => ['required', 'string', 'max:255'],
        ]);

        $exists = Certificate::where('classroom_id', $classroom->id)
            ->where('user_id', $request->student_id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'A certificate has already been issued to this student for this classroom.');
        }

        $student = User::findOrFail($request->student_id);

        $certCode = 'CERT-' . strtoupper(Str::random(8));

        $certificate = Certificate::create([
            'classroom_id' => $classroom->id,
            'user_id' => $student->id,
            'certificate_code' => $certCode,
            'title' => $request->title,
            'issued_at' => now(),
        ]);

        // Notify student
        AppNotification::send(
            $student->id,
            "🎓 Certificate Awarded!",
            "You earned the '{$request->title}' certificate in {$classroom->name}!",
            route('certificates.show', $certificate),
            'certificate'
        );

        return redirect()->route('teachers.classroom', $classroom)->with('success', "Certificate successfully awarded to {$student->name}!");
    }
}
