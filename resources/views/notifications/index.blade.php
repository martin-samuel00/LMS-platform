<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications & Alerts - Classroom Hub</title>
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
            --highlight: #4f46e5;
            --highlight-hover: #4338ca;
            --accent-glow: rgba(79, 70, 229, 0.12);
            --unread-bg: rgba(79, 70, 229, 0.04);
            --unread-border: rgba(79, 70, 229, 0.25);
        }

        [data-theme="dark"] {
            --bg-color: #0b0f19;
            --card-bg: #111827;
            --card-subtle: #1f2937;
            --border-color: #1f2937;
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --highlight: #6366f1;
            --highlight-hover: #4f46e5;
            --accent-glow: rgba(99, 102, 241, 0.18);
            --unread-bg: rgba(99, 102, 241, 0.08);
            --unread-border: rgba(99, 102, 241, 0.35);
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
            max-width: 860px;
            margin: 32px auto;
            padding: 0 20px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .page-header h1 {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--text-primary);
        }

        .page-header p {
            color: var(--text-secondary);
            font-size: 14px;
            margin-top: 3px;
        }

        .btn-action {
            background: var(--highlight);
            color: #ffffff;
            border: none;
            padding: 9px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.25);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-action:hover {
            background: var(--highlight-hover);
            transform: translateY(-1px);
        }

        .btn-dismiss {
            background: none;
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s;
        }

        .btn-dismiss:hover {
            background: var(--card-subtle);
            color: var(--text-primary);
        }

        .alert-success {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 22px;
            font-size: 14px;
            font-weight: 500;
        }

        /* Notification Card */
        .notification-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 20px 22px;
            margin-bottom: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 18px;
            transition: all 0.15s;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
            position: relative;
        }

        .notification-card:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
            border-color: var(--highlight);
        }

        .notification-card.unread {
            background: var(--unread-bg);
            border-color: var(--unread-border);
        }

        .notification-card.unread::before {
            content: '';
            position: absolute;
            left: 0;
            top: 14px;
            bottom: 14px;
            width: 4px;
            background: var(--highlight);
            border-radius: 0 4px 4px 0;
        }

        .notif-left {
            display: flex;
            align-items: flex-start;
            gap: 16px;
        }

        .notif-icon-wrap {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: var(--card-subtle);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        .notif-content h3 {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .notif-content p {
            font-size: 13.5px;
            color: var(--text-secondary);
            margin-bottom: 6px;
            line-height: 1.4;
        }

        .notif-time {
            font-size: 11.5px;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .empty-state {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 56px 24px;
            text-align: center;
            color: var(--text-secondary);
        }

        .empty-state .icon {
            font-size: 46px;
            margin-bottom: 12px;
            display: inline-block;
        }

        .empty-state h4 {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        .empty-state p {
            font-size: 14px;
            max-width: 400px;
            margin: 0 auto;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('dashboard') }}" class="nav-brand">
            <span class="brand-badge">🎓</span>
            <span>Classroom Hub</span>
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
            <a href="{{ route('messages.index') }}" class="nav-link">
                <span>💬</span>
                <span>Messages</span>
            </a>
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

        <div class="page-header">
            <div>
                <h1>Notifications & Alerts</h1>
                <p>Stay updated on assignments, quiz submissions, grades, and classroom announcements.</p>
            </div>
            @if ($notifications->isNotEmpty())
                <form action="{{ route('notifications.read-all') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-action">
                        <span>✓</span>
                        <span>Mark All as Read</span>
                    </button>
                </form>
            @endif
        </div>

        @if ($notifications->isEmpty())
            <div class="empty-state">
                <span class="icon">🔔</span>
                <h4>You're All Caught Up!</h4>
                <p>No new notifications at this time. Alerts for assignments, grades, announcements, and messages will appear here.</p>
            </div>
        @else
            @foreach ($notifications as $notif)
                <div class="notification-card {{ $notif->is_read ? '' : 'unread' }}">
                    <div class="notif-left">
                        <div class="notif-icon-wrap">
                            @if ($notif->type === 'assignment') 📌
                            @elseif ($notif->type === 'grade') 🎯
                            @elseif ($notif->type === 'material') 📚
                            @elseif ($notif->type === 'announcement') 📢
                            @elseif ($notif->type === 'join_request') ⏳
                            @elseif ($notif->type === 'message') 💬
                            @elseif ($notif->type === 'certificate') 🎓
                            @else 🔔 @endif
                        </div>
                        <div class="notif-content">
                            <h3>{{ $notif->title }}</h3>
                            <p>{{ $notif->message }}</p>
                            <span class="notif-time">{{ $notif->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <div>
                        @if ($notif->link)
                            <form action="{{ route('notifications.read', $notif) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-action" style="padding: 7px 16px; font-size: 12.5px;">
                                    <span>View</span>
                                    <span>&rarr;</span>
                                </button>
                            </form>
                        @elseif (!$notif->is_read)
                            <form action="{{ route('notifications.read', $notif) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-dismiss">Dismiss</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach

            <div style="margin-top: 24px;">
                {{ $notifications->links() }}
            </div>
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
