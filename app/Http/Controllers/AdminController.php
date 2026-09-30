<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Certificate;
use App\Models\Classroom;
use App\Models\ClassroomAnnouncement;
use App\Models\ClassroomMaterial;
use App\Models\ClassroomMessage;
use App\Models\DirectMessage;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Admin / Moderator Dashboard Overview
     */
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_students' => User::where('role', 'student')->count(),
            'total_teachers' => User::where('role', 'teacher')->count(),
            'total_moderators' => User::whereIn('role', ['admin', 'moderator'])->count(),
            'banned_users' => User::where('is_banned', true)->count(),
            'verified_users' => User::whereNotNull('email_verified_at')->count(),
            'total_classrooms' => Classroom::count(),
            'total_assignments' => Assignment::count(),
            'total_submissions' => AssignmentSubmission::count(),
            'total_materials' => ClassroomMaterial::count(),
            'total_quizzes' => Quiz::count(),
            'total_certificates' => Certificate::count(),
            'total_messages' => ClassroomMessage::count(),
            'total_direct_messages' => DirectMessage::count(),
        ];

        // Recent activity
        $recentUsers = User::latest()->take(6)->get();
        $recentClassrooms = Classroom::with('teacher')->withCount('students')->latest()->take(5)->get();
        $recentSubmissions = AssignmentSubmission::with(['user', 'assignment.classroom'])->latest('submitted_at')->take(5)->get();

        // System environment info
        $systemInfo = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'environment' => app()->environment(),
            'db_connection' => config('database.default'),
            'storage_linked' => file_exists(public_path('storage')),
        ];

        return view('admin.index', compact('stats', 'recentUsers', 'recentClassrooms', 'recentSubmissions', 'systemInfo'));
    }

    /**
     * User Management
     */
    public function users(Request $request)
    {
        $query = User::query();

        // Search filter
        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Role filter
        if ($role = $request->input('role')) {
            if ($role !== 'all') {
                $query->where('role', $role);
            }
        }

        // Status filter
        if ($status = $request->input('status')) {
            if ($status === 'banned') {
                $query->where('is_banned', true);
            } elseif ($status === 'verified') {
                $query->whereNotNull('email_verified_at');
            } elseif ($status === 'unverified') {
                $query->whereNull('email_verified_at');
            }
        }

        $users = $query->withCount(['taughtClassrooms', 'enrolledClassrooms'])
                       ->latest()
                       ->paginate(15)
                       ->appends($request->all());

        return view('admin.users', compact('users'));
    }

    /**
     * Update User Role
     */
    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:student,teacher,moderator,admin',
        ]);

        if ($user->id === Auth::id() && $request->role !== 'admin') {
            return back()->with('error', 'You cannot demote your own administrator account.');
        }

        $oldRole = $user->role;
        $user->role = $request->role;
        $user->save();

        AppNotification::send(
            $user->id,
            'Role Updated',
            "Your account role has been updated to {$user->role} by an administrator.",
            '/profile',
            'system'
        );

        return back()->with('success', "Updated [{$user->name}] role from {$oldRole} to {$user->role}.");
    }

    /**
     * Toggle User Ban / Suspension
     */
    public function toggleUserBan(Request $request, User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot ban or suspend your own account.');
        }

        if ($user->is_banned) {
            $user->is_banned = false;
            $user->ban_reason = null;
            $user->save();

            AppNotification::send(
                $user->id,
                'Account Reinstated',
                'Your account suspension has been lifted by a moderator. You can now use all features.',
                '/dashboard',
                'system'
            );

            return back()->with('success', "Account suspension lifted for [{$user->name}].");
        } else {
            $request->validate([
                'ban_reason' => 'required|string|max:255',
            ]);

            $user->is_banned = true;
            $user->ban_reason = $request->ban_reason;
            $user->save();

            return back()->with('success', "Account [{$user->name}] has been suspended. Reason: {$user->ban_reason}");
        }
    }

    /**
     * Manually Verify User Email
     */
    public function verifyUserEmail(User $user)
    {
        if ($user->hasVerifiedEmail()) {
            return back()->with('error', "User [{$user->name}] is already verified.");
        }

        $user->markEmailAsVerified();

        AppNotification::send(
            $user->id,
            'Email Manually Verified',
            'Your email address has been verified by a platform moderator.',
            '/profile',
            'system'
        );

        return back()->with('success', "Email for [{$user->name}] successfully marked as verified.");
    }

    /**
     * Delete User
     */
    public function deleteUser(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $userName = $user->name;
        $user->delete();

        return back()->with('success', "User [{$userName}] has been completely deleted from the platform.");
    }

    /**
     * Classroom Management
     */
    public function classrooms(Request $request)
    {
        $query = Classroom::with('teacher');

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhereHas('teacher', function ($t) use ($search) {
                      $t->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $classrooms = $query->withCount(['students', 'assignments', 'materials', 'messages'])
                            ->latest()
                            ->paginate(15)
                            ->appends($request->all());

        return view('admin.classrooms', compact('classrooms'));
    }

    /**
     * Delete Classroom
     */
    public function deleteClassroom(Classroom $classroom)
    {
        $name = $classroom->name;
        $teacherId = $classroom->teacher_id;

        // Delete associated files
        foreach ($classroom->materials as $material) {
            if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
                Storage::disk('public')->delete($material->file_path);
            }
        }

        $classroom->delete();

        AppNotification::send(
            $teacherId,
            'Classroom Removed by Moderator',
            "Your classroom '{$name}' was removed by a platform administrator or moderator.",
            '/dashboard',
            'system'
        );

        return back()->with('success', "Classroom '{$name}' has been deleted.");
    }

    /**
     * Content Moderation Hub
     */
    public function moderation(Request $request)
    {
        $tab = $request->input('tab', 'messages');

        $messages = ClassroomMessage::with(['user', 'classroom'])
                                   ->latest()
                                   ->paginate(20, ['*'], 'messages_page');

        $materials = ClassroomMaterial::with(['classroom.teacher'])
                                      ->latest()
                                      ->paginate(20, ['*'], 'materials_page');

        $announcements = ClassroomAnnouncement::with(['classroom', 'teacher'])
                                              ->latest()
                                              ->paginate(20, ['*'], 'announcements_page');

        return view('admin.moderation', compact('tab', 'messages', 'materials', 'announcements'));
    }

    /**
     * Delete Message
     */
    public function deleteMessage(ClassroomMessage $message)
    {
        $message->delete();
        return back()->with('success', 'Discussion message removed by moderator.');
    }

    /**
     * Delete Material
     */
    public function deleteMaterial(ClassroomMaterial $material)
    {
        if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();
        return back()->with('success', 'Study material removed.');
    }

    /**
     * Delete Announcement
     */
    public function deleteAnnouncement(ClassroomAnnouncement $announcement)
    {
        $announcement->delete();
        return back()->with('success', 'Announcement removed.');
    }

    /**
     * Site-Wide Broadcast System Notification
     */
    public function broadcast(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:120',
            'message' => 'required|string|max:1000',
            'target' => 'required|in:all,students,teachers',
        ]);

        $query = User::query();

        if ($request->target === 'students') {
            $query->where('role', 'student');
        } elseif ($request->target === 'teachers') {
            $query->where('role', 'teacher');
        }

        $users = $query->get();
        $count = 0;

        foreach ($users as $user) {
            AppNotification::send(
                $user->id,
                '📢 System Notice: ' . $request->title,
                $request->message,
                '/dashboard',
                'system'
            );
            $count++;
        }

        return back()->with('success', "Broadcast notification successfully delivered to {$count} users!");
    }
}
