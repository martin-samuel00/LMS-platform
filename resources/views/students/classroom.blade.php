<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $classroom->name }} - Student Classroom Hub</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/js/app.js'])
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.setAttribute('data-theme', 'dark');
        } else {
            document.documentElement.setAttribute('data-theme', 'light');
        }
    </script>
    <style>
        :root {
            --bg-color: #f8fafc;
            --card-bg: #ffffff;
            --card-subtle: #f1f5f9;
            --border-color: #e2e8f0;
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --input-bg: #ffffff;
            --input-border: #cbd5e1;
            --box-bg: #f8fafc;
            --chat-other: #ffffff;
            --highlight: #4f46e5;
            --highlight-hover: #4338ca;
            --accent-glow: rgba(79, 70, 229, 0.12);
        }

        [data-theme="dark"] {
            --bg-color: #0b0f19;
            --card-bg: #111827;
            --card-subtle: #1f2937;
            --border-color: #1f2937;
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --input-bg: #0b0f19;
            --input-border: #374151;
            --box-bg: #0b0f19;
            --chat-other: #1f2937;
            --highlight: #6366f1;
            --highlight-hover: #4f46e5;
            --accent-glow: rgba(99, 102, 241, 0.18);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            transition: background-color 0.2s, color 0.2s, border-color 0.2s;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-primary);
            min-height: 100vh;
            padding-bottom: 60px;
        }

        /* Navbar */
        .navbar {
            background: var(--card-bg);
            border-bottom: 1px solid var(--border-color);
            padding: 14px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 50;
            backdrop-filter: blur(12px);
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 15px;
            font-weight: 700;
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.15s;
        }

        .nav-brand:hover {
            color: var(--highlight);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .nav-link {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.15s;
        }

        .nav-link:hover {
            color: var(--text-primary);
            background: var(--card-subtle);
        }

        .badge-counter {
            background: #ef4444;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 999px;
        }

        .btn-theme-toggle {
            background: var(--card-subtle);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            padding: 6px 12px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-logout {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
            padding: 7px 14px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s;
        }

        .btn-logout:hover {
            background: #ef4444;
            color: #fff;
        }

        /* Container */
        .container {
            max-width: 1050px;
            margin: 28px auto;
            padding: 0 20px;
        }

        /* Alerts */
        .alert {
            padding: 14px 18px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-success {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        [data-theme="dark"] .alert-success {
            background: rgba(6, 95, 70, 0.25);
            color: #6ee7b7;
            border-color: #047857;
        }

        [data-theme="dark"] .alert-error {
            background: rgba(153, 27, 27, 0.25);
            color: #fca5a5;
            border-color: #b91c1c;
        }

        /* Classroom Hero Banner */
        .class-hero {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 45%, #4338ca 100%);
            color: #ffffff;
            border-radius: 20px;
            padding: 32px 36px;
            margin-bottom: 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 12px 30px -10px rgba(67, 56, 202, 0.4);
        }

        .hero-left h1 {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 8px;
            color: #ffffff;
        }

        .hero-left p {
            font-size: 14px;
            color: #c7d2fe;
            line-height: 1.5;
        }

        .hero-teacher-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
            color: #ffffff;
            margin-top: 8px;
        }

        .btn-message-teacher {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 700;
            font-size: 13.5px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.15s;
            backdrop-filter: blur(8px);
        }

        .btn-message-teacher:hover {
            background: #ffffff;
            color: #312e81;
            transform: translateY(-1px);
        }

        /* Certificate Banner */
        .cert-banner {
            background: linear-gradient(135deg, rgba(234, 179, 8, 0.15) 0%, rgba(202, 138, 4, 0.08) 100%);
            border: 2px dashed #eab308;
            border-radius: 16px;
            padding: 22px 28px;
            margin-bottom: 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            box-shadow: 0 4px 16px rgba(234, 179, 8, 0.15);
        }

        .cert-banner h3 {
            font-size: 18px;
            color: #ca8a04;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        [data-theme="dark"] .cert-banner h3 {
            color: #fde047;
        }

        .cert-banner p {
            font-size: 13.5px;
            color: var(--text-secondary);
            margin-top: 4px;
        }

        .btn-gold {
            background: linear-gradient(135deg, #eab308, #ca8a04);
            color: #ffffff;
            padding: 10px 22px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 700;
            font-size: 13.5px;
            box-shadow: 0 4px 10px rgba(202, 138, 4, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.15s;
        }

        .btn-gold:hover {
            transform: scale(1.02);
            box-shadow: 0 6px 14px rgba(202, 138, 4, 0.4);
        }

        /* Standard Card */
        .card {
            background: var(--card-bg);
            border-radius: 16px;
            border: 1px solid var(--border-color);
            padding: 26px;
            margin-bottom: 28px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.02);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--border-color);
        }

        .card-header h2 {
            font-size: 17px;
            font-weight: 700;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Announcements */
        .announcement-item {
            background: var(--card-subtle);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 18px;
            margin-bottom: 12px;
        }

        .announcement-item:last-child {
            margin-bottom: 0;
        }

        .pin-pill {
            background: #e0e7ff;
            color: #4338ca;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        [data-theme="dark"] .pin-pill {
            background: #312e81;
            color: #c7d2fe;
        }

        /* Attendance Pill Bar */
        .attendance-stats-bar {
            display: flex;
            align-items: center;
            gap: 16px;
            background: var(--card-subtle);
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 18px;
        }

        .attendance-score-pill {
            font-size: 14px;
            font-weight: 800;
            padding: 6px 16px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* Study Materials */
        .material-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--card-subtle);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 10px;
            transition: all 0.15s;
        }

        .material-item:hover {
            border-color: var(--highlight);
        }

        .material-info {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .doc-icon {
            font-size: 26px;
        }

        .doc-details h4 {
            font-size: 14.5px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 2px;
        }

        .doc-details p {
            font-size: 12px;
            color: var(--text-secondary);
        }

        .btn-download {
            background: #10b981;
            color: #ffffff;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.15s;
        }

        .btn-download:hover {
            background: #059669;
        }

        .btn-preview-sm {
            background: #4f46e5;
            color: #ffffff;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: all 0.15s;
        }

        .btn-preview-sm:hover {
            background: #4338ca;
        }

        .preview-modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(4px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .preview-modal-card {
            background: var(--card-bg);
            border-radius: 12px;
            width: 100%;
            max-width: 900px;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
            border: 1px solid var(--border-color);
        }

        .preview-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 20px;
            border-bottom: 1px solid var(--border-color);
        }

        /* Assignments */
        .assignment-card {
            background: var(--card-subtle);
            border: 1.5px solid var(--border-color);
            border-radius: 14px;
            padding: 22px;
            margin-bottom: 18px;
            transition: all 0.2s;
        }

        .assignment-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 12px;
        }

        .assignment-header h3 {
            font-size: 16px;
            font-weight: 800;
            color: var(--text-primary);
        }

        .badge-due {
            font-size: 11.5px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 6px;
            background: #fee2e2;
            color: #b91c1c;
        }

        .badge-submitted {
            font-size: 11.5px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 6px;
            background: #dcfce7;
            color: #15803d;
        }

        .badge-graded {
            font-size: 11.5px;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 6px;
            background: var(--accent-glow);
            color: var(--highlight);
        }

        .submit-form textarea {
            width: 100%;
            padding: 12px 14px;
            background: var(--input-bg);
            color: var(--text-primary);
            border: 1.5px solid var(--input-border);
            border-radius: 10px;
            font-size: 13.5px;
            outline: none;
            margin-bottom: 12px;
            resize: vertical;
        }

        .submit-form textarea:focus {
            border-color: var(--highlight);
        }

        .btn-submit-work {
            background: var(--highlight);
            color: #ffffff;
            border: none;
            padding: 10px 22px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.15s;
        }

        .btn-submit-work:hover {
            background: var(--highlight-hover);
        }

        /* Quizzes */
        .quiz-item {
            background: var(--card-subtle);
            border: 1.5px solid var(--border-color);
            border-radius: 12px;
            padding: 18px 20px;
            margin-bottom: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }

        .quiz-item h3 {
            font-size: 15.5px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .quiz-item p {
            font-size: 12.5px;
            color: var(--text-secondary);
        }

        .btn-quiz {
            background: var(--highlight);
            color: #ffffff;
            text-decoration: none;
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.15s;
        }

        .btn-quiz:hover {
            background: var(--highlight-hover);
        }

        /* Discussion Chat */
        .chat-box {
            max-height: 300px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 12px;
            padding: 16px;
            background: var(--box-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            margin-bottom: 14px;
        }

        .chat-msg {
            padding: 10px 14px;
            border-radius: 12px;
            font-size: 13.5px;
            max-width: 80%;
            line-height: 1.4;
        }

        .chat-msg.mine {
            background: var(--highlight);
            color: #ffffff;
            align-self: flex-end;
            border-bottom-right-radius: 2px;
        }

        .chat-msg.theirs {
            background: var(--chat-other);
            color: var(--text-primary);
            align-self: flex-start;
            border: 1px solid var(--border-color);
            border-bottom-left-radius: 2px;
        }

        .chat-msg.teacher {
            background: var(--accent-glow);
            color: var(--text-primary);
            align-self: flex-start;
            border-left: 3.5px solid var(--highlight);
            border-bottom-left-radius: 2px;
        }

        .chat-meta {
            font-size: 11px;
            margin-bottom: 4px;
            font-weight: 700;
            opacity: 0.85;
        }

        .chat-form {
            display: flex;
            gap: 10px;
        }

        .chat-form input {
            flex: 1;
            padding: 11px 16px;
            background: var(--input-bg);
            color: var(--text-primary);
            border: 1.5px solid var(--input-border);
            border-radius: 10px;
            font-size: 13.5px;
            outline: none;
        }

        .chat-form input:focus {
            border-color: var(--highlight);
        }

        .chat-form button {
            background: var(--highlight);
            color: #ffffff;
            border: none;
            padding: 11px 22px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.15s;
        }

        .chat-form button:hover {
            background: var(--highlight-hover);
        }

        .empty-text {
            color: var(--text-secondary);
            font-size: 13.5px;
            text-align: center;
            padding: 24px;
        }
    </style>
</head>
<body>
    <!-- Top Navigation -->
    <nav class="navbar">
        <a href="{{ route('students.index') }}" class="nav-brand">
            <span>&larr;</span>
            <span>Back to My Learning</span>
        </a>
        <div class="nav-links">
            <button type="button" class="btn-theme-toggle" onclick="toggleTheme()" title="Toggle Light/Dark Theme">
                <span id="theme-icon">🌙</span>
            </button>
            <a href="{{ route('notifications.index') }}" class="nav-link" style="position: relative;">
                <span>🔔</span>
                <span>Alerts</span>
                @php $unreadCount = Auth::user()->unreadNotifications()->count(); @endphp
                @if ($unreadCount > 0)
                    <span class="badge-counter">{{ $unreadCount }}</span>
                @endif
            </a>
            <a href="{{ route('messages.index') }}" class="nav-link">
                <span>💬</span>
                <span>Messages</span>
            </a>
            <a href="{{ route('profile.show') }}" class="nav-link">
                <span>⚙️</span>
                <span>Profile</span>
            </a>
            <a href="{{ route('dashboard') }}" class="nav-link">
                <span>Dashboard</span>
            </a>
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container">
        <!-- Flash Messages -->
        @if (session('success'))
            <div class="alert alert-success">
                <span>✅</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-error">
                <span>⚠️</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Classroom Hero Banner -->
        <div class="class-hero">
            <div class="hero-left">
                <h1>{{ $classroom->name }}</h1>
                <p>{{ $classroom->subject ?? 'General Curriculum' }} &bull; {{ $classroom->description ?? 'Welcome to your online classroom space.' }}</p>
                <div class="hero-teacher-badge">
                    <span>👨‍🏫 Instructor:</span>
                    <strong>{{ $classroom->teacher->name }}</strong>
                </div>
            </div>
            <div>
                <a href="{{ route('messages.index', ['user_id' => $classroom->teacher_id]) }}" class="btn-message-teacher">
                    <span>💬</span>
                    <span>Message Instructor</span>
                </a>
            </div>
        </div>

        <!-- Earned Certificate Banner (If Awarded) -->
        @if ($myCertificate)
            <div class="cert-banner">
                <div>
                    <h3>
                        <span>🏆</span>
                        <span>Official Course Certificate Awarded!</span>
                    </h3>
                    <p>Congratulations! You have successfully earned the verified <strong>{{ $myCertificate->title }}</strong> for this course.</p>
                </div>
                <a href="{{ route('certificates.show', $myCertificate) }}" target="_blank" class="btn-gold">
                    <span>View / Print Certificate</span>
                    <span>&rarr;</span>
                </a>
            </div>
        @endif

        <!-- Official Pinned Announcements -->
        @if ($classroom->announcements->isNotEmpty())
            <div class="card" style="border-top: 4px solid var(--highlight);">
                <div class="card-header">
                    <h2>📢 Instructor Announcements ({{ $classroom->announcements->count() }})</h2>
                </div>
                <div>
                    @foreach ($classroom->announcements as $announcement)
                        <div class="announcement-item">
                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                                <span class="pin-pill">📌 PINNED</span>
                                <h3 style="font-size: 15.5px; font-weight: 700; color: var(--text-primary);">{{ $announcement->title }}</h3>
                            </div>
                            <p style="font-size: 13.5px; color: var(--text-primary); line-height: 1.5; white-space: pre-wrap; margin-top: 4px;">{{ $announcement->content }}</p>
                            <div style="font-size: 11.5px; color: var(--text-secondary); margin-top: 10px;">
                                Posted {{ $announcement->created_at->diffForHumans() }} by {{ $announcement->teacher->name }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Attendance Record Card -->
        <div class="card">
            <div class="card-header">
                <h2>📅 My Attendance Record</h2>
                <div>
                    <span class="attendance-score-pill" style="background: {{ $attendancePercentage >= 75 ? '#dcfce7' : '#fef3c7' }}; color: {{ $attendancePercentage >= 75 ? '#15803d' : '#b45309' }};">
                        <span>{{ $attendancePercentage >= 75 ? '🟢' : '🟡' }}</span>
                        <span>{{ $attendancePercentage }}% Attendance</span>
                    </span>
                </div>
            </div>

            <p style="font-size: 13.5px; color: var(--text-secondary); margin-bottom: 14px;">
                You have attended <strong>{{ $attendedCount }}</strong> out of <strong>{{ $totalLectures }}</strong> recorded lecture roll-calls.
            </p>

            @if ($myAttendances->isEmpty())
                <p class="empty-text" style="background: var(--card-subtle); border-radius: 10px; padding: 14px;">
                    No attendance sessions logged by the instructor yet.
                </p>
            @else
                <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                    @foreach ($myAttendances as $att)
                        <div style="background: var(--card-subtle); border: 1px solid var(--border-color); border-radius: 8px; padding: 6px 12px; font-size: 12.5px; display: inline-flex; align-items: center; gap: 6px;">
                            <span>{{ $att->date->format('M d, Y') }}:</span>
                            @if ($att->status === 'present')
                                <strong style="color: #15803d;">Present &check;</strong>
                            @elseif ($att->status === 'absent')
                                <strong style="color: #b91c1c;">Absent &cross;</strong>
                            @elseif ($att->status === 'late')
                                <strong style="color: #b45309;">Late ⏳</strong>
                            @else
                                <strong style="color: #4338ca;">Excused 🛡️</strong>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Course Study Materials & Documents -->
        <div class="card">
            <div class="card-header">
                <h2>📚 Course Study Materials & Lecture Notes ({{ $classroom->materials->count() }})</h2>
            </div>
            @if ($classroom->materials->isEmpty())
                <p class="empty-text">No study materials or lecture notes uploaded by the instructor yet.</p>
            @else
                <div>
                    @foreach ($classroom->materials as $mat)
                        <div class="material-item">
                            <div class="material-info">
                                <span class="doc-icon">
                                    @if(in_array($mat->file_type, ['pdf'])) 📕
                                    @elseif(in_array($mat->file_type, ['mp4', 'webm', 'mov'])) 🎬
                                    @elseif(in_array($mat->file_type, ['png', 'jpg', 'jpeg', 'webp'])) 🖼️
                                    @elseif(in_array($mat->file_type, ['doc', 'docx'])) 📘
                                    @elseif(in_array($mat->file_type, ['ppt', 'pptx'])) 📙
                                    @elseif(in_array($mat->file_type, ['xls', 'xlsx'])) 📊
                                    @else 📁 @endif
                                </span>
                                <div class="doc-details">
                                    <h4>{{ $mat->title }}</h4>
                                    <p>{{ $mat->file_name }} &bull; {{ $mat->file_size ?? 'Document' }} &bull; Added {{ $mat->created_at->format('M d, Y') }}</p>
                                    @if($mat->description)
                                        <p style="margin-top: 3px; color: var(--text-secondary);">{{ $mat->description }}</p>
                                    @endif
                                </div>
                            </div>
                            <div style="display: flex; gap: 8px; align-items: center;">
                                <button type="button" class="btn-preview-sm" onclick="openPreviewModal('{{ asset('storage/' . $mat->file_path) }}', '{{ addslashes($mat->title) }}', '{{ $mat->file_type }}')">
                                    <span>👁️</span>
                                    <span>Preview</span>
                                </button>
                                <a href="{{ asset('storage/' . $mat->file_path) }}" download class="btn-download">
                                    <span>Download</span>
                                    <span>&darr;</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Class Assignments -->
        <div class="card">
            <div class="card-header">
                <h2>📌 Class Assignments ({{ $classroom->assignments->count() }})</h2>
            </div>
            @if ($classroom->assignments->isEmpty())
                <p class="empty-text">No assignments posted for this classroom yet.</p>
            @else
                @foreach ($classroom->assignments as $assignment)
                    @php
                        $sub = $myAssignmentSubmissions->get($assignment->id);
                    @endphp
                    <div class="assignment-card">
                        <div class="assignment-header">
                            <div>
                                <h3>{{ $assignment->title }}</h3>
                                <p style="font-size: 13.5px; color: var(--text-secondary); margin-top: 4px; line-height: 1.5;">{{ $assignment->description }}</p>
                                
                                @if ($assignment->file_path)
                                    <div style="margin-top: 8px;">
                                        <a href="{{ asset('storage/' . $assignment->file_path) }}" download style="font-size: 12.5px; color: var(--highlight); text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                            📎 Download Reference: {{ $assignment->file_name ?? 'Assignment Attachment' }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                            <div style="text-align: right; flex-shrink: 0;">
                                <div style="margin-bottom: 4px;">
                                    @if ($sub)
                                        @if ($sub->status === 'graded')
                                            <span class="badge-graded">Score: {{ $sub->grade }}/{{ $assignment->points }}</span>
                                        @else
                                            <span class="badge-submitted">Submitted &checkmark;</span>
                                        @endif
                                    @else
                                        <span class="badge-due">Due: {{ $assignment->due_date->format('M d, h:i A') }} ({{ $assignment->due_date->diffForHumans() }})</span>
                                    @endif
                                </div>
                                <span style="font-size: 12px; color: var(--text-secondary); font-weight: 600;">Max Points: {{ $assignment->points }}</span>
                            </div>
                        </div>

                        <!-- Submission Status / Form -->
                        <div style="margin-top: 16px; border-top: 1px solid var(--border-color); padding-top: 14px;">
                            @if ($sub)
                                <div style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 10px; padding: 14px;">
                                    <div style="font-size: 12px; color: var(--text-secondary); margin-bottom: 4px; font-weight: 600;">Your Submission (Submitted {{ $sub->submitted_at->diffForHumans() }}):</div>
                                    <p style="font-size: 14px; color: var(--text-primary); line-height: 1.5;">{{ $sub->content }}</p>
                                    
                                    @if ($sub->file_path)
                                        <div style="margin-top: 8px;">
                                            <a href="{{ asset('storage/' . $sub->file_path) }}" download class="btn-download" style="padding: 5px 12px; font-size: 11.5px;">
                                                📥 Download Uploaded Deliverable ({{ $sub->file_name ?? 'Uploaded File' }})
                                            </a>
                                        </div>
                                    @endif

                                    @if ($sub->feedback)
                                        <div style="margin-top: 10px; background: var(--accent-glow); padding: 10px 12px; border-radius: 8px; font-size: 12.5px; color: var(--highlight);">
                                            <strong>Instructor Feedback:</strong> {{ $sub->feedback }}
                                        </div>
                                    @endif
                                </div>
                            @else
                                <form action="{{ route('students.assignment.submit', $assignment) }}" method="POST" enctype="multipart/form-data" class="submit-form">
                                    @csrf
                                    <textarea name="content" rows="3" placeholder="Type your response, write-up, or notes regarding your submission..." required></textarea>
                                    <div style="margin-bottom: 14px;">
                                        <label style="font-size: 12px; font-weight: 700; color: var(--text-secondary); display: block; margin-bottom: 6px;">
                                            Attach File Deliverable (PDF, Word, Code, ZIP up to 25MB - optional):
                                        </label>
                                        <input type="file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx,.zip,.txt,.jpg,.jpeg,.png,.py,.java,.cpp,.c,.html,.css,.js" style="font-size: 13px; color: var(--text-primary);">
                                    </div>
                                    <button type="submit" class="btn-submit-work">Submit Assignment &rarr;</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Quizzes Section -->
        <div class="card">
            <div class="card-header">
                <h2>🎯 Class Quizzes ({{ $classroom->quizzes->count() }})</h2>
            </div>
            @if ($classroom->quizzes->isEmpty())
                <p class="empty-text">No quizzes published for this classroom yet.</p>
            @else
                @foreach ($classroom->quizzes as $quiz)
                    @php
                        $sub = $myQuizSubmissions->get($quiz->id);
                    @endphp
                    <div class="quiz-item">
                        <div>
                            <h3>{{ $quiz->title }}</h3>
                            <p>{{ $quiz->questions->count() }} Questions &bull; Pass Threshold: {{ $quiz->pass_percentage }}%</p>
                            @if ($quiz->description)
                                <p style="font-size: 12.5px; color: var(--text-secondary); margin-top: 3px;">{{ $quiz->description }}</p>
                            @endif
                        </div>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            @if ($sub)
                                <span style="font-size: 13px; font-weight: 700; padding: 4px 10px; border-radius: 6px; background: {{ $sub->passed ? '#dcfce7' : '#fee2e2' }}; color: {{ $sub->passed ? '#15803d' : '#b91c1c' }};">
                                    {{ $sub->score }}/{{ $sub->total_questions }} ({{ $sub->percentage }}%) &bull; {{ $sub->passed ? 'Passed ✅' : 'Failed ❌' }}
                                </span>
                                <a href="{{ route('students.quiz.take', $quiz) }}" class="btn-quiz" style="background: var(--card-bg); color: var(--text-primary); border: 1.5px solid var(--border-color);">
                                    Retake
                                </a>
                            @else
                                <a href="{{ route('students.quiz.take', $quiz) }}" class="btn-quiz">
                                    <span>Take Quiz</span>
                                    <span>&rarr;</span>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Classroom Discussion Wall -->
        <div class="card">
            <div class="card-header">
                <h2>💬 Classroom Discussion Wall</h2>
            </div>
            <div class="chat-box">
                @if ($classroom->messages->isEmpty())
                    <p class="empty-text" style="margin: auto;">No messages in class discussion yet. Say hi or ask a question below!</p>
                @else
                    @foreach ($classroom->messages as $msg)
                        @php
                            $isMine = $msg->user_id === Auth::id();
                            $isTeacher = $msg->user->isTeacher();
                        @endphp
                        <div class="chat-msg {{ $isMine ? 'mine' : ($isTeacher ? 'teacher' : 'theirs') }}">
                            <div class="chat-meta">
                                {{ $msg->user->name }} ({{ ucfirst($msg->user->role) }}) &bull; {{ $msg->created_at->diffForHumans() }}
                            </div>
                            <div>{{ $msg->message }}</div>
                        </div>
                    @endforeach
                @endif
            </div>
            <form action="{{ route('students.classroom.message', $classroom) }}" method="POST" class="chat-form">
                @csrf
                <input type="text" name="message" placeholder="Ask a question or post a note to the classroom..." required>
                <button type="submit">Post</button>
            </form>
        </div>
    </div>

    <script>
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function appendChatMessage(userName, userRole, time, message, isMine) {
            const chatBox = document.querySelector('.chat-box');
            if (!chatBox) return;
            const emptyText = chatBox.querySelector('.empty-text');
            if (emptyText) emptyText.remove();

            const isTeacher = userRole === 'teacher';
            const msgDiv = document.createElement('div');
            msgDiv.className = `chat-msg ${isMine ? 'mine' : (isTeacher ? 'teacher' : 'theirs')}`;
            msgDiv.innerHTML = `
                <div class="chat-meta">
                    ${escapeHtml(userName)} (${escapeHtml(userRole)}) &bull; ${escapeHtml(time)}
                </div>
                <div>${escapeHtml(message)}</div>
            `;
            chatBox.appendChild(msgDiv);
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        // AJAX Chat Submission
        const chatForm = document.querySelector('.chat-form');
        if (chatForm) {
            chatForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                const input = chatForm.querySelector('input[name="message"]');
                const text = input.value.trim();
                if (!text) return;

                const myName = "{{ Auth::user()->name }}";
                const myRole = "{{ Auth::user()->role }}";
                appendChatMessage(myName, myRole, 'Just now', text, true);
                input.value = '';
                input.focus();

                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                try {
                    const response = await fetch(chatForm.action, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({ message: text })
                    });
                    if (!response.ok) {
                        console.error('Failed to post message');
                    }
                } catch (err) {
                    console.error('Network error posting message', err);
                }
            });
        }

        // Real-Time Classroom Discussion Listener via Echo
        document.addEventListener('DOMContentLoaded', function() {
            const chatBox = document.querySelector('.chat-box');
            if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;

            if (window.Echo) {
                const currentUserId = {{ Auth::id() }};
                window.Echo.private(`classroom.{{ $classroom->id }}`)
                    .listen('.ClassroomMessageSent', function(e) {
                        if (e.message.user_id !== currentUserId) {
                            appendChatMessage(e.message.user_name, e.message.user_role, e.message.created_at, e.message.message, false);
                        }
                    });
            }
        });

        function updateThemeButton() {
            const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            const icon = document.getElementById('theme-icon');
            if (icon) {
                icon.textContent = isDark ? '☀️ Light' : '🌙 Dark';
            }
        }

        function toggleTheme() {
            const current = document.documentElement.getAttribute('data-theme') || 'light';
            const next = current === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
            updateThemeButton();
        }

        // Preview Modal Functions
        function openPreviewModal(url, title, fileType) {
            const modal = document.getElementById('previewModal');
            const titleEl = document.getElementById('previewTitle');
            const bodyEl = document.getElementById('previewBody');
            const downloadBtn = document.getElementById('previewDownloadBtn');

            titleEl.textContent = title;
            downloadBtn.href = url;
            bodyEl.innerHTML = '';

            const ext = (fileType || '').toLowerCase();
            if (ext === 'pdf') {
                bodyEl.innerHTML = `<iframe src="${url}" style="width:100%; height:75vh; border:none; border-radius:8px;"></iframe>`;
            } else if (['mp4', 'webm', 'mov'].includes(ext)) {
                bodyEl.innerHTML = `<video controls autoplay style="width:100%; max-height:75vh; border-radius:8px; background:#000;"><source src="${url}">Your browser does not support video playback.</video>`;
            } else if (['png', 'jpg', 'jpeg', 'webp', 'gif'].includes(ext)) {
                bodyEl.innerHTML = `<img src="${url}" alt="${title}" style="max-width:100%; max-height:75vh; border-radius:8px; object-fit:contain;">`;
            } else {
                bodyEl.innerHTML = `
                    <div style="text-align: center; padding: 40px 20px;">
                        <span style="font-size: 48px; display: block; margin-bottom: 12px;">📁</span>
                        <h4 style="font-size: 16px; margin-bottom: 8px; color: var(--text-primary);">${escapeHtml(title)}</h4>
                        <p style="font-size: 13.5px; color: var(--text-secondary); margin-bottom: 16px;">This file type (${ext.toUpperCase()}) cannot be previewed directly inside the browser.</p>
                        <a href="${url}" download class="btn-download" style="display:inline-flex; font-size: 13px; padding: 8px 16px;">Download to View &darr;</a>
                    </div>
                `;
            }

            modal.style.display = 'flex';
        }

        function closePreviewModal(e) {
            if (e.target.id === 'previewModal') {
                closePreviewModalDirect();
            }
        }

        function closePreviewModalDirect() {
            const modal = document.getElementById('previewModal');
            const bodyEl = document.getElementById('previewBody');
            if (modal) {
                modal.style.display = 'none';
                bodyEl.innerHTML = '';
            }
        }

        updateThemeButton();
    </script>

    <!-- Material Document & Video Preview Modal -->
    <div id="previewModal" class="preview-modal-backdrop" style="display:none;" onclick="closePreviewModal(event)">
        <div class="preview-modal-card" onclick="event.stopPropagation()">
            <div class="preview-modal-header">
                <h3 id="previewTitle" style="font-size: 15px; font-weight: 700; margin: 0; color: var(--text-primary);">Document Preview</h3>
                <div style="display: flex; gap: 8px; align-items: center;">
                    <a id="previewDownloadBtn" href="#" download class="btn-download" style="text-decoration:none; padding: 5px 12px; font-size: 12px;">Download &darr;</a>
                    <button type="button" onclick="closePreviewModalDirect()" style="background:none; border:none; font-size: 22px; cursor:pointer; color: var(--text-secondary); padding: 0 4px;">&times;</button>
                </div>
            </div>
            <div id="previewBody" class="preview-modal-body" style="padding: 14px; min-height: 250px; display: flex; align-items: center; justify-content: center; background: var(--bg-color);">
                <!-- Dynamic Preview Injected Here -->
            </div>
        </div>
    </div>
</body>
</html>


