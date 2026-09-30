<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\studentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DirectMessageController;
use App\Http\Controllers\AdminController;

// Landing / Home page
Route::get('/', function () {
    return view('welcome');
});

// Public discovery of teachers and classrooms
Route::get('/students/teachers/search', [studentController::class, 'searchTeachers'])->name('students.teachers.search');

// Guest Routes (accessible only when not logged in)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated Routes (accessible only when logged in)
Route::middleware('auth')->group(function () {
    // --- Email Verification Routes ---
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('dashboard')->with('success', 'Your email address has been verified successfully!');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'verification-link-sent');
    })->middleware('throttle:6,1')->name('verification.send');

    // --- Dashboard & Logout ---
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --- User Profile & Settings ---
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // --- In-App Notifications ---
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');

    // --- 1-on-1 Direct Messaging ---
    Route::get('/messages', [DirectMessageController::class, 'index'])->name('messages.index');
    Route::post('/messages', [DirectMessageController::class, 'store'])->name('messages.store')->middleware('throttle:60,1');

    // --- Teacher Routes ---
    Route::prefix('teachers')->name('teachers.')->group(function () {
        Route::get('/', [TeacherController::class, 'index'])->name('index');
        Route::post('/classroom', [TeacherController::class, 'storeClassroom'])->name('classroom.store');
        Route::get('/classroom/{classroom}', [TeacherController::class, 'showClassroom'])->name('classroom');
        Route::delete('/classroom/{classroom}/student/{student}', [TeacherController::class, 'removeStudent'])->name('classroom.student.remove');
        Route::post('/classroom/{classroom}/join-request/{student}', [TeacherController::class, 'handleJoinRequest'])->name('classroom.join-request');
        Route::post('/classroom/{classroom}/assignment', [TeacherController::class, 'storeAssignment'])->name('assignment.store');
        Route::post('/classroom/{classroom}/material', [TeacherController::class, 'storeMaterial'])->name('material.store');
        Route::delete('/classroom/{classroom}/material/{material}', [TeacherController::class, 'deleteMaterial'])->name('material.delete');
        Route::post('/classroom/{classroom}/announcement', [TeacherController::class, 'storeAnnouncement'])->name('announcement.store');
        Route::delete('/classroom/{classroom}/announcement/{announcement}', [TeacherController::class, 'deleteAnnouncement'])->name('announcement.delete');
        Route::post('/classroom/{classroom}/attendance', [TeacherController::class, 'storeAttendance'])->name('attendance.store');
        Route::post('/submission/{submission}/grade', [TeacherController::class, 'gradeSubmission'])->name('submission.grade');
        Route::post('/classroom/{classroom}/message', [TeacherController::class, 'postMessage'])->name('classroom.message')->middleware('throttle:60,1');
        Route::get('/classroom/{classroom}/quiz/create', [TeacherController::class, 'createQuiz'])->name('quiz.create');
        Route::post('/classroom/{classroom}/quiz', [TeacherController::class, 'storeQuiz'])->name('quiz.store');
        Route::post('/classroom/{classroom}/certificate', [TeacherController::class, 'issueCertificate'])->name('certificate.issue');
    });

    // --- Student Routes ---
    Route::prefix('students')->name('students.')->group(function () {
        Route::get('/', [studentController::class, 'index'])->name('index');
        Route::post('/classroom/{classroom}/request-join', [studentController::class, 'requestJoinClassroom'])->name('classroom.request-join');
        Route::post('/join', [studentController::class, 'joinClassroom'])->name('classroom.join');
        Route::get('/classroom/{classroom}', [studentController::class, 'showClassroom'])->name('classroom');
        Route::post('/assignment/{assignment}/submit', [studentController::class, 'submitAssignment'])->name('assignment.submit');
        Route::post('/classroom/{classroom}/message', [studentController::class, 'postMessage'])->name('classroom.message')->middleware('throttle:60,1');
        Route::get('/quiz/{quiz}', [studentController::class, 'takeQuiz'])->name('quiz.take');
        Route::post('/quiz/{quiz}/submit', [studentController::class, 'submitQuiz'])->name('quiz.submit');
    });

    // --- Certificate View (Printable) ---
    Route::get('/certificates/{certificate}', [studentController::class, 'viewCertificate'])->name('certificates.show');

    // --- Integrated Admin & Moderator Dashboard ---
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::post('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('users.role');
        Route::post('/users/{user}/ban', [AdminController::class, 'toggleUserBan'])->name('users.ban');
        Route::post('/users/{user}/verify', [AdminController::class, 'verifyUserEmail'])->name('users.verify');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');

        Route::get('/classrooms', [AdminController::class, 'classrooms'])->name('classrooms');
        Route::delete('/classrooms/{classroom}', [AdminController::class, 'deleteClassroom'])->name('classrooms.delete');

        Route::get('/moderation', [AdminController::class, 'moderation'])->name('moderation');
        Route::delete('/moderation/messages/{message}', [AdminController::class, 'deleteMessage'])->name('moderation.messages.delete');
        Route::delete('/moderation/materials/{material}', [AdminController::class, 'deleteMaterial'])->name('moderation.materials.delete');
        Route::delete('/moderation/announcements/{announcement}', [AdminController::class, 'deleteAnnouncement'])->name('moderation.announcements.delete');

        Route::post('/broadcast', [AdminController::class, 'broadcast'])->name('broadcast');
    });
});