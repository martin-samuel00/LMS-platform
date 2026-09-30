<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Classroom Hub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        // Apply saved theme preference on load immediately to avoid FOUC
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
            --card-hover-shadow: 0 20px 25px -5px rgba(99, 102, 241, 0.12), 0 8px 10px -6px rgba(99, 102, 241, 0.08);
            --hero-gradient: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
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
            --card-hover-shadow: 0 20px 25px -5px rgba(99, 102, 241, 0.25), 0 8px 10px -6px rgba(99, 102, 241, 0.15);
            --hero-gradient: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%);
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

        /* Top Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            padding: 16px 36px;
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
            padding: 6px 12px;
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
            transform: translateY(-1px);
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
            border-color: #ef4444;
        }

        /* Container */
        .container {
            max-width: 1080px;
            margin: 32px auto 60px;
            padding: 0 24px;
            width: 100%;
        }

        /* Hero Welcome Banner */
        .welcome-hero {
            background: var(--hero-gradient);
            color: #ffffff;
            border-radius: 20px;
            padding: 32px 36px;
            margin-bottom: 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.25);
            position: relative;
            overflow: hidden;
        }

        .welcome-hero::after {
            content: '';
            position: absolute;
            right: -60px;
            top: -60px;
            width: 220px;
            height: 220px;
            background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .welcome-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-avatar-large {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
            border: 2px solid rgba(255, 255, 255, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 800;
            color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            flex-shrink: 0;
        }

        .welcome-hero h1 {
            font-size: 26px;
            font-weight: 800;
            margin-bottom: 4px;
            letter-spacing: -0.5px;
        }

        .welcome-hero p {
            font-size: 14px;
            opacity: 0.9;
        }

        .welcome-pills {
            display: flex;
            gap: 8px;
            margin-top: 10px;
            flex-wrap: wrap;
        }

        .role-pill {
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #fff;
            padding: 3px 10px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .hero-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-hero-primary {
            background: #ffffff;
            color: #4f46e5;
            text-decoration: none;
            padding: 12px 22px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-hero-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        .btn-hero-secondary {
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff;
            border: 1.5px solid rgba(255, 255, 255, 0.35);
            text-decoration: none;
            padding: 11px 20px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-hero-secondary:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }

        /* Alerts */
        .alert-success {
            background-color: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 14px;
            margin-bottom: 24px;
            font-weight: 500;
        }

        [data-theme="dark"] .alert-success {
            background-color: rgba(16, 185, 129, 0.15);
            color: #6ee7b7;
            border-color: #065f46;
        }

        .alert-warning {
            background-color: #fffbeb;
            color: #92400e;
            border: 1px solid #fde68a;
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 14px;
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        [data-theme="dark"] .alert-warning {
            background-color: rgba(245, 158, 11, 0.15);
            color: #fcd34d;
            border-color: #92400e;
        }

        /* Cards */
        .card {
            background: var(--card-bg);
            border-radius: 18px;
            border: 1.5px solid var(--border-color);
            padding: 28px;
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
            font-size: 20px;
            font-weight: 800;
            color: var(--text-primary);
            letter-spacing: -0.3px;
        }

        .card p.subtitle {
            color: var(--text-secondary);
            font-size: 14px;
            line-height: 1.6;
        }

        /* Portals Grid */
        .portals-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-top: 20px;
        }

        .portal-card {
            background: var(--card-bg);
            border: 1.5px solid var(--border-color);
            border-radius: 14px;
            padding: 22px 20px;
            text-decoration: none;
            color: inherit;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .portal-card:hover {
            border-color: var(--highlight);
            transform: translateY(-3px);
            box-shadow: var(--card-hover-shadow);
        }

        .portal-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: var(--badge-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 14px;
        }

        .portal-card h3 {
            font-size: 16px;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .portal-card p {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        .portal-tag {
            font-size: 12px;
            font-weight: 700;
            color: var(--highlight);
            margin-top: auto;
            padding-top: 14px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Account Details Grid */
        .account-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-top: 20px;
        }

        .account-box {
            background: var(--subcard-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 18px 16px;
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
            .portals-grid {
                grid-template-columns: 1fr;
            }
            .account-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Top Navbar -->
    <nav class="navbar">
        <a href="{{ route('dashboard') }}" class="nav-brand">
            <span class="nav-brand-icon">🎓</span>
            <span>Classroom Hub</span>
        </a>
        <div class="navbar-actions">
            <!-- Theme Toggle -->
            <button onclick="toggleTheme()" class="btn-theme-toggle" title="Toggle Light/Dark Theme">
                <span id="theme-icon">🌙 Mode</span>
            </button>

            <!-- Notifications Center -->
            <a href="{{ route('notifications.index') }}" class="nav-link" style="position: relative;">
                <span>🔔</span> Notifications
                @php $unreadCount = Auth::user()->unreadNotifications()->count(); @endphp
                @if ($unreadCount > 0)
                    <span style="background: #ef4444; color: #fff; border-radius: 999px; padding: 2px 7px; font-size: 10px; font-weight: 800; margin-left: 2px;">{{ $unreadCount }}</span>
                @endif
            </a>

            <!-- Direct Messages -->
            <a href="{{ route('messages.index') }}" class="nav-link">
                <span>💬</span> Messages
            </a>

            <!-- Teacher Portal Link -->
            @if(Auth::user()->isTeacher())
                <a href="{{ route('teachers.index') }}" class="nav-link">
                    <span>👩‍🏫</span> Teaching
                </a>
            @endif

            <!-- Admin Console Badge Link -->
            @if(Auth::user()->isAdmin())
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
        <!-- Flash Success Notification -->
        @if (session('success'))
            <div class="alert-success">
                &check; {{ session('success') }}
            </div>
        @endif

        <!-- Email Verification Banner -->
        @if (!Auth::user()->hasVerifiedEmail())
            <div class="alert-warning">
                <div>
                    <strong>✉️ Verification Pending:</strong> Please confirm your email address to unlock all account capabilities.
                </div>
                <a href="{{ route('verification.notice') }}" style="background: #d97706; color: #fff; padding: 6px 14px; border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: 700; white-space: nowrap;">Verify Email &rarr;</a>
            </div>
        @endif

        <!-- Welcome Hero Header -->
        <div class="welcome-hero">
            <div class="welcome-left">
                <div class="user-avatar-large">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <h1>Welcome, {{ Auth::user()->name }}!</h1>
                    <p>Your unified learning dashboard and academic workspace.</p>
                    <div class="welcome-pills">
                        <span class="role-pill">
                            @if(Auth::user()->role === 'admin')
                                👑 Platform Administrator
                            @elseif(Auth::user()->role === 'moderator')
                                🛡️ Platform Moderator
                            @elseif(Auth::user()->isTeacher())
                                👩‍🏫 Instructor
                            @else
                                👨‍🎓 Student
                            @endif
                        </span>
                        @if (Auth::user()->hasVerifiedEmail())
                            <span class="role-pill" style="background: rgba(16, 185, 129, 0.25); border-color: rgba(16, 185, 129, 0.4);">
                                &checkmark; Verified Account
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Role Action Buttons -->
            <div class="hero-actions">
                @if (Auth::user()->isAdmin())
                    <a href="{{ route('admin.index') }}" class="btn-hero-primary" style="background: #ef4444; color: #fff;">
                        <span>🛡️</span> Open Admin Console &rarr;
                    </a>
                    <a href="{{ route('teachers.index') }}" class="btn-hero-secondary">
                        <span>👩‍🏫</span> Teacher Hub
                    </a>
                @elseif (Auth::user()->isTeacher())
                    <a href="{{ route('teachers.index') }}" class="btn-hero-primary">
                        <span>👩‍🏫</span> Open Teacher Portal &rarr;
                    </a>
                @else
                    <a href="{{ route('students.index') }}" class="btn-hero-primary">
                        <span>👨‍🎓</span> Open Student Portal &rarr;
                    </a>
                    <a href="{{ route('students.teachers.search') }}" class="btn-hero-secondary">
                        <span>🔍</span> Find Instructors
                    </a>
                @endif
            </div>
        </div>

        <!-- Available Portals & Learning Hub Grid -->
        <div class="card">
            <div class="card-header">
                <h2>Available Portals & Tools</h2>
            </div>
            <p class="subtitle">Quick shortcuts to your learning spaces, course management, communications, and settings.</p>

            <div class="portals-grid">
                <!-- Portal: Admin (if admin) -->
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.index') }}" class="portal-card" style="border: 2px solid #ef4444; background: rgba(239, 68, 68, 0.03);">
                        <div class="portal-icon" style="background: rgba(239, 68, 68, 0.15); color: #ef4444;">🛡️</div>
                        <h3 style="color: #ef4444;">Admin Console &rarr;</h3>
                        <p>User management, classroom governance, content moderation, and site-wide broadcast announcements.</p>
                        <div class="portal-tag" style="color: #ef4444;">Manage Platform &rarr;</div>
                    </a>
                @endif

                <!-- Portal: Student Portal -->
                <a href="{{ route('students.index') }}" class="portal-card">
                    <div class="portal-icon">👨‍🎓</div>
                    <h3>Student Portal &rarr;</h3>
                    <p>Access your enrolled courses, submit assignments, take self-grading quizzes, and earn certificates.</p>
                    <div class="portal-tag">Explore Learning &rarr;</div>
                </a>

                <!-- Portal: Teacher Portal -->
                <a href="{{ route('teachers.index') }}" class="portal-card">
                    <div class="portal-icon">👩‍🏫</div>
                    <h3>Teacher Portal &rarr;</h3>
                    <p>Create classrooms, post assignments with deadline files, take roll-call, and issue course certificates.</p>
                    <div class="portal-tag">Manage Classes &rarr;</div>
                </a>

                <!-- Portal: Notifications Center -->
                <a href="{{ route('notifications.index') }}" class="portal-card">
                    <div class="portal-icon">🔔</div>
                    <h3>Notifications Hub &rarr;</h3>
                    <p>Stay up to date with new assignment deadlines, grades, teacher approvals, and pinned announcements.</p>
                    <div class="portal-tag">View Alerts &rarr;</div>
                </a>

                <!-- Portal: 1-on-1 Messages -->
                <a href="{{ route('messages.index') }}" class="portal-card">
                    <div class="portal-icon">💬</div>
                    <h3>Direct Messages &rarr;</h3>
                    <p>Private two-way chat with teachers and peers for questions, project guidance, and office hours.</p>
                    <div class="portal-tag">Open Chat &rarr;</div>
                </a>

                <!-- Portal: Profile & Settings -->
                <a href="{{ route('profile.show') }}" class="portal-card">
                    <div class="portal-icon">⚙️</div>
                    <h3>Profile & Security &rarr;</h3>
                    <p>Update your personal information, add phone recovery, change password, and toggle Dark Mode.</p>
                    <div class="portal-tag">Account Settings &rarr;</div>
                </a>
            </div>
        </div>

        <!-- Account Credentials & Security Overview -->
        <div class="card">
            <div class="card-header">
                <h2>Account Credentials & Security</h2>
                <a href="{{ route('profile.show') }}" style="font-size: 13px; color: var(--highlight); font-weight: 700; text-decoration: none;">Edit Details &rarr;</a>
            </div>
            <p class="subtitle">Summary of your account status and verified credentials.</p>

            <div class="account-grid">
                <div class="account-box">
                    <div class="account-box-label">Account Role</div>
                    <div class="account-box-value">
                        @if(Auth::user()->role === 'admin')
                            👑 Administrator
                        @elseif(Auth::user()->role === 'moderator')
                            🛡️ Moderator
                        @elseif(Auth::user()->isTeacher())
                            👩‍🏫 Teacher
                        @else
                            👨‍🎓 Student
                        @endif
                    </div>
                </div>

                <div class="account-box">
                    <div class="account-box-label">Display Name</div>
                    <div class="account-box-value">{{ Auth::user()->name }}</div>
                </div>

                <div class="account-box">
                    <div class="account-box-label">Email Verification</div>
                    <div class="account-box-value">
                        @if (Auth::user()->hasVerifiedEmail())
                            <span style="color: #10b981;">&check; Verified</span>
                        @else
                            <span style="color: #ef4444;">&times; Pending</span>
                        @endif
                    </div>
                </div>

                <div class="account-box">
                    <div class="account-box-label">Phone Protection</div>
                    <div class="account-box-value">
                        {{ Auth::user()->phone ?: 'None added' }}
                    </div>
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
