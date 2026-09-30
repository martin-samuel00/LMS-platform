<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Quiz - {{ $classroom->name }}</title>
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

        .nav-links {
            display: flex;
            align-items: center;
            gap: 14px;
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

        .card {
            background: var(--card-bg);
            border-radius: 18px;
            border: 1px solid var(--border-color);
            padding: 34px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.03);
            margin-bottom: 24px;
        }

        .header {
            margin-bottom: 26px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 18px;
        }

        .header h1 {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        .header p {
            color: var(--text-secondary);
            font-size: 14px;
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

        .form-group input, .form-group textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid var(--input-border);
            border-radius: 10px;
            font-size: 14px;
            outline: none;
            background: var(--input-bg);
            color: var(--text-primary);
            transition: all 0.2s;
        }

        .form-group input:focus, .form-group textarea:focus {
            border-color: var(--highlight);
            box-shadow: 0 0 0 3px var(--accent-glow);
        }

        .question-block {
            background: var(--card-subtle);
            border: 1.5px solid var(--border-color);
            border-radius: 14px;
            padding: 24px;
            margin-bottom: 20px;
            position: relative;
        }

        .question-title {
            font-size: 15px;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .options-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-top: 12px;
        }

        .option-item {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--card-bg);
            padding: 10px 14px;
            border-radius: 10px;
            border: 1.5px solid var(--border-color);
            transition: border-color 0.15s;
        }

        .option-item:focus-within {
            border-color: var(--highlight);
        }

        .option-item input[type="radio"] {
            width: 18px;
            height: 18px;
            accent-color: var(--highlight);
            cursor: pointer;
            flex-shrink: 0;
        }

        .option-item input[type="text"] {
            flex: 1;
            padding: 6px 10px;
            border: 1px solid var(--input-border);
            border-radius: 6px;
            font-size: 13.5px;
            background: var(--input-bg);
            color: var(--text-primary);
            outline: none;
        }

        .btn-add-q {
            background: var(--accent-glow);
            color: var(--highlight);
            border: 1.5px dashed var(--highlight);
            padding: 14px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            width: 100%;
            margin-bottom: 24px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-add-q:hover {
            background: var(--highlight);
            color: #ffffff;
        }

        .btn-submit {
            background: var(--highlight);
            color: #ffffff;
            border: none;
            padding: 12px 28px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.15s;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .btn-submit:hover {
            background: var(--highlight-hover);
            transform: translateY(-1px);
        }

        @media (max-width: 600px) {
            .options-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('teachers.classroom', $classroom) }}" class="nav-brand">
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
            <div class="header">
                <h1>Create New Quiz</h1>
                <p>Add assessment questions, options, and passing requirement for <strong>{{ $classroom->name }}</strong></p>
            </div>

            <form action="{{ route('teachers.quiz.store', $classroom) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="title">Quiz Title *</label>
                    <input type="text" id="title" name="title" placeholder="e.g. Chapter 3 Comprehensive Assessment" required>
                </div>

                <div class="form-group">
                    <label for="description">Quiz Instructions / Student Overview</label>
                    <textarea id="description" name="description" rows="2" placeholder="Describe the topics covered, time expectations, etc..."></textarea>
                </div>

                <div class="form-group">
                    <label for="pass_percentage">Passing Percentage (%) *</label>
                    <input type="number" id="pass_percentage" name="pass_percentage" value="70" min="1" max="100" required style="max-width: 140px;">
                </div>

                <div id="questions-container">
                    <!-- Question 1 Default -->
                    <div class="question-block" id="q-block-0">
                        <div class="question-title">
                            <span>Question #1</span>
                        </div>
                        <div class="form-group" style="margin-bottom: 12px;">
                            <label>Question Prompt *</label>
                            <input type="text" name="questions[0][text]" placeholder="Enter the question text here..." required>
                        </div>
                        <label style="font-size: 12px; font-weight: 700; color: var(--text-secondary);">
                            Answer Options (Select the radio button next to the correct answer) *
                        </label>
                        <div class="options-grid">
                            <div class="option-item">
                                <input type="radio" name="questions[0][correct]" value="a" required checked>
                                <input type="text" name="questions[0][option_a]" placeholder="Option A (Correct)" required>
                            </div>
                            <div class="option-item">
                                <input type="radio" name="questions[0][correct]" value="b" required>
                                <input type="text" name="questions[0][option_b]" placeholder="Option B" required>
                            </div>
                            <div class="option-item">
                                <input type="radio" name="questions[0][correct]" value="c" required>
                                <input type="text" name="questions[0][option_c]" placeholder="Option C" required>
                            </div>
                            <div class="option-item">
                                <input type="radio" name="questions[0][correct]" value="d" required>
                                <input type="text" name="questions[0][option_d]" placeholder="Option D" required>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn-add-q" id="btn-add-q">
                    <span>+</span>
                    <span>Add Another Question</span>
                </button>

                <div>
                    <button type="submit" class="btn-submit">Publish Quiz to Classroom &rarr;</button>
                </div>
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

        let questionCount = 1;
        document.getElementById('btn-add-q').addEventListener('click', function() {
            const index = questionCount;
            const block = document.createElement('div');
            block.className = 'question-block';
            block.id = 'q-block-' + index;
            block.innerHTML = `
                <div class="question-title">
                    <span>Question #${index + 1}</span>
                    <button type="button" onclick="document.getElementById('q-block-${index}').remove()" style="color: #ef4444; background: none; border: none; font-size: 13px; font-weight: 700; cursor: pointer;">Remove &times;</button>
                </div>
                <div class="form-group" style="margin-bottom: 12px;">
                    <label>Question Prompt *</label>
                    <input type="text" name="questions[${index}][text]" placeholder="Enter the question text here..." required>
                </div>
                <label style="font-size: 12px; font-weight: 700; color: var(--text-secondary);">
                    Answer Options (Select the radio button next to the correct answer) *
                </label>
                <div class="options-grid">
                    <div class="option-item">
                        <input type="radio" name="questions[${index}][correct]" value="a" required checked>
                        <input type="text" name="questions[${index}][option_a]" placeholder="Option A" required>
                    </div>
                    <div class="option-item">
                        <input type="radio" name="questions[${index}][correct]" value="b" required>
                        <input type="text" name="questions[${index}][option_b]" placeholder="Option B" required>
                    </div>
                    <div class="option-item">
                        <input type="radio" name="questions[${index}][correct]" value="c" required>
                        <input type="text" name="questions[${index}][option_c]" placeholder="Option C" required>
                    </div>
                    <div class="option-item">
                        <input type="radio" name="questions[${index}][correct]" value="d" required>
                        <input type="text" name="questions[${index}][option_d]" placeholder="Option D" required>
                    </div>
                </div>
            `;
            document.getElementById('questions-container').appendChild(block);
            questionCount++;
        });
    </script>
</body>
</html>
