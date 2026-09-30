<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Classroom Hub</title>
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
            padding: 24px;
            position: relative;
            overflow-x: hidden;
        }

        /* Ambient glow backdrop */
        .ambient-glow {
            position: absolute;
            width: 500px;
            height: 500px;
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
            max-width: 440px;
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
            transition: color 0.15s;
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
            max-width: 440px;
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
            margin-bottom: 28px;
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

        .alert-success {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 16px;
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
            margin-top: 6px;
        }

        .remember-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
        }

        .remember-row input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--highlight);
            cursor: pointer;
        }

        .remember-row label {
            font-size: 13px;
            color: var(--text-secondary);
            cursor: pointer;
            user-select: none;
            font-weight: 500;
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
        }

        .btn-submit:hover {
            background: var(--highlight-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(79, 70, 229, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
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
            <h1>Welcome Back</h1>
            <p>Sign in with your email or username</p>
        </div>

        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <!-- Email or Username -->
            <div class="form-group">
                <label for="email">Email Address or Username</label>
                <input 
                    type="text" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    class="{{ $errors->has('email') ? 'is-invalid' : '' }}" 
                    placeholder="john@example.com or admin" 
                    required 
                    autofocus
                >
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="{{ $errors->has('password') ? 'is-invalid' : '' }}" 
                    placeholder="••••••••••••" 
                    required
                >
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="remember-row">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Remember me on this device</label>
            </div>

            <button type="submit" class="btn-submit">Sign In &rarr;</button>
        </form>

        <div class="footer-link">
            Don't have an account? <a href="{{ route('register') }}">Create an Account</a>
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

        updateThemeButton();
    </script>
</body>
</html>
