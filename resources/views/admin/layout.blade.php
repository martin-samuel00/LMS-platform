<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Console') - Classroom Hub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        // Apply saved theme immediately to prevent flashing
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.setAttribute('data-theme', 'dark');
        } else {
            document.documentElement.setAttribute('data-theme', 'light');
        }
    </script>
    <style>
        :root {
            --bg-color: #f8fafc;
            --sidebar-bg: #0f172a;
            --sidebar-text: #94a3b8;
            --sidebar-text-active: #ffffff;
            --sidebar-active-bg: #1e293b;
            --sidebar-border: #1e293b;
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
            --card-shadow: 0 1px 3px rgba(0, 0, 0, 0.05), 0 10px 15px -5px rgba(0, 0, 0, 0.02);
        }

        [data-theme="dark"] {
            --bg-color: #0b0f19;
            --sidebar-bg: #070b14;
            --sidebar-text: #9ca3af;
            --sidebar-text-active: #ffffff;
            --sidebar-active-bg: #111827;
            --sidebar-border: #1f2937;
            --card-bg: #111827;
            --subcard-bg: #0b0f19;
            --border-color: #1f2937;
            --text-primary: #f9fafb;
            --text-secondary: #9ca3af;
            --input-bg: #0b0f19;
            --input-border: #374151;
            --highlight: #6366f1;
            --highlight-hover: #4f46e5;
            --badge-bg: rgba(99, 102, 241, 0.2);
            --badge-text: #a5b4fc;
            --card-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.3);
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
        }

        /* Admin Sidebar */
        .admin-sidebar {
            width: 260px;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--sidebar-border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
        }

        .sidebar-brand {
            padding: 24px 20px;
            border-bottom: 1px solid var(--sidebar-border);
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #ffffff;
            font-size: 17px;
            font-weight: 800;
            letter-spacing: -0.3px;
        }

        .sidebar-brand-badge {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #fff;
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .sidebar-menu {
            list-style: none;
            padding: 16px 12px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            flex: 1;
            overflow-y: auto;
        }

        .menu-heading {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #64748b;
            font-weight: 700;
            padding: 12px 10px 6px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: 8px;
            text-decoration: none;
            color: var(--sidebar-text);
            font-size: 14px;
            font-weight: 600;
            transition: all 0.15s;
        }

        .menu-link:hover {
            color: var(--sidebar-text-active);
            background: rgba(255, 255, 255, 0.05);
        }

        .menu-link.active {
            color: var(--sidebar-text-active);
            background: var(--sidebar-active-bg);
            border-left: 3px solid var(--highlight);
        }

        .menu-icon {
            font-size: 18px;
            width: 22px;
            text-align: center;
        }

        .sidebar-footer {
            padding: 16px 14px;
            border-top: 1px solid var(--sidebar-border);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .user-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.04);
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--highlight);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
        }

        .user-info {
            overflow: hidden;
        }

        .user-name {
            font-size: 13px;
            font-weight: 700;
            color: #fff;
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
        }

        .user-role {
            font-size: 11px;
            color: #94a3b8;
            text-transform: capitalize;
        }

        /* Main Content Wrapper */
        .admin-main {
            margin-left: 260px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .admin-topbar {
            background: var(--card-bg);
            border-bottom: 1px solid var(--border-color);
            padding: 14px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .topbar-title {
            font-size: 18px;
            font-weight: 800;
            color: var(--text-primary);
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .btn-theme-toggle {
            background: var(--bg-color);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 6px 12px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-portal-back {
            color: var(--highlight);
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 6px 12px;
            border-radius: 8px;
            border: 1.5px solid var(--border-color);
        }

        .btn-portal-back:hover {
            border-color: var(--highlight);
            background: rgba(99, 102, 241, 0.05);
        }

        .admin-content {
            padding: 30px 32px 60px;
            flex: 1;
            max-width: 1400px;
            width: 100%;
        }

        /* Global UI Elements */
        .card {
            background: var(--card-bg);
            border: 1.5px solid var(--border-color);
            border-radius: 14px;
            padding: 24px;
            box-shadow: var(--card-shadow);
            margin-bottom: 24px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }

        .card-title {
            font-size: 17px;
            font-weight: 800;
            color: var(--text-primary);
        }

        .alert-success {
            background-color: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
            border-radius: 10px;
            padding: 12px 18px;
            font-size: 14px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        [data-theme="dark"] .alert-success {
            background-color: rgba(16, 185, 129, 0.15);
            color: #6ee7b7;
            border-color: #065f46;
        }

        .alert-error {
            background-color: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 12px 18px;
            font-size: 14px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        [data-theme="dark"] .alert-error {
            background-color: rgba(239, 68, 68, 0.15);
            color: #fca5a5;
            border-color: #991b1b;
        }

        /* Tables */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        th {
            text-align: left;
            padding: 10px 14px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--text-secondary);
            border-bottom: 1.5px solid var(--border-color);
            background: var(--subcard-bg);
        }

        td {
            padding: 14px;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
            color: var(--text-primary);
        }

        tr:hover td {
            background: var(--subcard-bg);
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 8px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 700;
            text-transform: capitalize;
        }

        .badge-student { background: #e0f2fe; color: #0369a1; }
        .badge-teacher { background: #fef3c7; color: #b45309; }
        .badge-moderator { background: #f3e8ff; color: #7e22ce; }
        .badge-admin { background: #fee2e2; color: #b91c1c; }
        .badge-verified { background: #dcfce7; color: #15803d; }
        .badge-unverified { background: #f1f5f9; color: #64748b; }
        .badge-banned { background: #fee2e2; color: #b91c1c; }

        /* Buttons */
        .btn-action {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all 0.15s;
        }

        .btn-action-primary { background: var(--highlight); color: #fff; }
        .btn-action-primary:hover { background: var(--highlight-hover); }
        .btn-action-danger { background: #ef4444; color: #fff; }
        .btn-action-danger:hover { background: #dc2626; }
        .btn-action-success { background: #10b981; color: #fff; }
        .btn-action-success:hover { background: #059669; }
        .btn-action-warning { background: #f59e0b; color: #fff; }
        .btn-action-warning:hover { background: #d97706; }
        .btn-action-outline { background: transparent; border: 1px solid var(--border-color); color: var(--text-primary); }
        .btn-action-outline:hover { border-color: var(--highlight); color: var(--highlight); }

        /* Responsive */
        @media (max-width: 900px) {
            .admin-sidebar { width: 70px; }
            .sidebar-brand span:not(.sidebar-brand-badge), .menu-heading, .menu-link span:not(.menu-icon), .user-info { display: none; }
            .sidebar-brand { justify-content: center; padding: 20px 0; }
            .menu-link { justify-content: center; padding: 12px 0; }
            .admin-main { margin-left: 70px; }
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <a href="{{ route('admin.index') }}" class="sidebar-brand">
            <span>🛡️ Classroom Hub</span>
            <span class="sidebar-brand-badge">Mod</span>
        </a>

        <ul class="sidebar-menu">
            <li class="menu-heading">Administration</li>
            <li>
                <a href="{{ route('admin.index') }}" class="menu-link {{ request()->routeIs('admin.index') ? 'active' : '' }}">
                    <span class="menu-icon">📊</span>
                    <span>Dashboard Overview</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users') }}" class="menu-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <span class="menu-icon">👥</span>
                    <span>User Management</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.classrooms') }}" class="menu-link {{ request()->routeIs('admin.classrooms') ? 'active' : '' }}">
                    <span class="menu-icon">🏫</span>
                    <span>Classroom Management</span>
                </a>
            </li>

            <li class="menu-heading">Safety & Governance</li>
            <li>
                <a href="{{ route('admin.moderation') }}" class="menu-link {{ request()->routeIs('admin.moderation') ? 'active' : '' }}">
                    <span class="menu-icon">🛡️</span>
                    <span>Content Moderation</span>
                </a>
            </li>

            <li class="menu-heading">Platform Shortcuts</li>
            <li>
                <a href="{{ route('teachers.index') }}" class="menu-link">
                    <span class="menu-icon">👩‍🏫</span>
                    <span>Teacher Portal</span>
                </a>
            </li>
            <li>
                <a href="{{ route('students.index') }}" class="menu-link">
                    <span class="menu-icon">👨‍🎓</span>
                    <span>Student Portal</span>
                </a>
            </li>
            <li>
                <a href="{{ route('dashboard') }}" class="menu-link">
                    <span class="menu-icon">🔙</span>
                    <span>User Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('profile.show') }}" class="menu-link">
                    <span class="menu-icon">⚙️</span>
                    <span>My Profile</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <div class="user-pill">
                <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div class="user-info">
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-role">{{ Auth::user()->role }}</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-action btn-action-danger" style="width: 100%; justify-content: center;">
                    🚪 Log Out
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="admin-main">
        <header class="admin-topbar">
            <h1 class="topbar-title">@yield('page_title', 'Moderation & Admin Console')</h1>
            <div class="topbar-actions">
                <button type="button" class="btn-theme-toggle" onclick="toggleTheme()" title="Switch Light & Dark Mode">
                    <span id="theme-icon">🌙 Mode</span>
                </button>
                <a href="{{ route('dashboard') }}" class="btn-portal-back">
                    &larr; Return to Learning Hub
                </a>
            </div>
        </header>

        <main class="admin-content">
            @if (session('success'))
                <div class="alert-success">
                    &check; {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert-error">
                    &cross; {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
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
    @yield('scripts')
</body>
</html>
