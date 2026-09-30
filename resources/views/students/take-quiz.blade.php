<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $quiz->title }} - Taking Quiz</title>
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
            --option-bg: #ffffff;
            --option-border: #cbd5e1;
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
            --option-bg: #111827;
            --option-border: #374151;
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
            gap: 8px;
            font-size: 14.5px;
            font-weight: 700;
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.15s;
        }

        .nav-brand:hover {
            color: var(--highlight);
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
            max-width: 800px;
            margin: 32px auto;
            padding: 0 20px;
        }

        .card {
            background: var(--card-bg);
            border-radius: 18px;
            border: 1px solid var(--border-color);
            padding: 34px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.03);
            margin-bottom: 24px;
        }

        .quiz-header {
            margin-bottom: 26px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 18px;
        }

        .quiz-header h1 {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        .quiz-header p {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        .meta-pills {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .meta-pill {
            background: var(--card-subtle);
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 12.5px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .question-card {
            background: var(--card-subtle);
            border: 1.5px solid var(--border-color);
            border-radius: 14px;
            padding: 24px;
            margin-bottom: 22px;
            transition: border-color 0.2s;
        }

        .question-card:hover {
            border-color: var(--highlight);
        }

        .q-number {
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--highlight);
            margin-bottom: 6px;
        }

        .q-text {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 18px;
            line-height: 1.5;
        }

        .options-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .option-label {
            display: flex;
            align-items: center;
            gap: 14px;
            background: var(--option-bg);
            border: 1.5px solid var(--option-border);
            border-radius: 12px;
            padding: 14px 18px;
            cursor: pointer;
            transition: all 0.15s;
            font-size: 14.5px;
            color: var(--text-primary);
        }

        .option-label:hover {
            border-color: var(--highlight);
            background: var(--accent-glow);
        }

        .option-label input[type="radio"] {
            width: 18px;
            height: 18px;
            accent-color: var(--highlight);
            cursor: pointer;
            flex-shrink: 0;
        }

        .btn-submit {
            background: var(--highlight);
            color: #ffffff;
            border: none;
            padding: 14px 28px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 800;
            cursor: pointer;
            width: 100%;
            transition: all 0.2s;
            box-shadow: 0 6px 18px rgba(79, 70, 229, 0.35);
        }

        .btn-submit:hover {
            background: var(--highlight-hover);
            transform: translateY(-1px);
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('students.classroom', $classroom) }}" class="nav-brand">
            <span>&larr;</span>
            <span>Back to {{ $classroom->name }}</span>
        </a>
        <div class="nav-links">
            <button type="button" onclick="toggleTheme()" class="btn-theme-toggle" title="Toggle Light/Dark Theme">
                <span id="theme-icon">🌙</span>
            </button>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <div class="quiz-header">
                <h1>{{ $quiz->title }}</h1>
                <div class="meta-pills">
                    <span class="meta-pill">Pass Score: {{ $quiz->pass_percentage }}%</span>
                    <span class="meta-pill">Total Questions: {{ $quiz->questions->count() }}</span>
                </div>
                @if ($quiz->description)
                    <p style="margin-top: 12px;">{{ $quiz->description }}</p>
                @endif
            </div>

            <form action="{{ route('students.quiz.submit', $quiz) }}" method="POST">
                @csrf

                @foreach ($quiz->questions as $index => $q)
                    <div class="question-card">
                        <div class="q-number">Question {{ $index + 1 }} of {{ $quiz->questions->count() }}</div>
                        <div class="q-text">{{ $q->question_text }}</div>

                        <div class="options-list">
                            <label class="option-label">
                                <input type="radio" name="answers[{{ $q->id }}]" value="a" required>
                                <span><strong>A.</strong> {{ $q->option_a }}</span>
                            </label>
                            <label class="option-label">
                                <input type="radio" name="answers[{{ $q->id }}]" value="b">
                                <span><strong>B.</strong> {{ $q->option_b }}</span>
                            </label>
                            <label class="option-label">
                                <input type="radio" name="answers[{{ $q->id }}]" value="c">
                                <span><strong>C.</strong> {{ $q->option_c }}</span>
                            </label>
                            <label class="option-label">
                                <input type="radio" name="answers[{{ $q->id }}]" value="d">
                                <span><strong>D.</strong> {{ $q->option_d }}</span>
                            </label>
                        </div>
                    </div>
                @endforeach

                <button type="submit" class="btn-submit">Submit Quiz Answers &rarr;</button>
            </form>
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
