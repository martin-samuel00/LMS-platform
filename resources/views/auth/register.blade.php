<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - Classroom Hub</title>
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
            --card-subtle: #f8fafc;
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
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 32px 24px;
            position: relative;
            overflow-x: hidden;
        }

        /* Ambient glow */
        .ambient-glow {
            position: absolute;
            width: 550px;
            height: 550px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, transparent 70%);
            top: 20%;
            left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
            z-index: 0;
        }

        .top-nav {
            width: 100%;
            max-width: 480px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        .nav-back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 600;
        }

        .nav-back-link:hover {
            color: var(--highlight);
        }

        .btn-theme-toggle {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            padding: 6px 12px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
        }

        .auth-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            width: 100%;
            max-width: 480px;
            border-radius: 20px;
            box-shadow: 0 12px 36px -8px rgba(0, 0, 0, 0.08);
            padding: 38px 36px;
            position: relative;
            z-index: 1;
        }

        .brand-icon-wrap {
            display: flex;
            justify-content: center;
            margin-bottom: 18px;
        }

        .brand-badge {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #ffffff;
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.35);
        }

        .header {
            text-align: center;
            margin-bottom: 26px;
        }

        .header h1 {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        .header p {
            font-size: 14px;
            color: var(--text-secondary);
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 7px;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 11px 14px;
            font-size: 14px;
            border: 1.5px solid var(--input-border);
            border-radius: 10px;
            outline: none;
            background: var(--input-bg);
            color: var(--text-primary);
            transition: all 0.2s;
        }

        .form-group input:focus {
            border-color: var(--highlight);
            box-shadow: 0 0 0 3px var(--accent-glow);
        }

        .form-group input.is-invalid {
            border-color: #ef4444;
        }

        .error-message {
            color: #ef4444;
            font-size: 12px;
            font-weight: 600;
            margin-top: 5px;
        }

        /* Role Selection Cards */
        .role-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 6px;
        }

        .role-option {
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1.5px solid var(--border-color);
            background: var(--card-subtle);
            border-radius: 10px;
            padding: 12px 14px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            color: var(--text-primary);
            transition: all 0.15s;
        }

        .role-option:hover {
            border-color: var(--highlight);
            background: var(--accent-glow);
        }

        .role-option input[type="radio"] {
            accent-color: var(--highlight);
            width: 16px;
            height: 16px;
        }

        .btn-submit {
            width: 100%;
            padding: 13px;
            background: var(--highlight);
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
            margin-top: 10px;
        }

        .btn-submit:hover {
            background: var(--highlight-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(79, 70, 229, 0.4);
        }

        .footer-link {
            text-align: center;
            margin-top: 24px;
            font-size: 13.5px;
            color: var(--text-secondary);
        }

        .footer-link a {
            color: var(--highlight);
            font-weight: 700;
            text-decoration: none;
        }

        .footer-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="ambient-glow"></div>

    <div class="top-nav">
        <a href="{{ url('/') }}" class="nav-back-link">
            <span>&larr;</span>
            <span>Back to Home</span>
        </a>
        <button type="button" onclick="toggleTheme()" class="btn-theme-toggle" title="Toggle Light/Dark Theme">
            <span id="theme-icon">🌙</span>
        </button>
    </div>

    <div class="auth-card">
        <div class="brand-icon-wrap">
            <div class="brand-badge">🎓</div>
        </div>

        <div class="header">
            <h1>Create an Account</h1>
            <p>Join Classroom Hub to start learning or teaching</p>
        </div>

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label for="name">Full Name</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}" 
                    class="{{ $errors->has('name') ? 'is-invalid' : '' }}" 
                    placeholder="Jane Doe" 
                    required 
                    autofocus
                >
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Username -->
            <div class="form-group">
                <label for="username">Unique Username <span style="font-weight: normal; font-size: 11.5px; color: var(--text-secondary);">(Cannot be changed later)</span></label>
                <div style="position: relative;">
                    <span style="position: absolute; left: 14px; top: 12px; color: var(--text-secondary); font-weight: 700;">@</span>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        value="{{ old('username') }}" 
                        class="{{ $errors->has('username') ? 'is-invalid' : '' }}" 
                        placeholder="janedoe" 
                        style="padding-left: 34px;"
                        required 
                        minlength="3"
                        maxlength="30"
                        pattern="[A-Za-z0-9_\-]+"
                    >
                </div>
                @error('username')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email Address</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    class="{{ $errors->has('email') ? 'is-invalid' : '' }}" 
                    placeholder="jane@example.com" 
                    required
                >
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Phone Number (Optional) -->
            <div class="form-group">
                <label for="phone">Phone Number <span style="font-weight: normal; color: var(--text-secondary);">(Optional)</span></label>
                <input 
                    type="text" 
                    id="phone" 
                    name="phone" 
                    value="{{ old('phone') }}" 
                    placeholder="+1 (555) 000-0000"
                >
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Password <span style="font-weight: normal; font-size: 11.5px; color: var(--text-secondary);">(Min 8 characters)</span></label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="{{ $errors->has('password') ? 'is-invalid' : '' }}" 
                    placeholder="••••••••••••" 
                    required
                    minlength="8"
                    oninput="checkPasswordStrength(this.value)"
                >
                <div id="password-strength-bar" style="height: 4px; border-radius: 2px; margin-top: 6px; background: #e2e8f0; transition: all 0.3s; width: 0%;"></div>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    placeholder="Repeat password" 
                    required
                >
            </div>

            <!-- Role Selection -->
            <div class="form-group">
                <label>I am joining as:</label>
                <div class="role-grid">
                    <label class="role-option">
                        <input type="radio" name="role" value="student" {{ old('role', 'student') === 'student' ? 'checked' : '' }} required>
                        <span>👨‍🎓 Student</span>
                    </label>
                    <label class="role-option">
                        <input type="radio" name="role" value="teacher" {{ old('role') === 'teacher' ? 'checked' : '' }} required>
                        <span>👩‍🏫 Teacher</span>
                    </label>
                </div>
                @error('role')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-submit">Complete Sign Up &rarr;</button>
        </form>

        <div class="footer-link">
            Already have an account? <a href="{{ route('login') }}">Sign In</a>
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

        function checkPasswordStrength(val) {
            const bar = document.getElementById('password-strength-bar');
            if (!bar) return;
            let score = 0;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            if (val.length === 0) {
                bar.style.width = '0%';
                bar.style.background = '#e2e8f0';
            } else if (score <= 1) {
                bar.style.width = '25%';
                bar.style.background = '#ef4444';
            } else if (score === 2) {
                bar.style.width = '50%';
                bar.style.background = '#f59e0b';
            } else if (score === 3) {
                bar.style.width = '75%';
                bar.style.background = '#3b82f6';
            } else {
                bar.style.width = '100%';
                bar.style.background = '#10b981';
            }
        }

        updateThemeButton();
    </script>
</body>
</html>
