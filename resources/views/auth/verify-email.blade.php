<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email - Classroom Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/responsive-hub.css') }}">
    <script src="{{ asset('js/responsive-hub.js') }}" defer></script>
    <script>
        // Apply saved theme preference on load
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
            --test-box-bg: #f1f5f9;
            --highlight: #4f46e5;
            --highlight-hover: #4338ca;
        }

        [data-theme="dark"] {
            --bg-color: #0f172a;
            --card-bg: #1e293b;
            --border-color: #334155;
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --test-box-bg: #0f172a;
            --highlight: #6366f1;
            --highlight-hover: #4f46e5;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Inter', sans-serif; transition: background-color 0.2s, color 0.2s; }
        body {
            background-color: var(--bg-color);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px;
            color: var(--text-primary);
        }
        .top-nav {
            width: 100%;
            max-width: 520px;
            display: flex;
            justify-content: flex-end;
            margin-bottom: 14px;
        }
        .theme-toggle-btn {
            background: none;
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            padding: 6px 12px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
        }
        .theme-toggle-btn:hover {
            background: var(--border-color);
        }
        .card {
            background: var(--card-bg);
            width: 100%;
            max-width: 520px;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            padding: 36px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            text-align: center;
        }
        .icon {
            font-size: 48px;
            margin-bottom: 16px;
        }
        h1 {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 12px;
        }
        p {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 24px;
        }
        .alert-success {
            background-color: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
            border-radius: 8px;
            padding: 12px;
            font-size: 13px;
            margin-bottom: 20px;
        }
        .btn-resend {
            background: var(--highlight);
            color: #ffffff;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }
        .btn-resend:hover { background: var(--highlight-hover); }
        
        .test-box {
            margin-top: 24px;
            padding: 16px;
            background: var(--test-box-bg);
            border: 1px dashed var(--border-color);
            border-radius: 10px;
            text-align: left;
            font-size: 12px;
            color: var(--text-secondary);
        }
        .btn-instant-verify {
            display: inline-block;
            margin-top: 8px;
            background: #22c55e;
            color: #ffffff;
            text-decoration: none;
            padding: 8px 14px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 12px;
            transition: 0.15s;
        }
        .btn-instant-verify:hover { background: #16a34a; }
    </style>
</head>
<body>
    <div class="top-nav">
        <button onclick="toggleTheme()" class="theme-toggle-btn" title="Toggle Light/Dark Theme">🌓 Mode</button>
    </div>

    <div class="card">
        <div class="icon">✉️</div>
        <h1>Verify Your Email Address</h1>
        
        @if (session('status') == 'verification-link-sent' || session('success'))
            <div class="alert-success">
                A new verification link has been sent to <strong>{{ Auth::user()->email }}</strong>!
            </div>
        @endif

        <p>
            Thanks for joining Classroom Hub! Before accessing all features, please verify your email address by clicking on the link we just sent to: <br>
            <strong style="color: var(--text-primary);">{{ Auth::user()->email }}</strong>
        </p>

        <form action="{{ route('verification.send') }}" method="POST" style="margin-bottom: 16px;">
            @csrf
            <button type="submit" class="btn-resend">Resend Verification Email</button>
        </form>

        <!-- Quick Verification Box (Supports both log mailer & direct verification) -->
        @php
            $verifyUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute(
                'verification.verify',
                now()->addMinutes(60),
                ['id' => Auth::user()->getKey(), 'hash' => sha1(Auth::user()->getEmailForVerification())]
            );
        @endphp
        <div class="test-box">
            <strong style="color: var(--text-primary); display: block; margin-bottom: 4px;">⚡ Instant One-Click Verification:</strong>
            <span>Your local mailer is active. Click below to verify your account immediately:</span>
            <div>
                <a href="{{ $verifyUrl }}" class="btn-instant-verify">Verify Email Now &rarr;</a>
            </div>
        </div>

        <div style="margin-top: 24px; border-top: 1px solid var(--border-color); padding-top: 16px; display: flex; justify-content: space-between; font-size: 13px;">
            <a href="{{ route('profile.show') }}" style="color: var(--text-secondary); text-decoration: none;">Edit Email in Profile</a>
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; font-weight: 600;">Log Out</button>
            </form>
        </div>
    </div>

    <script>
        function toggleTheme() {
            const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        }
    </script>
</body>
</html>
