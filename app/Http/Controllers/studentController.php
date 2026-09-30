<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\ClassroomMessage;
use App\Models\ClassroomAnnouncement;
use App\Models\Attendance;
use App\Models\AppNotification;
use App\Models\Quiz;
use App\Models\QuizSubmission;
use App\Models\Certificate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class studentController extends Controller
{
    // Main student dashboard
    public function index()
    {
        $user = Auth::user();

        // Enrolled classrooms (approved)
        $enrolledClassrooms = $user->enrolledClassrooms()
            ->with('teacher')
            ->withCount(['quizzes', 'assignments'])
            ->latest()
            ->get();

        // Pending join requests
        $pendingClassrooms = $user->pendingClassrooms()->with('teacher')->get();

        // Certificates earned
        $certificates = $user->certificates()->with('classroom.teacher')->latest()->get();

        // Quiz submissions
        $submissions = $user->quizSubmissions()->with('quiz.classroom')->latest()->take(5)->get();

        // Pending assignments from enrolled classrooms
        $enrolledIds = $enrolledClassrooms->pluck('id');
        $mySubmittedAssignmentIds = $user->assignmentSubmissions()->pluck('assignment_id');
        $dueAssignments = Assignment::whereIn('classroom_id', $enrolledIds)
            ->whereNotIn('id', $mySubmittedAssignmentIds)
            ->where('due_date', '>=', now())
            ->with('classroom')
            ->orderBy('due_date')
            ->take(5)
            ->get();

        return view('students.index', compact('enrolledClassrooms', 'pendingClassrooms', 'certificates', 'submissions', 'dueAssignments'));
    }

    // Search Teachers & their Classrooms
    public function searchTeachers(Request $request)
    {
        $query = trim($request->input('q'));

        $teachers = User::where(function ($q) {
                $q->where('role', 'teacher')
                  ->orWhereHas('taughtClassrooms');
            })
            ->when($query, function ($qBuilder) use ($query) {
                $qBuilder->where(function ($nested) use ($query) {
                    $nested->where('name', 'like', "%{$query}%")
                           ->orWhere('email', 'like', "%{$query}%")
                           ->orWhereHas('taughtClassrooms', function ($classQ) use ($query) {
                               $classQ->where('name', 'like', "%{$query}%")
                                      ->orWhere('subject', 'like', "%{$query}%");
                           });
                });
            })
            ->with(['taughtClassrooms' => function ($cQ) {
                $cQ->withCount('students');
            }])
            ->get();

        $user = Auth::user();
        $enrolledClassroomIds = $user ? $user->enrolledClassrooms()->pluck('classrooms.id')->toArray() : [];
        $pendingClassroomIds = $user ? $user->pendingClassrooms()->pluck('classrooms.id')->toArray() : [];

        return view('students.teachers-search', compact('teachers', 'query', 'enrolledClassroomIds', 'pendingClassroomIds'));
    }

    // Send a request to join a classroom (needs teacher approval)
    public function requestJoinClassroom(Classroom $classroom)
    {
        $user = Auth::user();

        // Check if already approved or pending
        if ($classroom->students()->where('user_id', $user->id)->exists()) {
            return back()->with('error', "You are already enrolled in '{$classroom->name}'.");
        }

        if ($classroom->pendingStudents()->where('user_id', $user->id)->exists()) {
            return back()->with('error', "You have already sent a join request for '{$classroom->name}'. Please wait for teacher approval.");
        }

        // Attach with pending status
        $classroom->students()->attach($user->id, ['status' => 'pending']);

        // Notify teacher of the join request
        AppNotification::send(
            $classroom->teacher_id,
            "⏳ New Student Join Request",
            "{$user->name} requested to join {$classroom->name}.",
            route('teachers.classroom', $classroom),
            'join_request'
        );

        return back()->with('success', "Join request sent to {$classroom->teacher->name} for '{$classroom->name}'! You will be able to access the class once approved.");
    }

    // Join instantly using class code
    public function joinClassroom(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string'],
        ]);

        $code = strtoupper(trim($request->code));
        $classroom = Classroom::where('code', $code)->first();

        if (!$classroom) {
            return back()->with('error', "No classroom found with code: '{$code}'. Please verify the code.");
        }

        $user = Auth::user();

        // If already approved
        if ($classroom->students()->where('user_id', $user->id)->exists()) {
            return back()->with('error', "You are already enrolled in '{$classroom->name}'.");
        }

        // Enroll instantly as approved (or update pending to approved)
        $classroom->students()->syncWithoutDetaching([$user->id => ['status' => 'approved']]);

        // Notify teacher of instant code join
        AppNotification::send(
            $classroom->teacher_id,
            "👋 Student Joined via Code",
            "{$user->name} joined {$classroom->name} using class code.",
            route('teachers.classroom', $classroom),
            'join_request'
        );

        return redirect()->route('students.classroom', $classroom)->with('success', "Instantly enrolled in {$classroom->name} with code!");
    }

    // View enrolled classroom
    public function showClassroom(Classroom $classroom)
    {
        $user = Auth::user();

        // Must be approved student or the teacher
        $isApproved = $classroom->students()->where('user_id', $user->id)->exists();
        if (!$isApproved && $classroom->teacher_id !== $user->id) {
            abort(403, 'You must be an approved member of this classroom.');
        }

        $classroom->load([
            'teacher',
            'quizzes.questions',
            'assignments.submissions',
            'materials',
            'announcements.teacher',
            'messages.user'
        ]);

        // Student's submissions for quizzes
        $myQuizSubmissions = QuizSubmission::where('user_id', $user->id)
            ->whereIn('quiz_id', $classroom->quizzes->pluck('id'))
            ->get()
            ->keyBy('quiz_id');

        // Student's submissions for assignments
        $myAssignmentSubmissions = AssignmentSubmission::where('user_id', $user->id)
            ->whereIn('assignment_id', $classroom->assignments->pluck('id'))
            ->get()
            ->keyBy('assignment_id');

        // Check if certificate issued
        $myCertificate = Certificate::where('classroom_id', $classroom->id)
            ->where('user_id', $user->id)
            ->first();

        // Calculate student's personal attendance stats
        $totalLectures = $classroom->attendances()->distinct('date')->count('date');
        $myAttendances = $classroom->attendances()->where('user_id', $user->id)->latest('date')->get();
        $attendedCount = $myAttendances->whereIn('status', ['present', 'late'])->count();
        $attendancePercentage = $totalLectures > 0 ? round(($attendedCount / $totalLectures) * 100) : 100;

        return view('students.classroom', compact(
            'classroom',
            'myQuizSubmissions',
            'myAssignmentSubmissions',
            'myCertificate',
            'totalLectures',
            'myAttendances',
            'attendedCount',
            'attendancePercentage'
        ));
    }

    // Submit an assignment with text + optional file upload
    public function submitAssignment(Request $request, Assignment $assignment)
    {
        $user = Auth::user();
        $classroom = $assignment->classroom;

        if (!$classroom->students()->where('user_id', $user->id)->exists()) {
            abort(403);
        }

        $request->validate([
            'content' => ['required', 'string'],
            'file' => ['nullable', 'file', 'max:25600', 'mimes:pdf,doc,docx,ppt,pptx,zip,txt,jpg,jpeg,png,py,java,cpp,c,html,css,js'],
        ]);

        $filePath = null;
        $fileName = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $filePath = $file->store('assignments/submissions', 'public');
        }

        $status = $assignment->isPastDue() ? 'late' : 'submitted';

        $submissionData = [
            'content' => $request->content,
            'status' => $status,
            'submitted_at' => now(),
        ];

        if ($filePath) {
            $submissionData['file_path'] = $filePath;
            $submissionData['file_name'] = $fileName;
        }

        AssignmentSubmission::updateOrCreate(
            [
                'assignment_id' => $assignment->id,
                'user_id' => $user->id,
            ],
            $submissionData
        );

        // Notify teacher of the submission
        AppNotification::send(
            $classroom->teacher_id,
            "📥 Work Submitted: {$assignment->title}",
            "{$user->name} submitted work" . ($fileName ? " with attachment ({$fileName})" : "") . ($status === 'late' ? " [LATE]" : ""),
            route('teachers.classroom', $classroom),
            'submission'
        );

        return back()->with('success', 'Assignment submitted successfully!' . ($status === 'late' ? ' (Note: Marked as Late)' : ''));
    }

    // Post to classroom chat
    public function postMessage(Request $request, Classroom $classroom)
    {
        $user = Auth::user();
        if (!$classroom->students()->where('user_id', $user->id)->exists() && $classroom->teacher_id !== $user->id) {
            abort(403);
        }

        $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $msg = $classroom->messages()->create([
            'user_id' => $user->id,
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
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'user_role' => $user->role,
                    'message' => $msg->message,
                    'created_at' => $msg->created_at ? $msg->created_at->format('M d, g:i A') : now()->format('M d, g:i A'),
                ]
            ]);
        }

        return back()->with('success', 'Message posted to class chat!');
    }

    // Take a quiz
    public function takeQuiz(Quiz $quiz)
    {
        $user = Auth::user();
        $classroom = $quiz->classroom;

        if (!$classroom->students()->where('user_id', $user->id)->exists()) {
            abort(403, 'You must be enrolled in the classroom to take this quiz.');
        }

        $quiz->load('questions');

        return view('students.take-quiz', compact('quiz', 'classroom'));
    }

    // Submit quiz answers
    public function submitQuiz(Request $request, Quiz $quiz)
    {
        $user = Auth::user();
        $classroom = $quiz->classroom;

        if (!$classroom->students()->where('user_id', $user->id)->exists()) {
            abort(403);
        }

        $questions = $quiz->questions;
        $total = $questions->count();
        $score = 0;

        $answers = $request->input('answers', []);

        foreach ($questions as $q) {
            if (isset($answers[$q->id]) && $answers[$q->id] === $q->correct_option) {
                $score++;
            }
        }

        $percentage = $total > 0 ? round(($score / $total) * 100, 2) : 0;
        $passed = $percentage >= $quiz->pass_percentage;

        // Record submission
        $submission = QuizSubmission::create([
            'quiz_id' => $quiz->id,
            'user_id' => $user->id,
            'score' => $score,
            'total_questions' => $total,
            'percentage' => $percentage,
            'passed' => $passed,
        ]);

        return redirect()->route('students.classroom', $classroom)->with('success', "Quiz submitted! Your score: {$score}/{$total} ({$percentage}%). " . ($passed ? "🎉 Congratulations, you passed!" : "Keep practicing!"));
    }

    // View certificate
    public function viewCertificate(Certificate $certificate)
    {
        $user = Auth::user();

        if ($certificate->user_id !== $user->id && $certificate->classroom->teacher_id !== $user->id) {
            abort(403, 'Unauthorized.');
        }

        $certificate->load(['user', 'classroom.teacher']);

        return view('certificates.show', compact('certificate'));
    }
}
