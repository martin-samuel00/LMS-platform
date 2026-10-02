<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set New Password - Classroom Hub</title>
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
            margin-bottom: 24px;
        }

        .header h1 {
            font-size: 22px;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        .header p {
            font-size: 13.5px;
            color: var(--text-secondary);
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
        }

        .error-message {
            color: #ef4444;
            font-size: 12px;
            font-weight: 600;
            margin-top: 6px;
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="brand-icon-wrap">
            <div class="brand-badge">🔒</div>
        </div>

        <div class="header">
            <h1>Create New Password</h1>
            <p>Choose a secure new password for your account</p>
        </div>

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label for="email">Account Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email', $email) }}" 
                    required 
                    readonly
                    style="opacity: 0.8; background: var(--card-bg);"
                >
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">New Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="Minimum 8 characters" 
                    required 
                    minlength="8"
                    autofocus
                >
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm New Password</label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    placeholder="Repeat password" 
                    required 
                    minlength="8"
                >
            </div>

            <button type="submit" class="btn-submit">Reset Password &rarr;</button>
        </form>
    </div>
</body>
</html>
