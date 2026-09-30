<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Portal - Classroom Hub</title>
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
            --card-hover-shadow: 0 20px 25px -5px rgba(99, 102, 241, 0.12), 0 8px 10px -6px rgba(99, 102, 241, 0.08);
            --hero-gradient: linear-gradient(135deg, #3730a3 0%, #4f46e5 100%);
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
            max-width: 1140px;
            margin: 32px auto 60px;
            padding: 0 24px;
            width: 100%;
        }

        /* Header Hero Banner */
        .teacher-hero {
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

        .teacher-hero h1 {
            font-size: 26px;
            font-weight: 800;
            margin-bottom: 6px;
            letter-spacing: -0.5px;
        }

        .teacher-hero p {
            font-size: 14px;
            opacity: 0.9;
            max-width: 580px;
            line-height: 1.5;
        }

        .btn-create-modal {
            background: #ffffff;
            color: #4f46e5;
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 800;
            font-size: 14px;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-create-modal:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        /* Flash Alerts */
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

        .alert-error {
            background-color: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 14px;
            margin-bottom: 24px;
            font-weight: 500;
        }

        [data-theme="dark"] .alert-error {
            background-color: rgba(239, 68, 68, 0.15);
            color: #fca5a5;
            border-color: #991b1b;
        }

        /* Form Card */
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
            margin-bottom: 20px;
        }

        .card h2 {
            font-size: 20px;
            font-weight: 800;
            color: var(--text-primary);
            letter-spacing: -0.3px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
            margin-bottom: 18px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group.full {
            grid-column: span 2;
        }

        .form-group label {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .form-group input, .form-group textarea {
            padding: 12px 14px;
            background: var(--input-bg);
            color: var(--text-primary);
            border: 1.5px solid var(--input-border);
            border-radius: 10px;
            font-size: 14px;
            outline: none;
            transition: all 0.2s;
        }

        .form-group input:focus, .form-group textarea:focus {
            border-color: var(--highlight);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }

        .btn-submit {
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: #fff;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.35);
        }

        /* Classroom Grid */
        .classes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 22px;
        }

        .class-card {
            background: var(--card-bg);
            border: 1.5px solid var(--border-color);
            border-radius: 16px;
            padding: 24px;
            box-shadow: var(--card-shadow);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
        }

        .class-card:hover {
            border-color: var(--highlight);
            transform: translateY(-4px);
            box-shadow: var(--card-hover-shadow);
        }

        .class-card-top {
            margin-bottom: 16px;
        }

        .class-badge-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .subject-pill {
            background: var(--badge-bg);
            color: var(--badge-text);
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .code-pill {
            background: var(--subcard-bg);
            border: 1px solid var(--border-color);
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            color: var(--highlight);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: all 0.15s;
        }

        .code-pill:hover {
            border-color: var(--highlight);
            background: rgba(99, 102, 241, 0.08);
        }

        .class-card h3 {
            font-size: 18px;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 6px;
            letter-spacing: -0.2px;
        }

        .class-desc {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 14px;
        }

        .pending-notice {
            background: #fef3c7;
            color: #92400e;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-bottom: 12px;
        }

        [data-theme="dark"] .pending-notice {
            background: rgba(245, 158, 11, 0.2);
            color: #fcd34d;
        }

        .class-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 6px;
            background: var(--subcard-bg);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 10px 6px;
            text-align: center;
            margin-bottom: 16px;
        }

        .class-stat-box span {
            display: block;
            font-size: 10px;
            color: var(--text-secondary);
            text-transform: uppercase;
            font-weight: 700;
        }

        .class-stat-box strong {
            font-size: 15px;
            font-weight: 800;
            color: var(--text-primary);
        }

        .btn-manage-class {
            display: block;
            text-align: center;
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: #fff;
            padding: 11px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
            transition: all 0.2s;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.2);
        }

        .btn-manage-class:hover {
            box-shadow: 0 6px 14px rgba(79, 70, 229, 0.3);
            transform: translateY(-1px);
        }

        .empty-state {
            text-align: center;
            padding: 50px 20px;
            color: var(--text-secondary);
        }

        .empty-icon {
            font-size: 48px;
            margin-bottom: 12px;
        }

        @media (max-width: 768px) {
            .navbar { padding: 14px 20px; }
            .teacher-hero { padding: 24px; }
            .form-grid { grid-template-columns: 1fr; }
            .form-group.full { grid-column: span 1; }
            .classes-grid { grid-template-columns: 1fr; }
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
        <button type="button" class="mobile-nav-toggle" aria-label="Toggle navigation">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>
        <div class="navbar-actions">
            <button onclick="toggleTheme()" class="btn-theme-toggle" title="Toggle Light/Dark Theme">
                <span id="theme-icon">🌙 Mode</span>
            </button>

            <a href="{{ route('notifications.index') }}" class="nav-link" style="position: relative;">
                <span>🔔</span> Notifications
                @php $unreadCount = Auth::user()->unreadNotifications()->count(); @endphp
                @if ($unreadCount > 0)
                    <span style="background: #ef4444; color: #fff; border-radius: 999px; padding: 2px 7px; font-size: 10px; font-weight: 800; margin-left: 2px;">{{ $unreadCount }}</span>
                @endif
            </a>

            <a href="{{ route('messages.index') }}" class="nav-link">
                <span>💬</span> Messages
            </a>

            @if(Auth::user()->isAdmin())
                <a href="{{ route('admin.index') }}" class="nav-link" style="color: #ef4444; font-weight: 700; background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2);">
                    <span>🛡️</span> Admin Console
                </a>
            @endif

            <a href="{{ route('profile.show') }}" class="nav-link">
                <span>⚙️</span> Profile
            </a>

            <a href="{{ route('dashboard') }}" class="nav-link">
                <span>🔙</span> Dashboard
            </a>

            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout">Log Out</button>
            </form>
        </div>
    </nav>

    <div class="container">
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

        <!-- Teacher Hero Banner -->
        <div class="teacher-hero">
            <div>
                <h1>Teacher Classroom Management</h1>
                <p>Launch courses, organize lecture materials, track daily roll-calls, review student homework submissions, and award official certificates.</p>
            </div>
            <button type="button" class="btn-create-modal" onclick="document.getElementById('createCard').scrollIntoView({ behavior: 'smooth' });">
                <span>➕</span> Create New Classroom
            </button>
        </div>

        <!-- Create Classroom Form Card -->
        <div class="card" id="createCard">
            <div class="card-header">
                <h2>➕ Launch a New Virtual Classroom</h2>
            </div>
            <form action="{{ route('teachers.classroom.store') }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">Classroom Title *</label>
                        <input type="text" id="name" name="name" placeholder="e.g. Advanced Web Development, Linear Algebra" required>
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject / Department</label>
                        <input type="text" id="subject" name="subject" placeholder="e.g. Computer Science, Mathematics">
                    </div>

                    <div class="form-group full">
                        <label for="description">Classroom Overview & Objectives</label>
                        <textarea id="description" name="description" rows="2" placeholder="Briefly describe what students will learn, syllabus highlights, or prerequisites..."></textarea>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    🚀 Create & Generate Class Code
                </button>
            </form>
        </div>

        <!-- My Classrooms Grid -->
        <div class="card">
            <div class="card-header">
                <h2>📚 My Active Classrooms ({{ $classrooms->count() }})</h2>
            </div>

            @if ($classrooms->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">🏫</div>
                    <h3 style="font-size: 18px; font-weight: 800; color: var(--text-primary); margin-bottom: 6px;">No classrooms created yet</h3>
                    <p style="font-size: 14px; max-width: 440px; margin: 0 auto 20px;">Use the form above to launch your first virtual classroom and share the invite code with your students.</p>
                </div>
            @else
                <div class="classes-grid">
                    @foreach ($classrooms as $c)
                        <div class="class-card">
                            <div class="class-card-top">
                                <div class="class-badge-row">
                                    <span class="subject-pill">{{ $c->subject ?: 'General' }}</span>
                                    <span class="code-pill" onclick="copyCode('{{ $c->code }}', this)" title="Click to copy invite code">
                                        <span>🔑 {{ $c->code }}</span>
                                        <small style="font-size: 10px; opacity: 0.7;">COPY</small>
                                    </span>
                                </div>

                                <h3>{{ $c->name }}</h3>
                                <div class="class-desc">{{ $c->description ?: 'No syllabus description provided for this classroom.' }}</div>

                                @if ($c->pending_students_count > 0)
                                    <div class="pending-notice">
                                        ⏳ {{ $c->pending_students_count }} pending join request(s)
                                    </div>
                                @endif
                            </div>

                            <div>
                                <div class="class-stats">
                                    <div class="class-stat-box">
                                        <span>Students</span>
                                        <strong>{{ $c->students_count }}</strong>
                                    </div>
                                    <div class="class-stat-box">
                                        <span>Files</span>
                                        <strong>{{ $c->materials_count }}</strong>
                                    </div>
                                    <div class="class-stat-box">
                                        <span>Tasks</span>
                                        <strong>{{ $c->assignments_count }}</strong>
                                    </div>
                                    <div class="class-stat-box">
                                        <span>Quizzes</span>
                                        <strong>{{ $c->quizzes_count }}</strong>
                                    </div>
                                </div>

                                <a href="{{ route('teachers.classroom', $c) }}" class="btn-manage-class">
                                    Manage Classroom &rarr;
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <script>
        function copyCode(code, element) {
            navigator.clipboard.writeText(code).then(() => {
                const originalHtml = element.innerHTML;
                element.innerHTML = '<span>&check; COPIED!</span>';
                element.style.borderColor = '#10b981';
                element.style.color = '#10b981';
                setTimeout(() => {
                    element.innerHTML = originalHtml;
                    element.style.borderColor = '';
                    element.style.color = '';
                }, 2000);
            });
        }

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
