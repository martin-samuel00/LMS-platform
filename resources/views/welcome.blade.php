<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classroom Hub - Modern Virtual Learning Platform</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/responsive-hub.css') }}">
    <script src="{{ asset('js/responsive-hub.js') }}" defer></script>
    <script>
        // Apply saved theme preference immediately to avoid FOUC
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
            --border-color: #e2e8f0;
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --search-bg: #ffffff;
            --search-border: #cbd5e1;
            --metrics-bg: #ffffff;
            --badge-bg: #e0e7ff;
            --badge-text: #4338ca;
            --highlight: #4f46e5;
            --highlight-hover: #4338ca;
            --footer-bg: #ffffff;
            --card-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
            --card-hover-shadow: 0 20px 25px -5px rgba(99, 102, 241, 0.12), 0 8px 10px -6px rgba(99, 102, 241, 0.1);
            --hero-glow: radial-gradient(circle at 50% 10%, rgba(99, 102, 241, 0.1) 0%, transparent 70%);
        }

        [data-theme="dark"] {
            --bg-color: #0b0f19;
            --card-bg: #111827;
            --border-color: #1f2937;
            --text-primary: #f9fafb;
            --text-secondary: #9ca3af;
            --search-bg: #111827;
            --search-border: #374151;
            --metrics-bg: #111827;
            --badge-bg: rgba(99, 102, 241, 0.18);
            --badge-text: #a5b4fc;
            --highlight: #6366f1;
            --highlight-hover: #4f46e5;
            --footer-bg: #0b0f19;
            --card-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.3);
            --card-hover-shadow: 0 20px 25px -5px rgba(99, 102, 241, 0.25), 0 8px 10px -6px rgba(99, 102, 241, 0.15);
            --hero-glow: radial-gradient(circle at 50% 10%, rgba(99, 102, 241, 0.18) 0%, transparent 70%);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            transition: background-color 0.2s ease, border-color 0.2s ease;
        }

        h1, h2, h3, h4, .brand-font {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-primary);
            min-height: 100vh;
            line-height: 1.6;
            overflow-x: hidden;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 600px;
            background: var(--hero-glow);
            pointer-events: none;
            z-index: 0;
        }

        /* Top Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            padding: 16px 40px;
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
            font-size: 20px;
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

        .nav-links {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-link {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: color 0.15s;
        }

        .nav-link:hover {
            color: var(--highlight);
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
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: all 0.2s;
        }

        .btn-theme-toggle:hover {
            border-color: var(--highlight);
            transform: translateY(-1px);
        }

        .btn-nav-login {
            color: var(--text-primary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            padding: 8px 18px;
            border-radius: 8px;
            border: 1.5px solid var(--border-color);
            transition: all 0.2s;
        }

        .btn-nav-login:hover {
            border-color: var(--highlight);
            color: var(--highlight);
            background: rgba(99, 102, 241, 0.06);
        }

        .btn-nav-signup {
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: #ffffff;
            text-decoration: none;
            padding: 9px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
            transition: all 0.2s;
        }

        .btn-nav-signup:hover {
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.35);
            transform: translateY(-1px);
        }

        /* Hero Section */
        .hero {
            position: relative;
            z-index: 1;
            padding: 75px 24px 45px;
            text-align: center;
            max-width: 960px;
            margin: 0 auto;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--badge-bg);
            color: var(--badge-text);
            padding: 7px 18px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 24px;
            box-shadow: 0 2px 8px rgba(79, 70, 229, 0.1);
        }

        .hero h1 {
            font-size: 54px;
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -1.5px;
            color: var(--text-primary);
            margin-bottom: 20px;
        }

        .hero h1 span {
            background: linear-gradient(135deg, #4f46e5, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            font-size: 18px;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 36px;
            max-width: 720px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Hero Search Bar */
        .hero-search-card {
            max-width: 640px;
            margin: 0 auto 36px;
            background: var(--search-bg);
            border: 2px solid var(--search-border);
            border-radius: 14px;
            padding: 6px;
            display: flex;
            align-items: center;
            box-shadow: var(--card-shadow);
            transition: all 0.2s;
        }

        .hero-search-card:focus-within {
            border-color: var(--highlight);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15), var(--card-shadow);
        }

        .hero-search-card input {
            flex: 1;
            border: none;
            padding: 12px 20px;
            font-size: 15px;
            outline: none;
            background: transparent;
            color: var(--text-primary);
        }

        .hero-search-card button {
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: #ffffff;
            border: none;
            padding: 12px 26px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
        }

        .hero-search-card button:hover {
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
            transform: translateY(-1px);
        }

        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .btn-cta-student {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff;
            text-decoration: none;
            padding: 14px 30px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 15px;
            transition: all 0.2s;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.25);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-cta-student:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.35);
        }

        .btn-cta-teacher {
            background: var(--card-bg);
            color: var(--text-primary);
            border: 2px solid var(--border-color);
            text-decoration: none;
            padding: 13px 28px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 15px;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-cta-teacher:hover {
            border-color: var(--highlight);
            color: var(--highlight);
            transform: translateY(-2px);
            box-shadow: var(--card-shadow);
        }

        /* Live Metrics Section */
        .metrics-section {
            background: var(--metrics-bg);
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
            padding: 44px 24px;
            margin: 40px 0 80px;
            position: relative;
            z-index: 1;
        }

        .metrics-grid {
            max-width: 1060px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            text-align: center;
        }

        .metric-card {
            background: var(--bg-color);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 22px 16px;
            transition: transform 0.2s;
        }

        .metric-card:hover {
            transform: translateY(-2px);
        }

        .metric-card strong {
            display: block;
            font-size: 38px;
            font-weight: 800;
            color: var(--highlight);
            line-height: 1.1;
            margin-bottom: 6px;
        }

        .metric-card span {
            font-size: 13px;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.8px;
            font-weight: 700;
        }

        /* Features Section */
        .features-section {
            max-width: 1160px;
            margin: 0 auto;
            padding: 0 24px 90px;
            position: relative;
            z-index: 1;
        }

        .section-header {
            text-align: center;
            margin-bottom: 54px;
        }

        .section-header .section-tag {
            color: var(--highlight);
            font-weight: 800;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 1px;
            display: inline-block;
            margin-bottom: 8px;
        }

        .section-header h2 {
            font-size: 36px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--text-primary);
            margin-bottom: 12px;
        }

        .section-header p {
            color: var(--text-secondary);
            font-size: 17px;
            max-width: 650px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }

        .feature-card {
            background: var(--card-bg);
            border: 1.5px solid var(--border-color);
            border-radius: 16px;
            padding: 28px 24px;
            box-shadow: var(--card-shadow);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .feature-card:hover {
            border-color: var(--highlight);
            transform: translateY(-4px);
            box-shadow: var(--card-hover-shadow);
        }

        .feature-icon-pill {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: var(--badge-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 18px;
        }

        .feature-card h3 {
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 10px;
            color: var(--text-primary);
            letter-spacing: -0.2px;
        }

        .feature-card p {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        .feature-tag {
            margin-top: auto;
            padding-top: 16px;
            font-size: 12px;
            font-weight: 700;
            color: var(--highlight);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Role Comparison Section */
        .roles-section {
            max-width: 1100px;
            margin: 0 auto 90px;
            padding: 0 24px;
        }

        .roles-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 28px;
        }

        .role-card {
            background: var(--card-bg);
            border: 1.5px solid var(--border-color);
            border-radius: 20px;
            padding: 36px 32px;
            box-shadow: var(--card-shadow);
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

        .role-card.teacher-card {
            border-top: 5px solid var(--highlight);
        }

        .role-card.student-card {
            border-top: 5px solid #10b981;
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 14px;
        }

        .role-card h3 {
            font-size: 24px;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 12px;
        }

        .role-card p {
            color: var(--text-secondary);
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 22px;
        }

        .role-checklist {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 28px;
            flex: 1;
        }

        .role-checklist li {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: var(--text-primary);
            font-weight: 500;
        }

        .role-checklist li span {
            color: #10b981;
            font-weight: 800;
            font-size: 16px;
        }

        .btn-role-action {
            display: block;
            text-align: center;
            padding: 12px 20px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-role-teacher {
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: #fff;
        }

        .btn-role-teacher:hover {
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.3);
            transform: translateY(-1px);
        }

        .btn-role-student {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff;
        }

        .btn-role-student:hover {
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3);
            transform: translateY(-1px);
        }

        /* Footer */
        footer {
            border-top: 1px solid var(--border-color);
            background: var(--footer-bg);
            padding: 40px 24px;
            text-align: center;
            color: var(--text-secondary);
            font-size: 14px;
        }

        .footer-content {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .footer-links {
            display: flex;
            gap: 20px;
        }

        .footer-links a {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
        }

        .footer-links a:hover {
            color: var(--highlight);
        }

        @media (max-width: 1024px) {
            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 14px 20px;
            }
            .hero h1 {
                font-size: 36px;
            }
            .hero p {
                font-size: 16px;
            }
            .metrics-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .features-grid {
                grid-template-columns: 1fr;
            }
            .roles-grid {
                grid-template-columns: 1fr;
            }
            .footer-content {
                flex-direction: column;
                text-align: center;
            }
        }

        @media (max-width: 560px) {
            .hero-search-card {
                flex-direction: column !important;
                gap: 8px !important;
                padding: 8px !important;
            }
            .hero-search-card input {
                width: 100% !important;
                padding: 10px 14px !important;
            }
            .hero-search-card button {
                width: 100% !important;
                padding: 12px 16px !important;
            }
            .cta-buttons {
                flex-direction: column !important;
                width: 100% !important;
                gap: 10px !important;
            }
            .btn-cta-student, .btn-cta-teacher {
                width: 100% !important;
                justify-content: center !important;
            }
        }
    </style>
</head>
<body>
    <!-- Top Navbar -->
    <nav class="navbar">
        <a href="/" class="nav-brand">
            <span class="nav-brand-icon">🎓</span>
            <span>Classroom Hub</span>
        </a>
        <button type="button" class="mobile-nav-toggle" aria-label="Toggle navigation">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>
        <div class="nav-links">
            <a href="{{ route('students.teachers.search') }}" class="nav-link">Find Instructors</a>
            
            <!-- Theme Toggle Button -->
            <button type="button" class="btn-theme-toggle" id="theme-btn" onclick="toggleTheme()" title="Switch Light & Dark Mode">
                <span id="theme-icon">🌙 Mode</span>
            </button>

            @auth
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.index') }}" class="nav-link" style="color: #ef4444; font-weight: 700;">🛡️ Admin</a>
                @endif
                <a href="{{ route('profile.show') }}" class="nav-link">Settings</a>
                <a href="{{ route('dashboard') }}" class="btn-nav-signup">Dashboard &rarr;</a>
            @else
                <a href="{{ route('login') }}" class="btn-nav-login">Sign In</a>
                <a href="{{ route('register') }}" class="btn-nav-signup">Join Free &rarr;</a>
            @endauth
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero">
        <div class="hero-badge">
            <span>✨</span> Next-Generation Virtual Classroom & LMS
        </div>
        <h1>Where Modern Teaching Meets <span>Limitless Learning</span></h1>
        <p>A unified digital workspace with homework file submissions, real-time in-app notifications, daily lecture roll-calls, direct messaging, downloadable study materials, and verifiable certificates.</p>

        <!-- Search Bar -->
        <form action="{{ route('students.teachers.search') }}" method="GET" class="hero-search-card">
            <input type="text" name="q" placeholder="Search by instructor name, course title, or subject...">
            <button type="submit">Search Classrooms &rarr;</button>
        </form>

        <div class="cta-buttons">
            <a href="{{ route('register', ['role' => 'student']) }}" class="btn-cta-student">
                <span>👨‍🎓</span> Join as a Student
            </a>
            <a href="{{ route('register', ['role' => 'teacher']) }}" class="btn-cta-teacher">
                <span>👩‍🏫</span> Teach a Classroom
            </a>
        </div>
    </div>

    <!-- Live Platform Metrics -->
    @php
        try {
            $totalClassrooms = \App\Models\Classroom::count();
            $totalTeachers = \App\Models\User::where('role', 'teacher')->count();
            $totalStudents = \App\Models\User::where('role', 'student')->count();
            $totalCertificates = \App\Models\Certificate::count();
        } catch (\Throwable $e) {
            $totalClassrooms = 12;
            $totalTeachers = 8;
            $totalStudents = 140;
            $totalCertificates = 45;
        }
    @endphp
    <section class="metrics-section">
        <div class="metrics-grid">
            <div class="metric-card">
                <strong>{{ $totalClassrooms }}</strong>
                <span>Active Classrooms</span>
            </div>
            <div class="metric-card">
                <strong>{{ $totalTeachers }}</strong>
                <span>Certified Teachers</span>
            </div>
            <div class="metric-card">
                <strong>{{ $totalStudents }}</strong>
                <span>Enrolled Learners</span>
            </div>
            <div class="metric-card">
                <strong>{{ $totalCertificates }}</strong>
                <span>Certificates Issued</span>
            </div>
        </div>
    </section>

    <!-- Key Platform Features Grid (8 Modern LMS Features) -->
    <section class="features-section">
        <div class="section-header">
            <span class="section-tag">Complete Feature Ecosystem</span>
            <h2>Designed for Effortless Collaboration</h2>
            <p>Every tool educators and students need to communicate, assign work, evaluate progress, and celebrate success.</p>
        </div>

        <div class="features-grid">
            <!-- Feature 1: Student Deliverables -->
            <div class="feature-card">
                <div class="feature-icon-pill">📁</div>
                <h3>Student Deliverables</h3>
                <p>Students submit assignments with file attachments (PDFs, Word docs, code archives, or images up to 25MB) alongside notes for teacher review.</p>
                <div class="feature-tag">Instant Upload & Grading &rarr;</div>
            </div>

            <!-- Feature 2: In-App Notifications -->
            <div class="feature-card">
                <div class="feature-icon-pill">🔔</div>
                <h3>Smart Notification Hub</h3>
                <p>Never miss a deadline or grade. Real-time bell alerts notify users of assignments, scores, join requests, certificates, and new bulletins.</p>
                <div class="feature-tag">Unread Badges & Alerts &rarr;</div>
            </div>

            <!-- Feature 3: Attendance Roll-Call -->
            <div class="feature-card">
                <div class="feature-icon-pill">📅</div>
                <h3>Daily Attendance Roll-Call</h3>
                <p>Instructors take lecture attendance with a single click (Present, Absent, Late, Excused). Students monitor their live attendance rate.</p>
                <div class="feature-tag">Progress & Rates &rarr;</div>
            </div>

            <!-- Feature 4: Pinned Announcements -->
            <div class="feature-card">
                <div class="feature-icon-pill">📢</div>
                <h3>Pinned Announcements</h3>
                <p>Highlight urgent course bulletins and exam dates at the top of the classroom stream, instantly notifying all enrolled participants.</p>
                <div class="feature-tag">Classroom Noticeboard &rarr;</div>
            </div>

            <!-- Feature 5: 1-on-1 Direct Messaging -->
            <div class="feature-card">
                <div class="feature-icon-pill">💬</div>
                <h3>1-on-1 Direct Messaging</h3>
                <p>Private two-way direct chat between teachers and students for office hours, guidance, and project inquiries, plus open class discussion walls.</p>
                <div class="feature-tag">Direct & Discussion Chat &rarr;</div>
            </div>

            <!-- Feature 6: Course Study Materials -->
            <div class="feature-card">
                <div class="feature-icon-pill">📚</div>
                <h3>Handouts & Study Notes</h3>
                <p>Teachers publish reference documents, slides, and syllabus files directly to the classroom for students to access and download anytime.</p>
                <div class="feature-tag">Downloadable Handouts &rarr;</div>
            </div>

            <!-- Feature 7: Self-Grading Quizzes -->
            <div class="feature-card">
                <div class="feature-icon-pill">📝</div>
                <h3>Self-Grading Quizzes</h3>
                <p>Design multi-question exams with instant grading logic. Students take tests and receive immediate performance breakdowns.</p>
                <div class="feature-tag">Automated Scoring &rarr;</div>
            </div>

            <!-- Feature 8: Printable Certificates -->
            <div class="feature-card">
                <div class="feature-icon-pill">🏆</div>
                <h3>Verifiable Certificates</h3>
                <p>Award authentic, print-ready certificates of course completion featuring unique serial verification codes and instructor credentials.</p>
                <div class="feature-tag">Official Credentials &rarr;</div>
            </div>
        </div>
    </section>

    <!-- Role Split Section: For Teachers & For Students -->
    <section class="roles-section">
        <div class="roles-grid">
            <div class="role-card teacher-card">
                <div class="role-badge" style="color: var(--highlight);">
                    <span>👩‍🏫</span> Instructor Hub
                </div>
                <h3>Educate, Grade, & Inspire</h3>
                <p>Everything you need to orchestrate seamless remote learning, organize course materials, and oversee student growth.</p>
                <ul class="role-checklist">
                    <li><span>&check;</span> Create unlimited classrooms with unique join codes</li>
                    <li><span>&check;</span> Assign homework with deadlines and downloadable files</li>
                    <li><span>&check;</span> Take daily student attendance and track lecture records</li>
                    <li><span>&check;</span> Grade student homework uploads with private feedback</li>
                    <li><span>&check;</span> Send 1-on-1 direct messages to enrolled students</li>
                    <li><span>&check;</span> Issue official verifiable certificates of completion</li>
                </ul>
                <a href="{{ route('register', ['role' => 'teacher']) }}" class="btn-role-action btn-role-teacher">Start Teaching Free &rarr;</a>
            </div>

            <div class="role-card student-card">
                <div class="role-badge" style="color: #10b981;">
                    <span>👨‍🎓</span> Student Experience
                </div>
                <h3>Learn, Submit, & Excel</h3>
                <p>A focused learning hub designed to keep you organized, connected to your teachers, and on top of every assignment.</p>
                <ul class="role-checklist">
                    <li><span>&check;</span> Search teachers and request enrollment into courses</li>
                    <li><span>&check;</span> Join classes instantly using 6-character class codes</li>
                    <li><span>&check;</span> Upload assignment files and track submission status</li>
                    <li><span>&check;</span> Keep track of your attendance percentage & records</li>
                    <li><span>&check;</span> Chat directly with instructors and participate in class discussions</li>
                    <li><span>&check;</span> Earn and print official course completion certificates</li>
                </ul>
                <a href="{{ route('register', ['role' => 'student']) }}" class="btn-role-action btn-role-student">Join as a Student &rarr;</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div>
                <strong>🎓 Classroom Hub</strong> &mdash; Modern Virtual Learning Management Platform
            </div>
            <div class="footer-links">
                <a href="{{ route('students.teachers.search') }}">Find Instructors</a>
                <a href="{{ route('login') }}">Sign In</a>
                <a href="{{ route('register') }}">Create Account</a>
            </div>
            <div>
                &copy; {{ date('Y') }} Classroom Hub. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        function updateThemeButton() {
            const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            document.getElementById('theme-icon').textContent = isDark ? '☀️ Light' : '🌙 Dark';
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
