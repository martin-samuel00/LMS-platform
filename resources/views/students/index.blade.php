<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal - Classroom Hub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
            font-size: 18px;
            font-weight: 800;
            color: var(--highlight);
            text-decoration: none;
            letter-spacing: -0.3px;
        }

        .brand-badge {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #fff;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
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

        .nav-link.active {
            color: var(--highlight);
            background: var(--accent-glow);
        }

        .badge-counter {
            background: #ef4444;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 999px;
            box-shadow: 0 2px 4px rgba(239, 68, 68, 0.4);
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

        .btn-theme-toggle:hover {
            background: var(--border-color);
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
            max-width: 1160px;
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
            animation: slideDown 0.3s ease;
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

        /* Hero Banner */
        .student-hero {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #4338ca 100%);
            border-radius: 20px;
            padding: 32px 36px;
            color: #fff;
            margin-bottom: 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 24px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 12px 30px -10px rgba(67, 56, 202, 0.4);
        }

        .student-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.3) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero-left h1 {
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 6px;
            color: #ffffff;
        }

        .hero-left p {
            color: #c7d2fe;
            font-size: 14.5px;
            max-width: 580px;
            line-height: 1.5;
        }

        .hero-stats {
            display: flex;
            gap: 14px;
            position: relative;
            z-index: 1;
        }

        .hero-stat-pill {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 12px 20px;
            border-radius: 12px;
            text-align: center;
            min-width: 90px;
        }

        .hero-stat-pill .num {
            font-size: 22px;
            font-weight: 800;
            color: #fff;
            display: block;
        }

        .hero-stat-pill .label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #e0e7ff;
            font-weight: 600;
        }

        /* Top Action Cards: Code Join & Search Teachers */
        .top-action-bar {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 28px;
        }

        .action-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 24px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
            position: relative;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .action-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        }

        .action-card.code-card {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            color: #ffffff;
            border: none;
            box-shadow: 0 8px 20px -4px rgba(79, 70, 229, 0.35);
        }

        .code-card h3 {
            color: #ffffff;
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .code-card p {
            color: #e0e7ff;
            font-size: 13.5px;
            line-height: 1.4;
        }

        .join-form {
            display: flex;
            gap: 10px;
            margin-top: 18px;
        }

        .join-form input {
            flex: 1;
            padding: 12px 16px;
            border-radius: 10px;
            border: none;
            font-size: 15px;
            text-transform: uppercase;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-align: center;
            outline: none;
            background: #ffffff;
            color: #1e1b4b;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
        }

        .join-form input::placeholder {
            font-weight: 500;
            letter-spacing: 0;
            color: #94a3b8;
            font-size: 13px;
        }

        .btn-join {
            background: #10b981;
            color: #ffffff;
            border: none;
            padding: 12px 22px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.15s;
            box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);
        }

        .btn-join:hover {
            background: #059669;
            transform: scale(1.02);
        }

        .action-card.search-card h3 {
            font-size: 18px;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .action-card.search-card p {
            font-size: 13.5px;
            color: var(--text-secondary);
            line-height: 1.4;
        }

        .btn-search-teachers {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: var(--accent-glow);
            color: var(--highlight);
            border: 1.5px solid var(--border-color);
            padding: 12px 18px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            margin-top: 18px;
            transition: all 0.15s;
        }

        .btn-search-teachers:hover {
            background: var(--highlight);
            color: #ffffff;
            border-color: var(--highlight);
        }

        /* Pending Join Requests Alert Card */
        .pending-card {
            background: rgba(245, 158, 11, 0.08);
            border: 1px solid rgba(245, 158, 11, 0.3);
            border-left: 5px solid #f59e0b;
            border-radius: 14px;
            padding: 20px 24px;
            margin-bottom: 28px;
        }

        .pending-card h2 {
            font-size: 16px;
            font-weight: 700;
            color: #d97706;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .pending-item {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 12px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .pending-item:last-child {
            margin-bottom: 0;
        }

        /* 2-Column Layout */
        .layout-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 28px;
        }

        /* Standard Cards */
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

        /* Enrolled Classrooms Grid */
        .classes-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .class-card {
            background: var(--card-bg);
            border: 1.5px solid var(--border-color);
            border-radius: 14px;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            transition: all 0.2s;
            position: relative;
        }

        .class-card:hover {
            border-color: var(--highlight);
            box-shadow: 0 6px 18px var(--accent-glow);
            transform: translateY(-2px);
        }

        .class-info-wrap {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .class-avatar {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 800;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.25);
        }

        .class-details h3 {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .class-meta {
            font-size: 12.5px;
            color: var(--text-secondary);
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
        }

        .meta-pill {
            background: var(--card-subtle);
            padding: 2px 8px;
            border-radius: 6px;
            font-weight: 600;
        }

        .btn-enter {
            background: var(--highlight);
            color: #ffffff;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.15s;
            flex-shrink: 0;
        }

        .btn-enter:hover {
            background: var(--highlight-hover);
            transform: translateX(2px);
        }

        /* Due Assignments */
        .due-assignment-item {
            background: rgba(245, 158, 11, 0.08);
            border: 1px solid rgba(245, 158, 11, 0.25);
            border-left: 4px solid #f59e0b;
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }

        .due-assignment-item:last-child {
            margin-bottom: 0;
        }

        .btn-submit-work {
            background: #f59e0b;
            color: #ffffff;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 12.5px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            flex-shrink: 0;
            transition: all 0.15s;
        }

        .btn-submit-work:hover {
            background: #d97706;
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

        .badge-pass {
            background: #dcfce7;
            color: #15803d;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 11.5px;
            font-weight: 700;
        }

        .badge-fail {
            background: #fee2e2;
            color: #b91c1c;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 11.5px;
            font-weight: 700;
        }

        [data-theme="dark"] .badge-pass {
            background: rgba(21, 128, 61, 0.25);
            color: #86efac;
        }

        [data-theme="dark"] .badge-fail {
            background: rgba(185, 28, 28, 0.25);
            color: #fca5a5;
        }

        /* Certificate Item */
        .cert-item {
            background: linear-gradient(135deg, rgba(234, 179, 8, 0.1) 0%, rgba(202, 138, 4, 0.05) 100%);
            border: 1.5px dashed #facc15;
            border-radius: 14px;
            padding: 18px;
            margin-bottom: 14px;
            position: relative;
            transition: all 0.2s;
        }

        .cert-item:hover {
            border-color: #ca8a04;
            transform: translateY(-2px);
            box-shadow: 0 4px 14px rgba(234, 179, 8, 0.2);
        }

        .cert-item h4 {
            font-size: 15px;
            color: #ca8a04;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        [data-theme="dark"] .cert-item h4 {
            color: #fde047;
        }

        .cert-item p {
            font-size: 12.5px;
            color: var(--text-secondary);
            margin: 6px 0 12px;
        }

        .btn-view-cert {
            font-size: 12.5px;
            color: var(--highlight);
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .btn-view-cert:hover {
            text-decoration: underline;
        }

        /* Empty States */
        .empty-state {
            text-align: center;
            padding: 36px 20px;
            color: var(--text-secondary);
        }

        .empty-state .icon {
            font-size: 42px;
            margin-bottom: 10px;
            display: inline-block;
        }

        .empty-state h4 {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .empty-state p {
            font-size: 13.5px;
            max-width: 380px;
            margin: 0 auto;
            line-height: 1.5;
        }

        @media (max-width: 900px) {
            .top-action-bar, .layout-grid {
                grid-template-columns: 1fr;
            }
            .student-hero {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <!-- Top Navigation -->
    <nav class="navbar">
        <a href="{{ route('dashboard') }}" class="nav-brand">
            <span class="brand-badge">🎓</span>
            <span>Classroom Hub</span>
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
            <a href="{{ route('students.teachers.search') }}" class="nav-link">
                <span>🔍</span>
                <span>Find Teachers</span>
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
        <!-- Flash messages -->
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

        <!-- Student Hero Banner -->
        <div class="student-hero">
            <div class="hero-left">
                <h1>Welcome back, {{ Auth::user()->name }}! 🚀</h1>
                <p>Track your assignments, take course quizzes, download study materials, and access your virtual classrooms all in one place.</p>
            </div>
            <div class="hero-stats">
                <div class="hero-stat-pill">
                    <span class="num">{{ $enrolledClassrooms->count() }}</span>
                    <span class="label">Classes</span>
                </div>
                <div class="hero-stat-pill">
                    <span class="num">{{ $dueAssignments->count() }}</span>
                    <span class="label">Due Work</span>
                </div>
                <div class="hero-stat-pill">
                    <span class="num">{{ $certificates->count() }}</span>
                    <span class="label">Awards</span>
                </div>
            </div>
        </div>

        <!-- Action Strip: Fast Join via Code OR Search Directory -->
        <div class="top-action-bar">
            <!-- 1. Code Join -->
            <div class="action-card code-card">
                <div>
                    <h3>⚡ Instant Class Code Join</h3>
                    <p>Received a 6-character code from your teacher? Enter it below to join the classroom immediately!</p>
                </div>
                <form action="{{ route('students.classroom.join') }}" method="POST" class="join-form">
                    @csrf
                    <input type="text" name="code" placeholder="CODE (e.g. MTH101)" maxlength="10" required>
                    <button type="submit" class="btn-join">Join Now &rarr;</button>
                </form>
            </div>

            <!-- 2. Search Teachers & Send Request -->
            <div class="action-card search-card">
                <div>
                    <h3>🔍 Discover Instructors & Classrooms</h3>
                    <p>Looking for a specific subject or teacher? Browse the directory to request enrollment directly.</p>
                </div>
                <a href="{{ route('students.teachers.search') }}" class="btn-search-teachers">
                    <span>Explore Teacher Directory &rarr;</span>
                </a>
            </div>
        </div>

        <!-- Pending Join Requests (If Any) -->
        @if ($pendingClassrooms->isNotEmpty())
            <div class="pending-card">
                <h2>⏳ Pending Enrollment Requests ({{ $pendingClassrooms->count() }})</h2>
                <div>
                    @foreach ($pendingClassrooms as $p)
                        <div class="pending-item">
                            <div>
                                <strong style="font-size: 14.5px; color: var(--text-primary);">{{ $p->name }}</strong>
                                <div style="font-size: 12px; color: var(--text-secondary); margin-top: 2px;">
                                    Instructor: <strong>{{ $p->teacher->name }}</strong> &bull; Subject: {{ $p->subject ?? 'General' }}
                                </div>
                            </div>
                            <span style="font-size: 12px; color: #b45309; font-weight: 700; background: rgba(245, 158, 11, 0.15); padding: 4px 10px; border-radius: 6px;">
                                Awaiting Teacher Approval
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Main 2-Column Content Layout -->
        <div class="layout-grid">
            <!-- Left Main Column -->
            <div>
                <!-- Enrolled Classes -->
                <div class="card">
                    <div class="card-header">
                        <h2>📚 My Enrolled Classrooms ({{ $enrolledClassrooms->count() }})</h2>
                        <a href="{{ route('students.teachers.search') }}" style="font-size: 13px; color: var(--highlight); font-weight: 600; text-decoration: none;">+ Find More Classes</a>
                    </div>
                    @if ($enrolledClassrooms->isEmpty())
                        <div class="empty-state">
                            <span class="icon">📖</span>
                            <h4>No Classrooms Enrolled Yet</h4>
                            <p>You haven't joined any classes yet. Use a class code above or explore the teacher directory to start learning!</p>
                        </div>
                    @else
                        <div class="classes-grid">
                            @foreach ($enrolledClassrooms as $c)
                                <div class="class-card">
                                    <div class="class-info-wrap">
                                        <div class="class-avatar">{{ substr($c->name, 0, 1) }}</div>
                                        <div class="class-details">
                                            <h3>{{ $c->name }}</h3>
                                            <div class="class-meta">
                                                <span>Instructor: <strong>{{ $c->teacher->name }}</strong></span>
                                                <span class="meta-pill">📝 {{ $c->assignments_count }} Assignments</span>
                                                <span class="meta-pill">🎯 {{ $c->quizzes_count }} Quizzes</span>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ route('students.classroom', $c) }}" class="btn-enter">
                                        <span>Enter Class</span>
                                        <span>&rarr;</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Upcoming Assignments Due -->
                @if ($dueAssignments->isNotEmpty())
                    <div class="card" style="border-top: 4px solid #f59e0b;">
                        <div class="card-header">
                            <h2 style="color: #d97706;">⏰ Assignments Due Soon ({{ $dueAssignments->count() }})</h2>
                        </div>
                        <div>
                            @foreach ($dueAssignments as $due)
                                <div class="due-assignment-item">
                                    <div>
                                        <strong style="font-size: 14.5px; color: var(--text-primary); display: block; margin-bottom: 2px;">{{ $due->title }}</strong>
                                        <div style="font-size: 12.5px; color: var(--text-secondary);">
                                            Course: <strong>{{ $due->classroom->name }}</strong> &bull; Due: <span style="color: #b45309; font-weight: 700;">{{ $due->due_date->diffForHumans() }}</span> ({{ $due->due_date->format('M d, h:i A') }})
                                        </div>
                                    </div>
                                    <a href="{{ route('students.classroom', $due->classroom) }}" class="btn-submit-work">
                                        <span>Submit Work</span>
                                        <span>&rarr;</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Recent Quiz Attempts -->
                <div class="card">
                    <div class="card-header">
                        <h2>📊 Recent Quiz Results</h2>
                    </div>
                    @if ($submissions->isEmpty())
                        <div class="empty-state">
                            <span class="icon">🎯</span>
                            <h4>No Quiz Attempts Yet</h4>
                            <p>Once you take quizzes inside your enrolled classrooms, your scores and completion records will appear here.</p>
                        </div>
                    @else
                        <table>
                            <thead>
                                <tr>
                                    <th>Quiz Title</th>
                                    <th>Classroom</th>
                                    <th>Score</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($submissions as $sub)
                                    <tr>
                                        <td><strong>{{ $sub->quiz->title }}</strong></td>
                                        <td style="color: var(--text-secondary);">{{ $sub->quiz->classroom->name }}</td>
                                        <td><strong>{{ $sub->score }}/{{ $sub->total_questions }}</strong> ({{ $sub->percentage }}%)</td>
                                        <td>
                                            @if ($sub->passed)
                                                <span class="badge-pass">Passed &check;</span>
                                            @else
                                                <span class="badge-fail">Failed &cross;</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

            <!-- Right Sidebar Column -->
            <div>
                <!-- Earned Certificates -->
                <div class="card" style="border-top: 4px solid #eab308;">
                    <div class="card-header">
                        <h2 style="color: #ca8a04;">🏅 My Certificates ({{ $certificates->count() }})</h2>
                    </div>
                    @if ($certificates->isEmpty())
                        <div class="empty-state">
                            <span class="icon">🏆</span>
                            <h4>No Certificates Yet</h4>
                            <p style="font-size: 12.5px;">Complete course quizzes and assignments to receive verified certificates of completion from your instructors!</p>
                        </div>
                    @else
                        @foreach ($certificates as $cert)
                            <div class="cert-item">
                                <h4>
                                    <span>🎓</span>
                                    <span>{{ $cert->title }}</span>
                                </h4>
                                <p>{{ $cert->classroom->name }} &bull; Teacher: {{ $cert->classroom->teacher->name }}</p>
                                <a href="{{ route('certificates.show', $cert) }}" target="_blank" class="btn-view-cert">
                                    <span>View / Print Certificate</span>
                                    <span>&rarr;</span>
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Learning Resources Tip Box -->
                <div class="card" style="background: var(--card-subtle);">
                    <h3 style="font-size: 15px; font-weight: 700; margin-bottom: 8px; color: var(--text-primary);">💡 Study Tips</h3>
                    <p style="font-size: 13px; color: var(--text-secondary); line-height: 1.5; margin-bottom: 12px;">
                        Check your classroom's <strong>Study Materials</strong> tab regularly for lecture slides and notes uploaded by your instructors.
                    </p>
                    <div style="font-size: 12.5px; color: var(--highlight); font-weight: 600;">
                        Need help? You can message your instructor directly from any classroom page!
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
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

        updateThemeButton();
    </script>
</body>
</html>
