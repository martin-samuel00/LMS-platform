<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Classroom Hub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
            --surface: #ffffff;
            --surface-subtle: #f1f5f9;
            --border: #e2e8f0;
            --border-hover: #cbd5e1;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --primary-light: #eef2ff;
            --primary-glow: rgba(79, 70, 229, 0.08);
            --success: #10b981;
            --success-light: #ecfdf5;
            --warning: #f59e0b;
            --warning-light: #fffbeb;
            --danger: #ef4444;
            --card-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.04), 0 1px 2px -1px rgba(0, 0, 0, 0.04);
            --card-hover-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.08);
        }

        [data-theme="dark"] {
            --bg-color: #090d16;
            --surface: #111827;
            --surface-subtle: #1a2234;
            --border: #1f2937;
            --border-hover: #374151;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --primary-light: rgba(99, 102, 241, 0.15);
            --primary-glow: rgba(99, 102, 241, 0.15);
            --success: #34d399;
            --success-light: rgba(16, 185, 129, 0.15);
            --warning: #fbbf24;
            --warning-light: rgba(245, 158, 11, 0.15);
            --danger: #f87171;
            --card-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.35);
            --card-hover-shadow: 0 12px 30px -4px rgba(0, 0, 0, 0.5);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            transition: background-color 0.15s ease, border-color 0.15s ease;
        }

        h1, h2, h3, h4, .brand-font {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Executive Header */
        .top-navbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 12px 36px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 50;
            backdrop-filter: blur(12px);
        }

        .brand-link {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--text-main);
            font-weight: 800;
            font-size: 17px;
            letter-spacing: -0.4px;
        }

        .brand-chip {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: var(--primary);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            color: var(--text-muted);
            border: 1px solid transparent;
            transition: all 0.15s;
        }

        .header-pill:hover {
            color: var(--text-main);
            background: var(--surface-subtle);
            border-color: var(--border);
        }

        .header-pill.active {
            color: var(--primary);
            background: var(--primary-light);
            border-color: rgba(99, 102, 241, 0.2);
            font-weight: 700;
        }

        .btn-theme-chip {
            background: var(--surface-subtle);
            border: 1px solid var(--border);
            color: var(--text-main);
            padding: 6px 12px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 12.5px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-logout-chip {
            background: none;
            border: 1px solid var(--border);
            color: var(--danger);
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.15s;
        }

        .btn-logout-chip:hover {
            background: rgba(239, 68, 68, 0.1);
            border-color: var(--danger);
        }

        /* Container & Page Header */
        .dash-container {
            max-width: 1180px;
            margin: 28px auto 60px;
            padding: 0 24px;
            width: 100%;
        }

        .dash-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .dash-header-title h1 {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--text-main);
            margin-bottom: 4px;
        }

        .dash-header-title p {
            font-size: 14px;
            color: var(--text-muted);
        }

        .dash-header-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .btn-primary-action {
            background: var(--primary);
            color: #ffffff;
            padding: 10px 18px;
            border-radius: 9px;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.15s;
            box-shadow: 0 2px 6px rgba(79, 70, 229, 0.25);
        }

        .btn-primary-action:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        .btn-secondary-action {
            background: var(--surface);
            color: var(--text-main);
            border: 1px solid var(--border);
            padding: 9px 16px;
            border-radius: 9px;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.15s;
        }

        .btn-secondary-action:hover {
            border-color: var(--text-muted);
            background: var(--surface-subtle);
        }

        /* Banner Card */
        .identity-banner {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 20px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            box-shadow: var(--card-shadow);
            flex-wrap: wrap;
            gap: 16px;
        }

        .identity-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .identity-avatar {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid var(--border);
            flex-shrink: 0;
            background: var(--surface-subtle);
        }

        .identity-meta h2 {
            font-size: 17px;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 2px;
        }

        .identity-handle {
            font-size: 13px;
            color: var(--primary);
            font-weight: 700;
            font-family: monospace;
        }

        .identity-tags {
            display: flex;
            gap: 8px;
            margin-top: 6px;
            align-items: center;
        }

        .tag-pill {
            font-size: 11px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .tag-role {
            background: var(--primary-light);
            color: var(--primary);
            border: 1px solid rgba(99, 102, 241, 0.2);
        }

        .tag-verified {
            background: var(--success-light);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .tag-unverified {
            background: var(--warning-light);
            color: var(--warning);
            border: 1px solid rgba(245, 158, 11, 0.2);
        }

        /* KPI Cards Grid */
        .kpi-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .kpi-box {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 18px 20px;
            box-shadow: var(--card-shadow);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: border-color 0.15s, transform 0.15s;
        }

        .kpi-box:hover {
            border-color: var(--border-hover);
            transform: translateY(-1px);
        }

        .kpi-info-label {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .kpi-info-val {
            font-size: 26px;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.5px;
            line-height: 1;
        }

        .kpi-chip-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        /* Main Workspace 2-Column Split */
        .workspace-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
        }

        .panel-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 24px;
            box-shadow: var(--card-shadow);
            margin-bottom: 24px;
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border);
        }

        .panel-header h3 {
            font-size: 16px;
            font-weight: 800;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .panel-link {
            font-size: 12.5px;
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
        }

        .panel-link:hover {
            text-decoration: underline;
        }

        /* Modern Workspace Modules */
        .module-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .module-item {
            background: var(--surface-subtle);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            text-decoration: none;
            color: var(--text-main);
            transition: all 0.15s;
        }

        .module-item:hover {
            border-color: var(--primary);
            background: var(--surface);
            transform: translateX(2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }

        .module-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .module-icon-wrap {
            width: 38px;
            height: 38px;
            border-radius: 9px;
            background: var(--surface);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .module-text h4 {
            font-size: 14.5px;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 3px;
        }

        .module-text p {
            font-size: 12.5px;
            color: var(--text-muted);
            line-height: 1.4;
        }

        .module-arrow {
            color: var(--text-muted);
            font-size: 14px;
            font-weight: 700;
            transition: transform 0.15s;
        }

        .module-item:hover .module-arrow {
            color: var(--primary);
            transform: translateX(3px);
        }

        /* Classroom Items */
        .class-mini-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .class-mini-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 14px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: border-color 0.15s;
        }

        .class-mini-card:hover {
            border-color: var(--primary);
        }

        .class-mini-name {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 2px;
        }

        .class-mini-sub {
            font-size: 12px;
            color: var(--text-muted);
        }

        .btn-mini-enter {
            font-size: 12px;
            font-weight: 700;
            color: #ffffff;
            background: var(--primary);
            padding: 6px 12px;
            border-radius: 7px;
            text-decoration: none;
            transition: background-color 0.15s;
        }

        .btn-mini-enter:hover {
            background: var(--primary-hover);
        }

        /* Account Details Strip */
        .account-details-grid {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid var(--border);
            font-size: 13px;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: var(--text-muted);
            font-weight: 600;
        }

        .detail-value {
            font-weight: 700;
            color: var(--text-main);
        }

        /* Alerts */
        .alert-banner {
            border-radius: 10px;
            padding: 12px 18px;
            font-size: 13.5px;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .alert-banner.success {
            background: var(--success-light);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .alert-banner.warning {
            background: var(--warning-light);
            color: #b45309;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        @media (max-width: 900px) {
            .workspace-grid {
                grid-template-columns: 1fr;
            }
            .kpi-row {
                grid-template-columns: repeat(2, 1fr);
            }
            .top-navbar {
                padding: 12px 20px;
            }
        }

        @media (max-width: 600px) {
            .kpi-row {
                grid-template-columns: 1fr;
            }
            .identity-banner {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    @php
        $user = Auth::user();
        $isTeacher = $user->isTeacher();
        $isStudent = !$isTeacher && !$user->isAdmin();
        $isAdmin = $user->isAdmin();

        $unreadNotesCount = 0;
        $unreadMessagesCount = 0;
        $classroomsCount = 0;
        $pendingRequestsCount = 0;
        $totalQuizzesCount = 0;
        $enrolledCount = 0;
        $quizSubmissionsCount = 0;
        $certsCount = 0;
        $myClassrooms = collect();

        try {
            $unreadNotesCount = $user->unreadNotifications()->count();
            $unreadMessagesCount = $user->receivedDirectMessages()->where('is_read', false)->count();

            if ($isTeacher) {
                $taughtClassrooms = $user->taughtClassrooms()->withCount('students')->latest()->get();
                $classroomsCount = $taughtClassrooms->count();
                $myClassrooms = $taughtClassrooms->take(4);
                $taughtIds = $taughtClassrooms->pluck('id');
                if ($taughtIds->isNotEmpty()) {
                    $pendingRequestsCount = \DB::table('classroom_user')->whereIn('classroom_id', $taughtIds)->where('status', 'pending')->count();
                    $totalQuizzesCount = \App\Models\Quiz::whereIn('classroom_id', $taughtIds)->count();
                }
            } elseif ($isStudent) {
                $enrolledClassrooms = $user->enrolledClassrooms()->with('teacher')->latest()->get();
                $enrolledCount = $enrolledClassrooms->count();
                $myClassrooms = $enrolledClassrooms->take(4);
                $quizSubmissionsCount = $user->quizSubmissions()->count();
                $certsCount = $user->certificates()->count();
            }
        } catch (\Throwable $e) {}
    @endphp

    <!-- Professional Top Bar -->
    <header class="top-navbar">
        <a href="{{ route('dashboard') }}" class="brand-link">
            <div class="brand-chip">🎓</div>
            <span>Classroom Hub</span>
        </a>
        <button type="button" class="mobile-nav-toggle" aria-label="Toggle navigation">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>
        <div class="header-actions">
            <button onclick="toggleTheme()" class="btn-theme-chip" title="Toggle Theme">
                <span id="theme-icon">🌙</span>
            </button>

            <a href="{{ route('notifications.index') }}" class="header-pill" title="Notifications">
                <span>🔔</span>
                @if ($unreadNotesCount > 0)
                    <span style="background: #ef4444; color: #fff; border-radius: 999px; padding: 2px 6px; font-size: 10px; font-weight: 800;">{{ $unreadNotesCount }}</span>
                @endif
            </a>

            <a href="{{ route('messages.index') }}" class="header-pill" title="Direct Messages">
                <span>💬</span>
                @if ($unreadMessagesCount > 0)
                    <span style="background: var(--primary); color: #fff; border-radius: 999px; padding: 2px 6px; font-size: 10px; font-weight: 800;">{{ $unreadMessagesCount }}</span>
                @endif
            </a>

            <!-- STRICT PORTAL NAVIGATION ISOLATION -->
            @if ($isTeacher)
                <a href="{{ route('teachers.index') }}" class="header-pill active">
                    <span>👩‍🏫</span> Teaching Portal
                </a>
            @elseif ($isStudent)
                <a href="{{ route('students.index') }}" class="header-pill active">
                    <span>👨‍🎓</span> Learning Portal
                </a>
            @endif

            @if ($isAdmin)
                <a href="{{ route('admin.index') }}" class="header-pill" style="color: #ef4444; font-weight: 700; background: rgba(239, 68, 68, 0.1);">
                    <span>🛡️</span> Admin
                </a>
            @endif

            <a href="{{ route('profile.show') }}" class="header-pill">
                <span>⚙️</span> Settings
            </a>

            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout-chip">Log Out</button>
            </form>
        </div>
    </header>

    <main class="dash-container">
        <!-- Flash Alerts -->
        @if (session('success'))
            <div class="alert-banner success">
                <div>&check; {{ session('success') }}</div>
            </div>
        @endif

        @if (!$user->hasVerifiedEmail())
            <div class="alert-banner warning">
                <div>
                    <strong>✉️ Verification Pending:</strong> Please confirm your email address to access all academic features.
                </div>
                <div style="display: flex; gap: 8px;">
                    @if (session('direct_verify_url'))
                        <a href="{{ session('direct_verify_url') }}" style="background: #059669; color: #fff; padding: 6px 14px; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 700;">Instant Verify &rarr;</a>
                    @else
                        <a href="{{ route('verification.notice') }}" style="background: #d97706; color: #fff; padding: 6px 14px; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 700;">Verify Email &rarr;</a>
                    @endif
                </div>
            </div>
        @endif

        <!-- Executive Dashboard Header -->
        <div class="dash-header">
            <div class="dash-header-title">
                <h1>Overview</h1>
                <p>Welcome back, {{ $user->name }}. Here is a summary of your academic spaces.</p>
            </div>
            <div class="dash-header-actions">
                @if ($isTeacher)
                    <a href="{{ route('teachers.index') }}" class="btn-primary-action">
                        <span>+</span> Create Classroom
                    </a>
                @elseif ($isStudent)
                    <a href="{{ route('students.teachers.search') }}" class="btn-primary-action">
                        <span>🔍</span> Find Classrooms
                    </a>
                @endif
                <a href="{{ route('profile.show') }}" class="btn-secondary-action">
                    <span>⚙️</span> Edit Profile
                </a>
            </div>
        </div>

        <!-- Identity Banner Card -->
        <div class="identity-banner">
            <div class="identity-left">
                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="identity-avatar">
                <div class="identity-meta">
                    <h2>{{ $user->name }}</h2>
                    <span class="identity-handle">&#64;{{ $user->username ?: 'user' . $user->id }}</span>
                    <div class="identity-tags">
                        <span class="tag-pill tag-role">
                            @if($isAdmin) Platform Admin
                            @elseif($isTeacher) Instructor
                            @else Student
                            @endif
                        </span>
                        @if ($user->hasVerifiedEmail())
                            <span class="tag-pill tag-verified">&check; Verified</span>
                        @else
                            <span class="tag-pill tag-unverified">&times; Pending Verification</span>
                        @endif
                    </div>
                </div>
            </div>

            <div>
                <a href="{{ route('profile.show') }}" style="font-size: 13px; color: var(--primary); font-weight: 700; text-decoration: none;">Change Avatar &rarr;</a>
            </div>
        </div>

        <!-- Executive KPI Numbers Row -->
        <div class="kpi-row">
            @if ($isTeacher)
                <div class="kpi-box">
                    <div>
                        <div class="kpi-info-label">Active Classrooms</div>
                        <div class="kpi-info-val">{{ $classroomsCount }}</div>
                    </div>
                    <div class="kpi-chip-icon" style="background: rgba(79, 70, 229, 0.1); color: #4f46e5;">🏫</div>
                </div>
                <div class="kpi-box">
                    <div>
                        <div class="kpi-info-label">Pending Requests</div>
                        <div class="kpi-info-val">{{ $pendingRequestsCount }}</div>
                    </div>
                    <div class="kpi-chip-icon" style="background: rgba(245, 158, 11, 0.1); color: #d97706;">⏳</div>
                </div>
                <div class="kpi-box">
                    <div>
                        <div class="kpi-info-label">Assessments Published</div>
                        <div class="kpi-info-val">{{ $totalQuizzesCount }}</div>
                    </div>
                    <div class="kpi-chip-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">📝</div>
                </div>
                <div class="kpi-box">
                    <div>
                        <div class="kpi-info-label">Unread Messages</div>
                        <div class="kpi-info-val">{{ $unreadMessagesCount }}</div>
                    </div>
                    <div class="kpi-chip-icon" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;">💬</div>
                </div>
            @elseif ($isStudent)
                <div class="kpi-box">
                    <div>
                        <div class="kpi-info-label">Enrolled Courses</div>
                        <div class="kpi-info-val">{{ $enrolledCount }}</div>
                    </div>
                    <div class="kpi-chip-icon" style="background: rgba(79, 70, 229, 0.1); color: #4f46e5;">📚</div>
                </div>
                <div class="kpi-box">
                    <div>
                        <div class="kpi-info-label">Quizzes Completed</div>
                        <div class="kpi-info-val">{{ $quizSubmissionsCount }}</div>
                    </div>
                    <div class="kpi-chip-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">🎯</div>
                </div>
                <div class="kpi-box">
                    <div>
                        <div class="kpi-info-label">Certificates Earned</div>
                        <div class="kpi-info-val">{{ $certsCount }}</div>
                    </div>
                    <div class="kpi-chip-icon" style="background: rgba(245, 158, 11, 0.1); color: #d97706;">📜</div>
                </div>
                <div class="kpi-box">
                    <div>
                        <div class="kpi-info-label">Unread Messages</div>
                        <div class="kpi-info-val">{{ $unreadMessagesCount }}</div>
                    </div>
                    <div class="kpi-chip-icon" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;">💬</div>
                </div>
            @else
                <div class="kpi-box">
                    <div>
                        <div class="kpi-info-label">Unread Alerts</div>
                        <div class="kpi-info-val">{{ $unreadNotesCount }}</div>
                    </div>
                    <div class="kpi-chip-icon" style="background: rgba(79, 70, 229, 0.1); color: #4f46e5;">🔔</div>
                </div>
                <div class="kpi-box">
                    <div>
                        <div class="kpi-info-label">Direct Chats</div>
                        <div class="kpi-info-val">{{ $unreadMessagesCount }}</div>
                    </div>
                    <div class="kpi-chip-icon" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;">💬</div>
                </div>
                <div class="kpi-box">
                    <div>
                        <div class="kpi-info-label">Admin Governance</div>
                        <div class="kpi-info-val">Active</div>
                    </div>
                    <div class="kpi-chip-icon" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">🛡️</div>
                </div>
                <div class="kpi-box">
                    <div>
                        <div class="kpi-info-label">Platform Status</div>
                        <div class="kpi-info-val">Online</div>
                    </div>
                    <div class="kpi-chip-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">⚡</div>
                </div>
            @endif
        </div>

        <!-- 2-Column Main Workspace -->
        <div class="workspace-grid">
            <!-- Left Primary Area -->
            <div>
                <!-- Workspaces / Hub Tools -->
                <div class="panel-card">
                    <div class="panel-header">
                        <h3><span>🗂️</span> Workspaces & Operations</h3>
                    </div>

                    <div class="module-list">
                        <!-- STRICT TEACHER ONLY MODULES -->
                        @if ($isTeacher)
                            <a href="{{ route('teachers.index') }}" class="module-item">
                                <div class="module-left">
                                    <div class="module-icon-wrap" style="color: #4f46e5;">🏫</div>
                                    <div class="module-text">
                                        <h4>Classroom Manager</h4>
                                        <p>Publish course syllabus, post assignment deadlines, and oversee student roll-call.</p>
                                    </div>
                                </div>
                                <div class="module-arrow">&rarr;</div>
                            </a>

                            <a href="{{ route('teachers.index') }}" class="module-item">
                                <div class="module-left">
                                    <div class="module-icon-wrap" style="color: #10b981;">📝</div>
                                    <div class="module-text">
                                        <h4>Multi-Format Assessment Engine</h4>
                                        <p>Create quizzes with per-question timers, matching pairs, and fill-in blanks.</p>
                                    </div>
                                </div>
                                <div class="module-arrow">&rarr;</div>
                            </a>
                        @endif

                        <!-- STRICT STUDENT ONLY MODULES -->
                        @if ($isStudent)
                            <a href="{{ route('students.index') }}" class="module-item">
                                <div class="module-left">
                                    <div class="module-icon-wrap" style="color: #4f46e5;">📚</div>
                                    <div class="module-text">
                                        <h4>My Coursework & Enrolled Classes</h4>
                                        <p>View assignments, submit homework files, check quiz marks, and view attendance.</p>
                                    </div>
                                </div>
                                <div class="module-arrow">&rarr;</div>
                            </a>

                            <a href="{{ route('students.teachers.search') }}" class="module-item">
                                <div class="module-left">
                                    <div class="module-icon-wrap" style="color: #3b82f6;">🔍</div>
                                    <div class="module-text">
                                        <h4>Find & Join Instructors</h4>
                                        <p>Explore instructor profiles, enter 6-character class codes, or request enrollment.</p>
                                    </div>
                                </div>
                                <div class="module-arrow">&rarr;</div>
                            </a>
                        @endif

                        <!-- ADMIN MODULE -->
                        @if ($isAdmin)
                            <a href="{{ route('admin.index') }}" class="module-item" style="border-left: 3px solid #ef4444;">
                                <div class="module-left">
                                    <div class="module-icon-wrap" style="color: #ef4444;">🛡️</div>
                                    <div class="module-text">
                                        <h4>Platform Admin Console</h4>
                                        <p>User account management, classroom moderation, and site-wide broadcasts.</p>
                                    </div>
                                </div>
                                <div class="module-arrow">&rarr;</div>
                            </a>
                        @endif

                        <!-- SHARED MODULES -->
                        <a href="{{ route('messages.index') }}" class="module-item">
                            <div class="module-left">
                                <div class="module-icon-wrap" style="color: #6366f1;">💬</div>
                                <div class="module-text">
                                    <h4>Direct Communication & Messages</h4>
                                    <p>One-on-one private messaging for questions, feedback, and academic guidance.</p>
                                </div>
                            </div>
                            <div class="module-arrow">&rarr;</div>
                        </a>

                        <a href="{{ route('notifications.index') }}" class="module-item">
                            <div class="module-left">
                                <div class="module-icon-wrap" style="color: #f59e0b;">🔔</div>
                                <div class="module-text">
                                    <h4>Notification Feed</h4>
                                    <p>Stay informed with assignment updates, grading alerts, and pinned announcements.</p>
                                </div>
                            </div>
                            <div class="module-arrow">&rarr;</div>
                        </a>
                    </div>
                </div>

                <!-- Recent Classrooms Preview -->
                @if ($myClassrooms->count() > 0)
                    <div class="panel-card">
                        <div class="panel-header">
                            <h3>
                                <span>{{ $isTeacher ? '🏫 Your Classes' : '📚 Enrolled Classes' }}</span>
                            </h3>
                            <a href="{{ $isTeacher ? route('teachers.index') : route('students.index') }}" class="panel-link">View All &rarr;</a>
                        </div>

                        <div class="class-mini-list">
                            @foreach ($myClassrooms as $cls)
                                <div class="class-mini-card">
                                    <div>
                                        <div class="class-mini-name">{{ $cls->name }}</div>
                                        <div class="class-mini-sub">
                                            @if ($isTeacher)
                                                Code: <strong>{{ $cls->code }}</strong> &bull; {{ $cls->students_count ?? $cls->students()->count() }} Students Enrolled
                                            @else
                                                Instructor: {{ $cls->teacher ? $cls->teacher->name : 'Staff' }}
                                            @endif
                                        </div>
                                    </div>
                                    <a href="{{ $isTeacher ? route('teachers.classroom', $cls) : route('students.classroom', $cls) }}" class="btn-mini-enter">
                                        Open &rarr;
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Sidebar Area -->
            <div>
                <!-- Security & Account Info -->
                <div class="panel-card">
                    <div class="panel-header">
                        <h3><span>🔒</span> Account Credentials</h3>
                        <a href="{{ route('profile.show') }}" class="panel-link">Settings &rarr;</a>
                    </div>

                    <div class="account-details-grid">
                        <div class="detail-row">
                            <span class="detail-label">Account Role</span>
                            <span class="detail-value">
                                @if($isAdmin) Administrator
                                @elseif($isTeacher) Instructor
                                @else Student
                                @endif
                            </span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Username</span>
                            <span class="detail-value" style="font-family: monospace;">&#64;{{ $user->username ?: 'None set' }}</span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Email Status</span>
                            <span class="detail-value">
                                @if ($user->hasVerifiedEmail())
                                    <span style="color: var(--success);">&#10003; Verified</span>
                                @else
                                    <span style="color: var(--warning);">&#9888; Pending</span>
                                @endif
                            </span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Registered Email</span>
                            <span class="detail-value" style="font-size: 12px; word-break: break-all;">{{ $user->email }}</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Help / Support Card -->
                <div class="panel-card" style="background: var(--surface-subtle);">
                    <div style="font-size: 20px; margin-bottom: 8px;">💡</div>
                    <h4 style="font-size: 14.5px; font-weight: 800; color: var(--text-main); margin-bottom: 6px;">Need Assistance?</h4>
                    <p style="font-size: 13px; color: var(--text-muted); line-height: 1.5; margin-bottom: 14px;">
                        Update your profile photo, change password, or customize dark/light theme preferences in settings.
                    </p>
                    <a href="{{ route('profile.show') }}" class="btn-secondary-action" style="width: 100%; justify-content: center;">
                        Manage Account Preferences
                    </a>
                </div>
            </div>
        </div>
    </main>

    <script>
        function updateThemeUI() {
            const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            const iconEl = document.getElementById('theme-icon');
            if (iconEl) {
                iconEl.textContent = isDark ? '☀️ Light' : '🌙 Dark';
            }
        }

        function toggleTheme() {
            const current = document.documentElement.getAttribute('data-theme') || 'light';
            const next = current === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
            updateThemeUI();
        }

        updateThemeUI();
    </script>
</body>
</html>
