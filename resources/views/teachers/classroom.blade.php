<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $classroom->name }} - Teacher Management Console</title>
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
            gap: 8px;
            font-size: 14.5px;
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
            max-width: 1200px;
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

        /* Class Hero Banner */
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
            margin-bottom: 6px;
            color: #ffffff;
        }

        .hero-left p {
            font-size: 14px;
            color: #c7d2fe;
            line-height: 1.5;
            max-width: 650px;
        }

        .hero-meta-strip {
            display: flex;
            gap: 10px;
            margin-top: 12px;
            flex-wrap: wrap;
        }

        .hero-meta-pill {
            background: rgba(255, 255, 255, 0.14);
            backdrop-filter: blur(8px);
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 12.5px;
            font-weight: 600;
            color: #ffffff;
        }

        /* Code Pill with 1-Click Copy */
        .code-box {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(12px);
            padding: 16px 22px;
            border-radius: 14px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }

        .code-box span {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #e0e7ff;
            font-weight: 700;
        }

        .code-value-row {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .code-box strong {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: 2px;
            color: #ffffff;
        }

        .btn-copy-code {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: #ffffff;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 11.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.15s;
        }

        .btn-copy-code:hover {
            background: #ffffff;
            color: #1e1b4b;
        }

        /* 2-Column Layout */
        .layout-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 28px;
        }

        /* Card Styles */
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

        /* Primary action button */
        .btn-primary-sm {
            background: var(--highlight);
            color: #ffffff;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.15s;
        }

        .btn-primary-sm:hover {
            background: var(--highlight-hover);
        }

        .btn-danger-sm {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s;
        }

        .btn-danger-sm:hover {
            background: #ef4444;
            color: #ffffff;
        }

        .btn-success-sm {
            background: #10b981;
            color: #ffffff;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.15s;
        }

        .btn-success-sm:hover {
            background: #059669;
        }

        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13.5px;
        }

        th {
            text-align: left;
            padding: 10px 12px;
            color: var(--text-secondary);
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1.5px solid var(--border-color);
        }

        td {
            padding: 12px;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-primary);
        }

        /* Form Drawers */
        details.form-drawer {
            margin-bottom: 20px;
            background: var(--card-subtle);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 16px 18px;
            transition: all 0.2s;
        }

        details.form-drawer summary {
            font-weight: 700;
            font-size: 14px;
            color: var(--highlight);
            cursor: pointer;
            user-select: none;
        }

        .drawer-body {
            margin-top: 16px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .input-text, .input-textarea, .input-select {
            padding: 10px 14px;
            background: var(--input-bg);
            color: var(--text-primary);
            border: 1.5px solid var(--input-border);
            border-radius: 8px;
            font-size: 13.5px;
            outline: none;
            width: 100%;
        }

        .input-text:focus, .input-textarea:focus, .input-select:focus {
            border-color: var(--highlight);
        }

        /* Assignments */
        .assignment-row {
            background: var(--card-subtle);
            border: 1.5px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 16px;
        }

        .badge-due {
            font-size: 11.5px;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 6px;
            background: #fee2e2;
            color: #b91c1c;
        }

        /* Materials */
        .material-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--card-subtle);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 10px;
        }

        .material-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-download-sm {
            background: #10b981;
            color: #ffffff;
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .btn-preview-sm {
            background: #4f46e5;
            color: #ffffff;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            cursor: pointer;
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

        /* Discussion Chat */
        .chat-box {
            max-height: 280px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 14px;
            background: var(--box-bg);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            margin-bottom: 12px;
        }

        .chat-message {
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 13px;
            max-width: 85%;
            line-height: 1.4;
        }

        .chat-message.teacher-msg {
            background: var(--accent-glow);
            align-self: flex-start;
            border-left: 3px solid var(--highlight);
            color: var(--text-primary);
        }

        .chat-message.student-msg {
            background: var(--chat-other);
            align-self: flex-start;
            border: 1px solid var(--border-color);
            color: var(--text-primary);
        }

        .chat-form {
            display: flex;
            gap: 8px;
        }

        .chat-form input {
            flex: 1;
            padding: 10px 14px;
            background: var(--input-bg);
            color: var(--text-primary);
            border: 1.5px solid var(--input-border);
            border-radius: 8px;
            font-size: 13px;
            outline: none;
        }

        .chat-form button {
            background: var(--highlight);
            color: #ffffff;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
        }

        /* Issue Certificate */
        .cert-awarded-item {
            background: rgba(234, 179, 8, 0.1);
            border: 1px dashed #facc15;
            padding: 12px 14px;
            border-radius: 8px;
            margin-bottom: 8px;
            font-size: 12.5px;
        }

        .empty-text {
            color: var(--text-secondary);
            font-size: 13.5px;
            text-align: center;
            padding: 20px;
        }

        @media (max-width: 900px) {
            .layout-grid {
                grid-template-columns: 1fr;
            }
            .class-hero {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <!-- Top Navigation -->
    <nav class="navbar">
        <a href="{{ route('teachers.index') }}" class="nav-brand">
            <span>&larr;</span>
            <span>Back to Classrooms</span>
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
                <span>Direct Messages</span>
            </a>
            @if(Auth::user()->isAdmin())
                <a href="{{ route('admin.index') }}" class="nav-link" style="color: #ef4444; font-weight: 700;">
                    <span>🛡️</span>
                    <span>Admin Suite</span>
                </a>
            @endif
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
                <p>{{ $classroom->subject ?? 'General Curriculum' }} &bull; {{ $classroom->description ?? 'Classroom Management Console' }}</p>
                <div class="hero-meta-strip">
                    <span class="hero-meta-pill">👨‍🎓 {{ $classroom->students->count() }} Enrolled</span>
                    <span class="hero-meta-pill">📝 {{ $classroom->assignments->count() }} Assignments</span>
                    <span class="hero-meta-pill">🎯 {{ $classroom->quizzes->count() }} Quizzes</span>
                    <span class="hero-meta-pill">📚 {{ $classroom->materials->count() }} Documents</span>
                </div>
            </div>
            <div class="code-box">
                <span>Instant Student Code</span>
                <div class="code-value-row">
                    <strong>{{ $classroom->code }}</strong>
                    <button type="button" class="btn-copy-code" onclick="copyCode('{{ $classroom->code }}', this)">
                        📋 Copy
                    </button>
                </div>
            </div>
        </div>

        <div class="layout-grid">
            <!-- Left Main Column -->
            <div>
                <!-- Pending Join Requests (If Any) -->
                @if ($classroom->pendingStudents->isNotEmpty())
                    <div class="card" style="border-left: 5px solid #f59e0b;">
                        <div class="card-header">
                            <h2 style="color: #d97706;">⏳ Pending Enrollment Requests ({{ $classroom->pendingStudents->count() }})</h2>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($classroom->pendingStudents as $pending)
                                    <tr>
                                        <td><strong>{{ $pending->name }}</strong></td>
                                        <td style="color: var(--text-secondary);">{{ $pending->email }}</td>
                                        <td>
                                            <div style="display: flex; gap: 8px;">
                                                <form action="{{ route('teachers.classroom.join-request', [$classroom, $pending]) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="action" value="accept">
                                                    <button type="submit" class="btn-success-sm">Approve &checkmark;</button>
                                                </form>
                                                <form action="{{ route('teachers.classroom.join-request', [$classroom, $pending]) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="action" value="decline">
                                                    <button type="submit" class="btn-danger-sm">Decline &times;</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <!-- Official Pinned Announcements Section -->
                <div class="card" style="border-top: 4px solid var(--highlight);">
                    <div class="card-header">
                        <h2>📢 Official Announcements ({{ $classroom->announcements->count() }})</h2>
                    </div>

                    <!-- Post Announcement Form -->
                    <details class="form-drawer">
                        <summary>+ Publish New Announcement</summary>
                        <form action="{{ route('teachers.announcement.store', $classroom) }}" method="POST" class="drawer-body">
                            @csrf
                            <input type="text" name="title" placeholder="Announcement Headline (e.g. Exam Schedule, Next Lecture Info)" required class="input-text">
                            <textarea name="content" rows="3" placeholder="Full announcement text..." required class="input-textarea"></textarea>
                            <button type="submit" class="btn-primary-sm" style="align-self: flex-start;">Publish & Notify Students</button>
                        </form>
                    </details>

                    @if ($classroom->announcements->isEmpty())
                        <p class="empty-text">No official announcements posted yet. Click above to post your first announcement.</p>
                    @else
                        @foreach ($classroom->announcements as $announcement)
                            <div style="background: var(--card-subtle); border: 1px solid var(--border-color); border-radius: 10px; padding: 16px; margin-bottom: 12px;">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 14px;">
                                    <div>
                                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                                            <span style="background: #e0e7ff; color: #4338ca; font-size: 11px; font-weight: 700; padding: 2px 6px; border-radius: 4px;">📌 PINNED</span>
                                            <h3 style="font-size: 15px; font-weight: 700; color: var(--text-primary);">{{ $announcement->title }}</h3>
                                        </div>
                                        <p style="font-size: 13.5px; color: var(--text-primary); line-height: 1.5; margin-top: 6px; white-space: pre-wrap;">{{ $announcement->content }}</p>
                                        <div style="font-size: 11.5px; color: var(--text-secondary); margin-top: 8px;">
                                            Posted {{ $announcement->created_at->diffForHumans() }} by {{ $announcement->teacher->name }}
                                        </div>
                                    </div>
                                    <form action="{{ route('teachers.announcement.delete', [$classroom, $announcement]) }}" method="POST" onsubmit="return confirm('Delete this announcement?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger-sm">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Course Study Materials & Documents Section -->
                <div class="card">
                    <div class="card-header">
                        <h2>📚 Study Materials & Lecture Notes ({{ $classroom->materials->count() }})</h2>
                    </div>

                    <!-- Upload Material Form -->
                    <details class="form-drawer">
                        <summary>+ Upload New Document / Study Material (PDF, DOC, Slides)</summary>
                        <form action="{{ route('teachers.material.store', $classroom) }}" method="POST" enctype="multipart/form-data" class="drawer-body">
                            @csrf
                            <input type="text" name="title" placeholder="Document Title (e.g. Chapter 3 Slides, Syllabus)" required class="input-text">
                            <textarea name="description" rows="2" placeholder="Brief description of the material (optional)..." class="input-textarea"></textarea>
                            <div>
                                <label style="font-size: 12px; font-weight: 700; color: var(--text-secondary); display: block; margin-bottom: 6px;">
                                    Select File (PDF, DOC, DOCX, PPT, PPTX, XLS, TXT, ZIP up to 25MB) *
                                </label>
                                <input type="file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt,.zip,.png,.jpg,.jpeg,.mp4,.webm,.mov" required style="font-size: 13px; color: var(--text-primary);">
                            </div>
                            <button type="submit" class="btn-primary-sm" style="align-self: flex-start;">Upload Material</button>
                        </form>
                    </details>

                    @if ($classroom->materials->isEmpty())
                        <p class="empty-text">No materials uploaded yet. Upload documents above so enrolled students can access them.</p>
                    @else
                        @foreach ($classroom->materials as $mat)
                            <div class="material-item">
                                <div class="material-info">
                                    <span style="font-size: 24px;">
                                        @if(in_array($mat->file_type, ['pdf'])) 📕
                                        @elseif(in_array($mat->file_type, ['mp4', 'webm', 'mov'])) 🎬
                                        @elseif(in_array($mat->file_type, ['png', 'jpg', 'jpeg', 'webp'])) 🖼️
                                        @elseif(in_array($mat->file_type, ['doc', 'docx'])) 📘
                                        @elseif(in_array($mat->file_type, ['ppt', 'pptx'])) 📙
                                        @elseif(in_array($mat->file_type, ['xls', 'xlsx'])) 📊
                                        @else 📁 @endif
                                    </span>
                                    <div>
                                        <h4 style="font-size: 14.5px; font-weight: 700; color: var(--text-primary);">{{ $mat->title }}</h4>
                                        <p style="font-size: 12px; color: var(--text-secondary);">
                                            {{ $mat->file_name }} &bull; {{ $mat->file_size ?? 'Document' }} &bull; {{ $mat->created_at->format('M d, Y') }}
                                        </p>
                                        @if($mat->description)
                                            <p style="font-size: 12.5px; color: var(--text-secondary); margin-top: 2px;">{{ $mat->description }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div style="display: flex; gap: 8px; align-items: center;">
                                    <button type="button" class="btn-preview-sm" onclick="openPreviewModal('{{ asset('storage/' . $mat->file_path) }}', '{{ addslashes($mat->title) }}', '{{ $mat->file_type }}')">👁️ Preview</button>
                                    <a href="{{ asset('storage/' . $mat->file_path) }}" download class="btn-download-sm">Download</a>
                                    <form action="{{ route('teachers.material.delete', [$classroom, $mat]) }}" method="POST" onsubmit="return confirm('Delete this material?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger-sm">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Assignments Section -->
                <div class="card">
                    <div class="card-header">
                        <h2>📌 Class Assignments ({{ $classroom->assignments->count() }})</h2>
                    </div>

                    <!-- Create Assignment Form -->
                    <details class="form-drawer">
                        <summary>+ Create New Assignment (With Optional Attachment)</summary>
                        <form action="{{ route('teachers.assignment.store', $classroom) }}" method="POST" enctype="multipart/form-data" class="drawer-body">
                            @csrf
                            <input type="text" name="title" placeholder="Assignment Title (e.g. Essay 1, Midterm Problem Set)" required class="input-text">
                            <textarea name="description" rows="2" placeholder="Assignment prompt & instructions..." required class="input-textarea"></textarea>
                            
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                                <div>
                                    <label style="font-size: 12px; font-weight: 700; color: var(--text-secondary); display: block; margin-bottom: 4px;">Deadline Date & Time:</label>
                                    <input type="datetime-local" name="due_date" required class="input-text">
                                </div>
                                <div>
                                    <label style="font-size: 12px; font-weight: 700; color: var(--text-secondary); display: block; margin-bottom: 4px;">Maximum Points:</label>
                                    <input type="number" name="points" value="100" min="1" max="1000" required class="input-text">
                                </div>
                            </div>

                            <div>
                                <label style="font-size: 12px; font-weight: 700; color: var(--text-secondary); display: block; margin-bottom: 4px;">
                                    Attach Reference File (PDF, Docs, Slides - optional):
                                </label>
                                <input type="file" name="attachment" accept=".pdf,.doc,.docx,.ppt,.pptx,.txt,.zip,.png,.jpg" style="font-size: 13px; color: var(--text-primary);">
                            </div>

                            <button type="submit" class="btn-primary-sm" style="align-self: flex-start;">Publish Assignment</button>
                        </form>
                    </details>

                    @if ($classroom->assignments->isEmpty())
                        <p class="empty-text">No assignments created yet. Click above to post an assignment.</p>
                    @else
                        @foreach ($classroom->assignments as $assignment)
                            <div class="assignment-row">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                                    <div>
                                        <h3 style="font-size: 16px; font-weight: 800; color: var(--text-primary);">{{ $assignment->title }}</h3>
                                        <p style="font-size: 13px; color: var(--text-secondary); margin-top: 3px; line-height: 1.4;">{{ $assignment->description }}</p>
                                        
                                        @if ($assignment->file_path)
                                            <div style="margin-top: 6px;">
                                                <a href="{{ asset('storage/' . $assignment->file_path) }}" download style="font-size: 12.5px; color: var(--highlight); text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                                    📎 {{ $assignment->file_name ?? 'Download Assignment Attachment' }}
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                    <div style="text-align: right; flex-shrink: 0;">
                                        <span class="badge-due">Due: {{ $assignment->due_date->format('M d, h:i A') }}</span>
                                        <div style="font-size: 12px; color: var(--text-secondary); margin-top: 4px; font-weight: 600;">Points: {{ $assignment->points }}</div>
                                    </div>
                                </div>

                                <!-- Student Submissions List -->
                                <div style="margin-top: 14px; border-top: 1px solid var(--border-color); padding-top: 10px;">
                                    <strong style="font-size: 12.5px; color: var(--text-secondary);">Student Submissions ({{ $assignment->submissions->count() }}):</strong>
                                    @if ($assignment->submissions->isEmpty())
                                        <p style="font-size: 12.5px; color: var(--text-secondary); margin-top: 4px;">No student submissions yet.</p>
                                    @else
                                        <div style="margin-top: 8px; display: flex; flex-direction: column; gap: 10px;">
                                            @foreach ($assignment->submissions as $sub)
                                                <div style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 8px; padding: 12px;">
                                                    <div style="display: flex; justify-content: space-between; font-size: 12.5px;">
                                                        <span><strong>{{ $sub->user->name }}</strong> &bull; Submitted {{ $sub->submitted_at->diffForHumans() }}</span>
                                                        <span style="font-weight: 700; color: {{ $sub->status === 'late' ? '#b91c1c' : '#15803d' }};">
                                                            {{ ucfirst($sub->status) }}
                                                        </span>
                                                    </div>
                                                    <p style="font-size: 13.5px; color: var(--text-primary); margin: 8px 0; background: var(--box-bg); padding: 8px 12px; border-radius: 6px; line-height: 1.4;">{{ $sub->content }}</p>
                                                    
                                                    @if ($sub->file_path)
                                                        <div style="margin-bottom: 8px;">
                                                            <a href="{{ asset('storage/' . $sub->file_path) }}" download class="btn-download-sm">
                                                                📥 Download Deliverable ({{ $sub->file_name ?? 'Attachment' }})
                                                            </a>
                                                        </div>
                                                    @endif
                                                    
                                                    <!-- Grade Form -->
                                                    <form action="{{ route('teachers.submission.grade', $sub) }}" method="POST" style="display: flex; gap: 8px; align-items: center; margin-top: 8px;">
                                                        @csrf
                                                        <input type="number" name="grade" value="{{ $sub->grade }}" placeholder="Grade /{{ $assignment->points }}" max="{{ $assignment->points }}" min="0" required class="input-text" style="width: 100px; padding: 6px 8px; font-size: 12.5px;">
                                                        <input type="text" name="feedback" value="{{ $sub->feedback }}" placeholder="Instructor feedback..." class="input-text" style="flex: 1; padding: 6px 10px; font-size: 12.5px;">
                                                        <button type="submit" class="btn-primary-sm" style="padding: 6px 14px; font-size: 12.5px;">Save Grade</button>
                                                    </form>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Daily Attendance Tracker Section -->
                <div class="card" style="border-top: 4px solid #10b981;">
                    <div class="card-header">
                        <h2>📅 Daily Student Attendance Roll-Call</h2>
                        <span style="font-size: 12.5px; color: var(--text-secondary); font-weight: 600;">{{ $classroom->students->count() }} Enrolled</span>
                    </div>

                    @if ($classroom->students->isEmpty())
                        <p class="empty-text">No students enrolled yet to record attendance.</p>
                    @else
                        <form action="{{ route('teachers.attendance.store', $classroom) }}" method="POST">
                            @csrf
                            <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 16px; background: var(--card-subtle); padding: 12px 18px; border-radius: 10px;">
                                <label for="attendance_date" style="font-size: 13.5px; font-weight: 700; color: var(--text-primary);">Session Date:</label>
                                <input type="date" id="attendance_date" name="date" value="{{ date('Y-m-d') }}" required class="input-text" style="width: auto; padding: 6px 12px;">
                                <span style="font-size: 12px; color: var(--text-secondary);">Select the lecture date to take roll call.</span>
                            </div>

                            <table>
                                <thead>
                                    <tr>
                                        <th>Student</th>
                                        <th>Attendance Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($classroom->students as $student)
                                        <tr>
                                            <td>
                                                <strong>{{ $student->name }}</strong>
                                                <div style="font-size: 11.5px; color: var(--text-secondary);">{{ $student->email }}</div>
                                            </td>
                                            <td>
                                                <div style="display: flex; gap: 16px; align-items: center; font-size: 13px;">
                                                    <label style="display: flex; align-items: center; gap: 4px; cursor: pointer; color: #15803d; font-weight: 700;">
                                                        <input type="radio" name="attendance[{{ $student->id }}]" value="present" checked accent-color="#22c55e">
                                                        <span>Present</span>
                                                    </label>
                                                    <label style="display: flex; align-items: center; gap: 4px; cursor: pointer; color: #b91c1c; font-weight: 700;">
                                                        <input type="radio" name="attendance[{{ $student->id }}]" value="absent" accent-color="#ef4444">
                                                        <span>Absent</span>
                                                    </label>
                                                    <label style="display: flex; align-items: center; gap: 4px; cursor: pointer; color: #b45309; font-weight: 700;">
                                                        <input type="radio" name="attendance[{{ $student->id }}]" value="late" accent-color="#f59e0b">
                                                        <span>Late</span>
                                                    </label>
                                                    <label style="display: flex; align-items: center; gap: 4px; cursor: pointer; color: #4338ca; font-weight: 700;">
                                                        <input type="radio" name="attendance[{{ $student->id }}]" value="excused" accent-color="#6366f1">
                                                        <span>Excused</span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div style="margin-top: 18px;">
                                <button type="submit" class="btn-primary-sm" style="padding: 10px 22px;">Save Attendance Record &check;</button>
                            </div>
                        </form>

                        @if ($attendancesByDate->isNotEmpty())
                            <div style="margin-top: 24px; border-top: 1px solid var(--border-color); padding-top: 16px;">
                                <strong style="font-size: 13px; color: var(--text-secondary); display: block; margin-bottom: 10px;">Recent Attendance History:</strong>
                                <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                                    @foreach ($attendancesByDate->take(8) as $dateStr => $records)
                                        @php
                                            $presentCount = $records->where('status', 'present')->count();
                                            $totalCount = $records->count();
                                        @endphp
                                        <div style="background: var(--card-subtle); border: 1px solid var(--border-color); border-radius: 8px; padding: 6px 12px; font-size: 12px;">
                                            <strong>{{ \Carbon\Carbon::parse($dateStr)->format('M d, Y') }}</strong>:
                                            <span style="color: #15803d; font-weight: 700;">{{ $presentCount }}/{{ $totalCount }} Present</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endif
                </div>

                <!-- Quizzes Section -->
                <div class="card">
                    <div class="card-header">
                        <h2>🎯 Class Quizzes ({{ $classroom->quizzes->count() }})</h2>
                        <a href="{{ route('teachers.quiz.create', $classroom) }}" class="btn-primary-sm">+ Create Quiz</a>
                    </div>
                    @if ($classroom->quizzes->isEmpty())
                        <p class="empty-text">No quizzes created yet. Click "+ Create Quiz" to author questions and automated tests.</p>
                    @else
                        <table>
                            <thead>
                                <tr>
                                    <th>Quiz Title</th>
                                    <th>Questions</th>
                                    <th>Pass Score</th>
                                    <th>Attempts</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($classroom->quizzes as $quiz)
                                    <tr>
                                        <td><strong>{{ $quiz->title }}</strong></td>
                                        <td>{{ $quiz->questions->count() }}</td>
                                        <td>{{ $quiz->pass_percentage }}%</td>
                                        <td>{{ $quiz->submissions->count() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

                <!-- Classroom Discussion Wall -->
                <div class="card">
                    <div class="card-header">
                        <h2>💬 Classroom Discussion Wall</h2>
                    </div>
                    <div class="chat-box">
                        @if ($classroom->messages->isEmpty())
                            <p class="empty-text" style="margin: auto;">No messages in class discussion yet. Post a welcome note to your students!</p>
                        @else
                            @foreach ($classroom->messages as $msg)
                                <div class="chat-message {{ $msg->user_id === Auth::id() ? 'teacher-msg' : 'student-msg' }}">
                                    <div style="font-size: 11px; margin-bottom: 3px; font-weight: 700; opacity: 0.85;">
                                        {{ $msg->user->name }} ({{ ucfirst($msg->user->role) }}) &bull; {{ $msg->created_at->diffForHumans() }}
                                    </div>
                                    <div>{{ $msg->message }}</div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <form action="{{ route('teachers.classroom.message', $classroom) }}" method="POST" class="chat-form">
                        @csrf
                        <input type="text" name="message" placeholder="Post a message or announcement to the class..." required>
                        <button type="submit">Post</button>
                    </form>
                </div>
            </div>

            <!-- Right Sidebar Column -->
            <div>
                <!-- Enrolled Students Roster -->
                <div class="card">
                    <div class="card-header">
                        <h2>👨‍🎓 Enrolled Students ({{ $classroom->students->count() }})</h2>
                    </div>
                    @if ($classroom->students->isEmpty())
                        <p class="empty-text">No students enrolled yet. Share code <strong>{{ $classroom->code }}</strong> with students.</p>
                    @else
                        <table>
                            <tbody>
                                @foreach ($classroom->students as $student)
                                    <tr>
                                        <td>
                                            <div style="font-weight: 700;">{{ $student->name }}</div>
                                            <div style="font-size: 11.5px; color: var(--text-secondary);">{{ $student->email }}</div>
                                        </td>
                                        <td style="text-align: right;">
                                            <div style="display: flex; justify-content: flex-end; gap: 6px; align-items: center;">
                                                <a href="{{ route('messages.index', ['user_id' => $student->id]) }}" class="btn-primary-sm" style="padding: 4px 8px; font-size: 11.5px;" title="Direct Message">
                                                    💬
                                                </a>
                                                <form action="{{ route('teachers.classroom.student.remove', [$classroom, $student]) }}" method="POST" onsubmit="return confirm('Remove {{ $student->name }} from this classroom?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-danger-sm" title="Remove student from class">&times;</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

                <!-- Issue Certificate Card -->
                <div class="card" style="border-top: 4px solid #eab308;">
                    <div class="card-header">
                        <h2 style="color: #ca8a04;">🏅 Award Official Certificate</h2>
                    </div>
                    @if ($classroom->students->isEmpty())
                        <p class="empty-text">Enroll students in this class to award completion certificates.</p>
                    @else
                        <form action="{{ route('teachers.certificate.issue', $classroom) }}" method="POST" style="display: flex; flex-direction: column; gap: 12px;">
                            @csrf
                            <div>
                                <label style="font-size: 12px; font-weight: 700; color: var(--text-secondary); display: block; margin-bottom: 4px;">Choose Student:</label>
                                <select name="student_id" required class="input-select">
                                    <option value="">-- Select Student --</option>
                                    @foreach ($classroom->students as $student)
                                        <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label style="font-size: 12px; font-weight: 700; color: var(--text-secondary); display: block; margin-bottom: 4px;">Certificate Title:</label>
                                <input type="text" name="title" value="Certificate of Completion" required class="input-text">
                            </div>

                            <button type="submit" style="background: linear-gradient(135deg, #eab308, #ca8a04); color: #fff; border: none; padding: 10px; border-radius: 8px; font-size: 13.5px; font-weight: 700; cursor: pointer; transition: all 0.15s;">
                                Award Certificate 🎓
                            </button>
                        </form>
                    @endif

                    @if ($classroom->certificates->isNotEmpty())
                        <div style="margin-top: 20px; border-top: 1px solid var(--border-color); padding-top: 14px;">
                            <h4 style="font-size: 12px; color: var(--text-secondary); margin-bottom: 8px; font-weight: 700;">Awarded Certificates ({{ $classroom->certificates->count() }}):</h4>
                            @foreach ($classroom->certificates as $cert)
                                <div class="cert-awarded-item">
                                    <strong>{{ $cert->user->name }}</strong>
                                    <div>
                                        <a href="{{ route('certificates.show', $cert) }}" target="_blank" style="color: var(--highlight); text-decoration: none; font-weight: 700;">
                                            View Certificate &rarr;
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyCode(code, btn) {
            navigator.clipboard.writeText(code).then(() => {
                const originalText = btn.textContent;
                btn.textContent = '✓ Copied!';
                btn.style.background = '#10b981';
                btn.style.color = '#ffffff';
                setTimeout(() => {
                    btn.textContent = originalText;
                    btn.style.background = '';
                    btn.style.color = '';
                }, 2000);
            }).catch(err => {
                alert('Class code: ' + code);
            });
        }

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

            const msgDiv = document.createElement('div');
            msgDiv.className = `chat-message ${isMine ? 'teacher-msg' : 'student-msg'}`;
            msgDiv.innerHTML = `
                <div style="font-size: 11px; margin-bottom: 3px; font-weight: 700; opacity: 0.85;">
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

        // Listen for Real-Time Messages on the Classroom Channel
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
                        <a href="${url}" download class="btn-download-sm" style="display:inline-flex; font-size: 13px; padding: 8px 16px;">Download to View &darr;</a>
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
                    <a id="previewDownloadBtn" href="#" download class="btn-download-sm" style="text-decoration:none; padding: 5px 10px; font-size: 11.5px;">Download &darr;</a>
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


