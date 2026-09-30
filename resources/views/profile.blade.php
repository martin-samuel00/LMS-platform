<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile & Settings - Classroom Hub</title>
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
            font-size: 17px;
            font-weight: 800;
            color: var(--highlight);
            text-decoration: none;
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
            max-width: 900px;
            margin: 32px auto;
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

        /* Profile Hero Banner */
        .profile-hero {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
            border-radius: 20px;
            padding: 32px;
            color: #ffffff;
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            gap: 24px;
            box-shadow: 0 10px 28px -8px rgba(67, 56, 202, 0.35);
        }

        .profile-avatar-large {
            width: 72px;
            height: 72px;
            border-radius: 18px;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 800;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.25);
            flex-shrink: 0;
        }

        .profile-hero-info h1 {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.4px;
            margin-bottom: 4px;
            color: #ffffff;
        }

        .profile-hero-info p {
            color: #c7d2fe;
            font-size: 13.5px;
            margin-bottom: 8px;
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(8px);
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Settings Cards */
        .card {
            background: var(--card-bg);
            border-radius: 16px;
            border: 1px solid var(--border-color);
            padding: 28px;
            margin-bottom: 24px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.02);
        }

        .card h2 {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        .card-desc {
            font-size: 13px;
            color: var(--text-secondary);
            margin-bottom: 20px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 16px;
        }

        .form-group.full {
            grid-column: span 2;
        }

        .form-group label {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .form-group input {
            padding: 11px 14px;
            background: var(--input-bg);
            border: 1.5px solid var(--input-border);
            border-radius: 10px;
            font-size: 14px;
            color: var(--text-primary);
            outline: none;
            transition: all 0.2s;
        }

        .form-group input:focus {
            border-color: var(--highlight);
            box-shadow: 0 0 0 3px var(--accent-glow);
        }

        .email-status {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 6px;
            font-size: 12.5px;
        }

        .badge-verified {
            background: #dcfce7;
            color: #15803d;
            padding: 3px 8px;
            border-radius: 6px;
            font-weight: 700;
        }

        .badge-unverified {
            background: #fee2e2;
            color: #b91c1c;
            padding: 3px 8px;
            border-radius: 6px;
            font-weight: 700;
        }

        .btn-save {
            background: var(--highlight);
            color: #ffffff;
            border: none;
            padding: 11px 22px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.15s;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.25);
            align-self: flex-start;
        }

        .btn-save:hover {
            background: var(--highlight-hover);
            transform: translateY(-1px);
        }

        /* Theme Selector */
        .theme-selector {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
            max-width: 440px;
        }

        .theme-option {
            border: 2px solid var(--border-color);
            background: var(--card-subtle);
            border-radius: 12px;
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 700;
            color: var(--text-primary);
            transition: all 0.2s;
        }

        .theme-option:hover {
            border-color: var(--highlight);
        }

        .theme-option.active {
            border-color: var(--highlight);
            background: var(--accent-glow);
            color: var(--highlight);
        }

        @media (max-width: 650px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            .form-group.full {
                grid-column: span 1;
            }
            .profile-hero {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('dashboard') }}" class="nav-brand">
            <span class="brand-badge">🎓</span>
            <span>Classroom Hub</span>
        </a>
        <div class="nav-links">
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
        @if ($errors->any())
            <div class="alert alert-error">
                <span>⚠️</span>
                <div>
                    <ul style="margin-left: 16px;">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Profile Hero Strip -->
        <div class="profile-hero">
            <div class="profile-avatar-large">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div class="profile-hero-info">
                <h1>{{ $user->name }}</h1>
                <p>{{ $user->email }} &bull; Member since {{ $user->created_at->format('M Y') }}</p>
                <div class="role-badge">
                    @if($user->isAdmin())
                        🛡️ Administrator
                    @elseif($user->role === 'teacher')
                        👩‍🏫 Teacher
                    @else
                        👨‍🎓 Student
                    @endif
                </div>
            </div>
        </div>

        <!-- 1. Profile Information Form -->
        <div class="card">
            <h2>Personal Information</h2>
            <p class="card-desc">Update your display name, primary email address, and security phone number.</p>

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="role">Account Role</label>
                        <input type="text" value="{{ ucfirst($user->role) }}" disabled style="opacity: 0.75; cursor: not-allowed;">
                    </div>

                    <div class="form-group full">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        <div class="email-status">
                            @if ($user->hasVerifiedEmail())
                                <span class="badge-verified">Verified &checkmark;</span>
                            @else
                                <span class="badge-unverified">Unverified &times;</span>
                                <a href="{{ route('verification.notice') }}" style="color: var(--highlight); font-weight: 700; text-decoration: none;">Verify email now &rarr;</a>
                            @endif
                        </div>
                    </div>

                    <div class="form-group full">
                        <label for="phone">Phone Number (Security & Notifications)</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+1 (555) 000-0000">
                    </div>
                </div>

                <button type="submit" class="btn-save">Save Profile Changes</button>
            </form>
        </div>

        <!-- 2. Change Password Form -->
        <div class="card">
            <h2>Update Security Password</h2>
            <p class="card-desc">Keep your account secure by choosing a unique, strong password.</p>

            <form action="{{ route('profile.password') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="current_password">Current Password *</label>
                    <input type="password" id="current_password" name="current_password" required placeholder="••••••••">
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="password">New Password *</label>
                        <input type="password" id="password" name="password" minlength="8" required placeholder="Minimum 8 characters">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm New Password *</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Repeat new password">
                    </div>
                </div>

                <button type="submit" class="btn-save">Update Password</button>
            </form>
        </div>

        <!-- 3. Appearance & Theme Settings -->
        <div class="card">
            <h2>Appearance & Theme</h2>
            <p class="card-desc">Switch seamlessly between light and dark themes across all portal sections.</p>

            <div class="theme-selector">
                <div class="theme-option" id="opt-light" onclick="setTheme('light')">
                    <span style="font-size: 22px;">☀️</span>
                    <span>Light Mode</span>
                </div>
                <div class="theme-option" id="opt-dark" onclick="setTheme('dark')">
                    <span style="font-size: 22px;">🌙</span>
                    <span>Dark Mode</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateThemeUI(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);

            const optLight = document.getElementById('opt-light');
            const optDark = document.getElementById('opt-dark');
            if (optLight && optDark) {
                optLight.classList.toggle('active', theme === 'light');
                optDark.classList.toggle('active', theme === 'dark');
            }
        }

        function setTheme(theme) {
            updateThemeUI(theme);
        }

        // Initialize state on page load
        const currentTheme = localStorage.getItem('theme') || 'light';
        updateThemeUI(currentTheme);
    </script>
</body>
</html>
