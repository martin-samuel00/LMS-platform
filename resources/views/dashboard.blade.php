<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workspace Dashboard - Classroom Hub</title>
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
            --card-bg: #ffffff;
            --subcard-bg: #f8fafc;
            --border-color: #e2e8f0;
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --input-bg: #ffffff;
            --input-border: #cbd5e1;
            --highlight: #4f46e5;
            --highlight-hover: #4338ca;
            --badge-bg: #e0e7ff;
            --badge-text: #4338ca;
            --card-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
            --hero-gradient: linear-gradient(135deg, #3b82f6 0%, #4f46e5 50%, #7c3aed 100%);
        }

        [data-theme="dark"] {
            --bg-color: #0b0f19;
            --card-bg: #111827;
            --subcard-bg: #070b14;
            --border-color: #1f2937;
            --text-primary: #f9fafb;
            --text-secondary: #9ca3af;
            --input-bg: #070b14;
            --input-border: #374151;
            --highlight: #6366f1;
            --highlight-hover: #4f46e5;
            --badge-bg: rgba(99, 102, 241, 0.2);
            --badge-text: #a5b4fc;
            --card-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.3);
            --hero-gradient: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            transition: background-color 0.2s ease, border-color 0.2s ease;
        }

        h1, h2, h3, h4, .brand-font {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            padding: 14px 36px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        [data-theme="dark"] .navbar {
            background: rgba(11, 15, 25, 0.85);
        }

        .nav-brand {
            font-size: 19px;
            font-weight: 800;
            color: var(--highlight);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            letter-spacing: -0.5px;
        }

        .nav-brand-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #fff;
            border-radius: 10px;
            font-size: 18px;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.25);
        }

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav-link {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 600;
            padding: 7px 12px;
            border-radius: 8px;
            transition: all 0.15s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .nav-link:hover {
            color: var(--highlight);
            background: rgba(99, 102, 241, 0.06);
        }

        .btn-theme-toggle {
            background: var(--card-bg);
            border: 1.5px solid var(--border-color);
            border-radius: 9999px;
            padding: 6px 14px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--text-primary);
            transition: all 0.2s;
        }

        .btn-theme-toggle:hover {
            border-color: var(--highlight);
        }

        .btn-logout {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1.5px solid rgba(239, 68, 68, 0.2);
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-logout:hover {
            background: #ef4444;
            color: #ffffff;
        }

        /* Container */
        .container {
            max-width: 1100px;
            margin: 28px auto 60px;
            padding: 0 24px;
            width: 100%;
        }

        /* Hero Welcome Banner */
        .welcome-hero {
            background: var(--hero-gradient);
            color: #ffffff;
            border-radius: 22px;
            padding: 34px 40px;
            margin-bottom: 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            box-shadow: 0 12px 30px -5px rgba(79, 70, 229, 0.3);
            position: relative;
            overflow: hidden;
        }

        .welcome-hero::after {
            content: '';
            position: absolute;
            right: -60px;
            top: -60px;
            width: 260px;
            height: 260px;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .welcome-left {
            display: flex;
            align-items: center;
            gap: 22px;
        }

        .user-avatar-img {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
            flex-shrink: 0;
            background: #fff;
        }

        .welcome-hero h1 {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 4px;
            letter-spacing: -0.5px;
        }

        .welcome-hero p {
            font-size: 14.5px;
            opacity: 0.92;
        }

        .welcome-pills {
            display: flex;
            gap: 8px;
            margin-top: 10px;
            flex-wrap: wrap;
            align-items: center;
        }

        .role-pill {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.35);
            color: #fff;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .username-pill {
            background: rgba(0, 0, 0, 0.25);
            color: #fff;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 700;
            font-family: monospace;
        }

        .hero-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-hero-primary {
            background: #ffffff;
            color: #4f46e5;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 800;
            font-size: 14.5px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-hero-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.18);
        }

        .btn-hero-secondary {
            background: rgba(255, 255, 255, 0.16);
            color: #ffffff;
            border: 1.5px solid rgba(255, 255, 255, 0.4);
            text-decoration: none;
            padding: 11px 22px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 14.5px;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-hero-secondary:hover {
            background: rgba(255, 255, 255, 0.28);
            transform: translateY(-2px);
        }

        /* KPI Stat Cards Grid */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 28px;
        }

        .kpi-card {
            background: var(--card-bg);
            border: 1.5px solid var(--border-color);
            border-radius: 18px;
            padding: 22px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: var(--card-shadow);
            transition: transform 0.2s, border-color 0.2s;
        }

        .kpi-card:hover {
            transform: translateY(-2px);
            border-color: var(--highlight);
        }

        .kpi-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        .kpi-num {
            font-size: 24px;
            font-weight: 800;
            color: var(--text-primary);
            line-height: 1.1;
        }

        .kpi-label {
            font-size: 12.5px;
            color: var(--text-secondary);
            font-weight: 600;
            margin-top: 4px;
        }

        /* Main Workspace Section Cards */
        .card {
            background: var(--card-bg);
            border-radius: 20px;
            border: 1.5px solid var(--border-color);
            padding: 30px;
            box-shadow: var(--card-shadow);
            margin-bottom: 28px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .card h2 {
            font-size: 21px;
            font-weight: 800;
            color: var(--text-primary);
            letter-spacing: -0.3px;
        }

        .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin-bottom: 22px;
        }

        /* Portals / Actions Grid */
        .portals-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .portal-card {
            background: var(--subcard-bg);
            border: 1.5px solid var(--border-color);
            border-radius: 16px;
            padding: 24px;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            gap: 12px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .portal-card:hover {
            transform: translateY(-3px);
            border-color: var(--highlight);
            box-shadow: 0 12px 24px -6px rgba(79, 70, 229, 0.15);
        }

        .portal-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: var(--badge-bg);
            color: var(--highlight);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .portal-card h3 {
            font-size: 16.5px;
            font-weight: 800;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .portal-card p {
            font-size: 13.5px;
            color: var(--text-secondary);
            line-height: 1.5;
            flex-grow: 1;
        }

        .portal-tag {
            font-size: 12.5px;
            font-weight: 700;
            color: var(--highlight);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Profile & Security Strip */
        .account-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-top: 14px;
        }

        .account-box {
            background: var(--subcard-bg);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 18px 20px;
        }

        .account-box-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-secondary);
            margin-bottom: 6px;
        }

        .account-box-value {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary);
            word-break: break-word;
        }

        @media (max-width: 992px) {
            .kpi-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .portals-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .account-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 14px 20px;
            }
            .welcome-hero {
                padding: 24px;
            }
            .welcome-left {
                flex-direction: column;
                align-items: flex-start;
            }
            .kpi-grid, .portals-grid, .account-grid {
                grid-template-columns: 1fr;
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

        // Calculate KPI counters
        $unreadNotesCount = $user->unreadNotifications()->count();
        $unreadMessagesCount = \App\Models\DirectMessage::where('recipient_id', $user->id)->where('is_read', false)->count();

        if ($isTeacher) {
            $classroomsCount = $user->taughtClassrooms()->count();
            $taughtIds = $user->taughtClassrooms()->pluck('id');
            $pendingRequestsCount = \DB::table('classroom_user')->whereIn('classroom_id', $taughtIds)->where('status', 'pending')->count();
            $totalQuizzesCount = \App\Models\Quiz::whereIn('classroom_id', $taughtIds)->count();
        } elseif ($isStudent) {
            $enrolledCount = $user->enrolledClassrooms()->wherePivot('status', 'approved')->count();
            $quizSubmissionsCount = \App\Models\QuizSubmission::where('user_id', $user->id)->count();
            $certsCount = \App\Models\Certificate::where('user_id', $user->id)->count();
        } else {
            $totalUsersCount = \App\Models\User::count();
            $totalClassesCount = \App\Models\Classroom::count();
        }
    @endphp

    <!-- Top Navigation Bar -->
    <nav class="navbar">
        <a href="{{ route('dashboard') }}" class="nav-brand">
            <span class="nav-brand-icon">🎓</span>
            <span>Classroom Hub</span>
        </a>
        <button type="button" class="mobile-nav-toggle" aria-label="Toggle navigation">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>
        <div class="navbar-actions">
            <!-- Theme Toggle -->
            <button onclick="toggleTheme()" class="btn-theme-toggle" title="Toggle Light/Dark Theme">
                <span id="theme-icon">🌙 Mode</span>
            </button>

            <!-- Notifications Center -->
            <a href="{{ route('notifications.index') }}" class="nav-link" style="position: relative;">
                <span>🔔</span> Notifications
                @if ($unreadNotesCount > 0)
                    <span style="background: #ef4444; color: #fff; border-radius: 999px; padding: 2px 7px; font-size: 10px; font-weight: 800; margin-left: 2px;">{{ $unreadNotesCount }}</span>
                @endif
            </a>

            <!-- Direct Messages -->
            <a href="{{ route('messages.index') }}" class="nav-link">
                <span>💬</span> Messages
                @if ($unreadMessagesCount > 0)
                    <span style="background: #4f46e5; color: #fff; border-radius: 999px; padding: 2px 7px; font-size: 10px; font-weight: 800; margin-left: 2px;">{{ $unreadMessagesCount }}</span>
                @endif
            </a>

            <!-- Role-Specific Portal Link in Navbar (STRICT ISOLATION) -->
            @if ($isTeacher)
                <a href="{{ route('teachers.index') }}" class="nav-link" style="color: var(--highlight); font-weight: 700;">
                    <span>👩‍🏫</span> Instructor Hub
                </a>
            @elseif ($isStudent)
                <a href="{{ route('students.index') }}" class="nav-link" style="color: var(--highlight); font-weight: 700;">
                    <span>👨‍🎓</span> Student Learning
                </a>
            @endif

            <!-- Admin Console (Admin Only) -->
            @if ($isAdmin)
                <a href="{{ route('admin.index') }}" class="nav-link" style="color: #ef4444; font-weight: 700; background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2);">
                    <span>🛡️</span> Admin Console
                </a>
            @endif

            <!-- Profile & Settings -->
            <a href="{{ route('profile.show') }}" class="nav-link">
                <span>⚙️</span> Profile
            </a>

            <!-- Logout -->
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout">Log Out</button>
            </form>
        </div>
    </nav>

    <div class="container">
        <!-- Flash Alerts -->
        @if (session('success'))
            <div style="background-color: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; border-radius: 14px; padding: 14px 20px; font-size: 14px; margin-bottom: 24px; font-weight: 600;">
                &check; {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div style="background-color: #fef2f2; color: #991b1b; border: 1px solid #fecaca; border-radius: 14px; padding: 14px 20px; font-size: 14px; margin-bottom: 24px; font-weight: 600;">
                &times; {{ session('error') }}
            </div>
        @endif

        <!-- Email Verification Banner -->
        @if (!$user->hasVerifiedEmail())
            <div style="background-color: #fffbeb; color: #92400e; border: 1px solid #fde68a; border-radius: 14px; padding: 14px 20px; font-size: 14px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; gap: 12px;">
                <div>
                    <strong>✉️ Verification Pending:</strong> Please confirm your email address to unlock all account capabilities.
                </div>
                <a href="{{ route('verification.notice') }}" style="background: #d97706; color: #fff; padding: 7px 16px; border-radius: 10px; text-decoration: none; font-size: 12.5px; font-weight: 700; white-space: nowrap;">Verify Email &rarr;</a>
            </div>
        @endif

        <!-- Welcome Hero Header -->
        <div class="welcome-hero">
            <div class="welcome-left">
                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="user-avatar-img">
                <div>
                    <h1>Welcome, {{ $user->name }}!</h1>
                    <p>Your unified academic workspace and learning management dashboard.</p>
                    <div class="welcome-pills">
                        <span class="role-pill">
                            @if($isAdmin)
                                👑 Administrator
                            @elseif($isTeacher)
                                👩‍🏫 Instructor
                            @else
                                👨‍🎓 Student
                            @endif
                        </span>
                        @if ($user->username)
                            <span class="username-pill">&#64;{{ $user->username }}</span>
                        @endif
                        @if ($user->hasVerifiedEmail())
                            <span class="role-pill" style="background: rgba(16, 185, 129, 0.3); border-color: rgba(16, 185, 129, 0.5);">
                                &checkmark; Verified
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Role Action Buttons (Strict Separation) -->
            <div class="hero-actions">
                @if ($isAdmin)
                    <a href="{{ route('admin.index') }}" class="btn-hero-primary" style="background: #ef4444; color: #fff;">
                        <span>🛡️</span> Admin Console &rarr;
                    </a>
                @elseif ($isTeacher)
                    <a href="{{ route('teachers.index') }}" class="btn-hero-primary">
                        <span>👩‍🏫</span> Open Teacher Hub &rarr;
                    </a>
                    <a href="{{ route('profile.show') }}" class="btn-hero-secondary">
                        <span>⚙️</span> Edit Profile
                    </a>
                @else
                    <a href="{{ route('students.index') }}" class="btn-hero-primary">
                        <span>👨‍🎓</span> My Courses &rarr;
                    </a>
                    <a href="{{ route('students.teachers.search') }}" class="btn-hero-secondary">
                        <span>🔍</span> Find Instructors
                    </a>
                @endif
            </div>
        </div>

        <!-- KPI Stat Metrics Grid -->
        <div class="kpi-grid">
            @if ($isTeacher)
                <div class="kpi-card">
                    <div class="kpi-icon" style="background: rgba(79, 70, 229, 0.12); color: #4f46e5;">🏫</div>
                    <div>
                        <div class="kpi-num">{{ $classroomsCount }}</div>
                        <div class="kpi-label">Active Classrooms</div>
                    </div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-icon" style="background: rgba(245, 158, 11, 0.15); color: #d97706;">⏳</div>
                    <div>
                        <div class="kpi-num">{{ $pendingRequestsCount }}</div>
                        <div class="kpi-label">Pending Join Requests</div>
                    </div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-icon" style="background: rgba(16, 185, 129, 0.12); color: #10b981;">📝</div>
                    <div>
                        <div class="kpi-num">{{ $totalQuizzesCount }}</div>
                        <div class="kpi-label">Assessments Published</div>
                    </div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-icon" style="background: rgba(59, 130, 246, 0.12); color: #3b82f6;">💬</div>
                    <div>
                        <div class="kpi-num">{{ $unreadMessagesCount }}</div>
                        <div class="kpi-label">Unread Messages</div>
                    </div>
                </div>
            @elseif ($isStudent)
                <div class="kpi-card">
                    <div class="kpi-icon" style="background: rgba(79, 70, 229, 0.12); color: #4f46e5;">📚</div>
                    <div>
                        <div class="kpi-num">{{ $enrolledCount }}</div>
                        <div class="kpi-label">Enrolled Classes</div>
                    </div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-icon" style="background: rgba(16, 185, 129, 0.12); color: #10b981;">🎯</div>
                    <div>
                        <div class="kpi-num">{{ $quizSubmissionsCount }}</div>
                        <div class="kpi-label">Quizzes Completed</div>
                    </div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-icon" style="background: rgba(245, 158, 11, 0.15); color: #d97706;">📜</div>
                    <div>
                        <div class="kpi-num">{{ $certsCount }}</div>
                        <div class="kpi-label">Certificates Earned</div>
                    </div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-icon" style="background: rgba(59, 130, 246, 0.12); color: #3b82f6;">💬</div>
                    <div>
                        <div class="kpi-num">{{ $unreadMessagesCount }}</div>
                        <div class="kpi-label">Unread Messages</div>
                    </div>
                </div>
            @else
                <div class="kpi-card">
                    <div class="kpi-icon" style="background: rgba(239, 68, 68, 0.12); color: #ef4444;">🛡️</div>
                    <div>
                        <div class="kpi-num">{{ $totalUsersCount }}</div>
                        <div class="kpi-label">Registered Accounts</div>
                    </div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-icon" style="background: rgba(79, 70, 229, 0.12); color: #4f46e5;">🏫</div>
                    <div>
                        <div class="kpi-num">{{ $totalClassesCount }}</div>
                        <div class="kpi-label">Active Classrooms</div>
                    </div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-icon" style="background: rgba(16, 185, 129, 0.12); color: #10b981;">🔔</div>
                    <div>
                        <div class="kpi-num">{{ $unreadNotesCount }}</div>
                        <div class="kpi-label">System Notifications</div>
                    </div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-icon" style="background: rgba(59, 130, 246, 0.12); color: #3b82f6;">💬</div>
                    <div>
                        <div class="kpi-num">{{ $unreadMessagesCount }}</div>
                        <div class="kpi-label">Direct Chats</div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Available Workspaces & Hub Tools (STRICT ROLE ISOLATION) -->
        <div class="card">
            <div class="card-header">
                <h2>Your Academic Workspaces</h2>
            </div>
            <p class="subtitle">Quick shortcuts tailored for your role and daily activities.</p>

            <div class="portals-grid">
                <!-- TEACHER ONLY CARDS -->
                @if ($isTeacher)
                    <a href="{{ route('teachers.index') }}" class="portal-card">
                        <div class="portal-icon">👩‍🏫</div>
                        <h3>Teacher Portal &rarr;</h3>
                        <p>Manage all your classrooms, publish curriculum, assign work with deadline attachments, and review attendance.</p>
                        <div class="portal-tag">Manage Classes &rarr;</div>
                    </a>

                    <a href="{{ route('teachers.index') }}" class="portal-card">
                        <div class="portal-icon" style="background: rgba(16, 185, 129, 0.15); color: #10b981;">📝</div>
                        <h3>Assessment Center &rarr;</h3>
                        <p>Construct multi-format quizzes with per-question timers, matching pairs, fill-in blanks, and scientific terms.</p>
                        <div class="portal-tag" style="color: #10b981;">Create Assessments &rarr;</div>
                    </a>
                @endif

                <!-- STUDENT ONLY CARDS -->
                @if ($isStudent)
                    <a href="{{ route('students.index') }}" class="portal-card">
                        <div class="portal-icon">👨‍🎓</div>
                        <h3>Student Learning Hub &rarr;</h3>
                        <p>Access your enrolled courses, submit assignments, take self-grading quizzes, and track your attendance.</p>
                        <div class="portal-tag">Open Coursework &rarr;</div>
                    </a>

                    <a href="{{ route('students.teachers.search') }}" class="portal-card">
                        <div class="portal-icon" style="background: rgba(59, 130, 246, 0.15); color: #3b82f6;">🔍</div>
                        <h3>Find Instructors &rarr;</h3>
                        <p>Discover expert teachers, request access to specialized study groups, and expand your education.</p>
                        <div class="portal-tag" style="color: #3b82f6;">Search Directory &rarr;</div>
                    </a>
                @endif

                <!-- ADMIN ONLY CARDS -->
                @if ($isAdmin)
                    <a href="{{ route('admin.index') }}" class="portal-card" style="border: 2px solid #ef4444; background: rgba(239, 68, 68, 0.03);">
                        <div class="portal-icon" style="background: rgba(239, 68, 68, 0.15); color: #ef4444;">🛡️</div>
                        <h3 style="color: #ef4444;">Admin Console &rarr;</h3>
                        <p>User management, classroom governance, content moderation, and site-wide broadcast announcements.</p>
                        <div class="portal-tag" style="color: #ef4444;">Manage Platform &rarr;</div>
                    </a>
                @endif

                <!-- SHARED TOOLS FOR ALL USERS -->
                <a href="{{ route('notifications.index') }}" class="portal-card">
                    <div class="portal-icon">🔔</div>
                    <h3>Notifications Hub &rarr;</h3>
                    <p>Stay up to date with new assignment deadlines, grades, teacher approvals, and pinned announcements.</p>
                    <div class="portal-tag">View Alerts &rarr;</div>
                </a>

                <a href="{{ route('messages.index') }}" class="portal-card">
                    <div class="portal-icon">💬</div>
                    <h3>Direct Messages &rarr;</h3>
                    <p>Private two-way chat with teachers and peers for questions, project guidance, and office hours.</p>
                    <div class="portal-tag">Open Chat &rarr;</div>
                </a>

                <a href="{{ route('profile.show') }}" class="portal-card">
                    <div class="portal-icon">⚙️</div>
                    <h3>Profile & Security &rarr;</h3>
                    <p>Upload your profile picture, change your @username, manage email verification, and toggle Dark Mode.</p>
                    <div class="portal-tag">Account Settings &rarr;</div>
                </a>
            </div>
        </div>

        <!-- Account Credentials & Security Overview -->
        <div class="card">
            <div class="card-header">
                <h2>Account Credentials & Security</h2>
                <a href="{{ route('profile.show') }}" style="font-size: 13.5px; color: var(--highlight); font-weight: 700; text-decoration: none;">Edit Profile &rarr;</a>
            </div>
            <p class="subtitle">Summary of your account status and verified credentials.</p>

            <div class="account-grid">
                <div class="account-box">
                    <div class="account-box-label">Account Role</div>
                    <div class="account-box-value">
                        @if($isAdmin)
                            👑 Administrator
                        @elseif($isTeacher)
                            👩‍🏫 Instructor
                        @else
                            👨‍🎓 Student
                        @endif
                    </div>
                </div>

                <div class="account-box">
                    <div class="account-box-label">Username</div>
                    <div class="account-box-value">
                        {{ $user->username ? '@' . $user->username : 'None set' }}
                    </div>
                </div>

                <div class="account-box">
                    <div class="account-box-label">Email Verification</div>
                    <div class="account-box-value">
                        @if ($user->hasVerifiedEmail())
                            <span style="color: #10b981;">&check; Verified</span>
                        @else
                            <span style="color: #ef4444;">&times; Pending</span>
                        @endif
                    </div>
                </div>

                <div class="account-box">
                    <div class="account-box-label">Registered Email</div>
                    <div class="account-box-value">{{ $user->email }}</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateThemeButton() {
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
            updateThemeButton();
        }

        updateThemeButton();
    </script>
</body>
</html>
