<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discover Teachers & Classrooms - Classroom Hub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/responsive-hub.css') }}">
    <script src="{{ asset('js/responsive-hub.js') }}" defer></script>
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
            background: var(--bg-color);
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

        /* Container */
        .container {
            max-width: 960px;
            margin: 32px auto;
            padding: 0 20px;
        }

        .alert-success {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 500;
        }

        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 500;
        }

        /* Search Hero Banner */
        .search-hero {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 45%, #4338ca 100%);
            color: #ffffff;
            border-radius: 20px;
            padding: 38px 32px;
            margin-bottom: 32px;
            text-align: center;
            box-shadow: 0 10px 28px -8px rgba(67, 56, 202, 0.35);
        }

        .search-hero h1 {
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 8px;
            color: #ffffff;
        }

        .search-hero p {
            color: #c7d2fe;
            font-size: 14px;
            margin-bottom: 24px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .search-bar {
            max-width: 560px;
            margin: 0 auto;
            display: flex;
            gap: 10px;
            background: #ffffff;
            padding: 6px;
            border-radius: 14px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .search-bar input {
            flex: 1;
            padding: 12px 16px;
            border: none;
            font-size: 14.5px;
            outline: none;
            background: transparent;
            color: #0f172a;
        }

        .search-bar button {
            background: #10b981;
            color: #ffffff;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.15s;
        }

        .search-bar button:hover {
            background: #059669;
        }

        /* Teacher Card */
        .teacher-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.02);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .teacher-card:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.04);
        }

        .teacher-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 18px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 16px;
        }

        .teacher-avatar {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 800;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.25);
        }

        .teacher-info h2 {
            font-size: 17px;
            font-weight: 800;
            color: var(--text-primary);
        }

        .teacher-info p {
            font-size: 12.5px;
            color: var(--text-secondary);
        }

        .classroom-list {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .class-row {
            background: var(--card-subtle);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 16px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            transition: all 0.15s;
        }

        .class-row:hover {
            border-color: var(--highlight);
        }

        .class-row h3 {
            font-size: 15.5px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 3px;
        }

        .class-row p {
            font-size: 12.5px;
            color: var(--text-secondary);
        }

        .btn-request {
            background: var(--highlight);
            color: #ffffff;
            border: none;
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.15s;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.25);
            white-space: nowrap;
        }

        .btn-request:hover {
            background: var(--highlight-hover);
        }

        .badge-enrolled {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            white-space: nowrap;
        }

        [data-theme="dark"] .badge-enrolled {
            background: rgba(21, 128, 61, 0.25);
            color: #86efac;
            border-color: #047857;
        }

        .badge-pending {
            background: #fef3c7;
            color: #b45309;
            border: 1px solid #fde68a;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 700;
            white-space: nowrap;
        }

        [data-theme="dark"] .badge-pending {
            background: rgba(180, 83, 9, 0.25);
            color: #fde68a;
            border-color: #92400e;
        }

        .empty-state {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 50px 20px;
            text-align: center;
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
        }

        .empty-state .icon {
            font-size: 44px;
            margin-bottom: 12px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('students.index') }}" class="nav-brand">
            <span>&larr;</span>
            <span>Back to Student Hub</span>
        </a>
        <button type="button" class="mobile-nav-toggle" aria-label="Toggle navigation">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>
        <div class="nav-links">
            <button type="button" onclick="toggleTheme()" class="btn-theme-toggle" title="Toggle Light/Dark Theme">
                <span id="theme-icon">🌙</span>
            </button>
            <a href="{{ route('dashboard') }}" class="nav-link">
                <span>Dashboard</span>
            </a>
            <a href="{{ route('profile.show') }}" class="nav-link">
                <span>Profile</span>
            </a>
        </div>
    </nav>

    <div class="container">
        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <div class="search-hero">
            <h1>Discover Teachers & Classrooms</h1>
            <p>Search for your instructors, explore available subjects, and request to enroll in classrooms.</p>
            <form action="{{ route('students.teachers.search') }}" method="GET" class="search-bar">
                <input type="text" name="q" value="{{ $query }}" placeholder="Search by instructor name, subject, or keyword...">
                <button type="submit">Search Directory</button>
            </form>
        </div>

        @if ($teachers->isEmpty())
            <div class="empty-state">
                <span class="icon">🔍</span>
                <h3 style="font-size: 18px; font-weight: 700; color: var(--text-primary); margin-bottom: 6px;">No Teachers Found</h3>
                <p style="font-size: 14px;">No instructors found matching "{{ $query }}". Try searching for another name or keyword.</p>
            </div>
        @else
            @foreach ($teachers as $teacher)
                <div class="teacher-card">
                    <div class="teacher-header">
                        <div class="teacher-avatar">{{ substr($teacher->name, 0, 1) }}</div>
                        <div class="teacher-info">
                            <h2>{{ $teacher->name }}</h2>
                            <p>{{ $teacher->email }} &bull; {{ $teacher->taughtClassrooms->count() }} Classrooms Available</p>
                        </div>
                    </div>

                    @if ($teacher->taughtClassrooms->isEmpty())
                        <p style="color: var(--text-secondary); font-size: 13.5px; padding: 12px;">This instructor hasn't published any classrooms yet.</p>
                    @else
                        <div class="classroom-list">
                            @foreach ($teacher->taughtClassrooms as $class)
                                <div class="class-row">
                                    <div>
                                        <h3>{{ $class->name }}</h3>
                                        <p>{{ $class->subject ?? 'General Curriculum' }} &bull; {{ $class->students_count }} enrolled students</p>
                                        @if ($class->description)
                                            <p style="margin-top: 4px; color: var(--text-secondary);">{{ $class->description }}</p>
                                        @endif
                                    </div>
                                    <div>
                                        @if (in_array($class->id, $enrolledClassroomIds))
                                            <a href="{{ route('students.classroom', $class) }}" class="badge-enrolled">
                                                Enrolled &check; Enter Class &rarr;
                                            </a>
                                        @elseif (in_array($class->id, $pendingClassroomIds))
                                            <span class="badge-pending">⏳ Request Pending</span>
                                        @else
                                            <form action="{{ route('students.classroom.request-join', $class) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn-request">Request to Join &rarr;</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
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
