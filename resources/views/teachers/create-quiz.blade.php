<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Assessment - {{ $classroom->name }}</title>
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
            --card-subtle: #f8fafc;
            --border-color: #e2e8f0;
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --input-bg: #ffffff;
            --input-border: #cbd5e1;
            --highlight: #4f46e5;
            --highlight-hover: #4338ca;
            --accent-glow: rgba(79, 70, 229, 0.12);
            --danger: #ef4444;
            --success: #10b981;
        }

        [data-theme="dark"] {
            --bg-color: #0b0f19;
            --card-bg: #111827;
            --card-subtle: #0f172a;
            --border-color: #1f2937;
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --input-bg: #0b0f19;
            --input-border: #374151;
            --highlight: #6366f1;
            --highlight-hover: #4f46e5;
            --accent-glow: rgba(99, 102, 241, 0.18);
            --danger: #f87171;
            --success: #34d399;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            transition: background-color 0.2s, color 0.2s, border-color 0.2s;
        }

        h1, h2, h3, h4 {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-primary);
            min-height: 100vh;
            padding-bottom: 80px;
        }

        .navbar {
            background: var(--card-bg);
            border-bottom: 1px solid var(--border-color);
            padding: 14px 32px;
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
            padding: 7px 14px;
            border-radius: 9999px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .container {
            max-width: 920px;
            margin: 32px auto;
            padding: 0 20px;
        }

        .card {
            background: var(--card-bg);
            border-radius: 20px;
            border: 1px solid var(--border-color);
            padding: 36px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.04);
            margin-bottom: 24px;
        }

        .header {
            margin-bottom: 28px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 20px;
        }

        .header h1 {
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        .header p {
            color: var(--text-secondary);
            font-size: 14.5px;
        }

        .form-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .form-grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
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

        .form-group input, .form-group textarea, .form-group select {
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

        .form-group input:focus, .form-group textarea:focus, .form-group select:focus {
            border-color: var(--highlight);
            box-shadow: 0 0 0 3px var(--accent-glow);
        }

        .question-block {
            background: var(--card-subtle);
            border: 1.5px solid var(--border-color);
            border-radius: 16px;
            padding: 26px;
            margin-bottom: 24px;
            position: relative;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            transition: border-color 0.2s;
        }

        .question-block:hover {
            border-color: rgba(99, 102, 241, 0.4);
        }

        .question-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 1px dashed var(--border-color);
        }

        .question-badge {
            font-size: 14px;
            font-weight: 800;
            color: var(--highlight);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .question-controls {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .btn-remove-q {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
            border: 1px solid rgba(239, 68, 68, 0.2);
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.15s;
        }

        .btn-remove-q:hover {
            background: var(--danger);
            color: #ffffff;
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
            padding: 8px 12px;
            border: 1px solid var(--input-border);
            border-radius: 8px;
            font-size: 13.5px;
            background: var(--input-bg);
            color: var(--text-primary);
            outline: none;
        }

        /* Match Pair UI */
        .match-pairs-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 12px;
        }

        .match-pair-row {
            display: grid;
            grid-template-columns: 1fr 30px 1fr 40px;
            align-items: center;
            gap: 10px;
            background: var(--card-bg);
            padding: 10px 14px;
            border-radius: 10px;
            border: 1px solid var(--border-color);
        }

        .btn-add-pair {
            background: none;
            border: 1.5px dashed var(--highlight);
            color: var(--highlight);
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 8px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-add-pair:hover {
            background: var(--accent-glow);
        }

        .btn-del-pair {
            background: none;
            border: none;
            color: var(--danger);
            font-size: 18px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-add-q {
            background: var(--accent-glow);
            color: var(--highlight);
            border: 2px dashed var(--highlight);
            padding: 16px;
            border-radius: 14px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            width: 100%;
            margin-bottom: 28px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-add-q:hover {
            background: var(--highlight);
            color: #ffffff;
            transform: translateY(-1px);
        }

        .btn-submit {
            background: var(--highlight);
            color: #ffffff;
            border: none;
            padding: 14px 34px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.15s;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
        }

        .btn-submit:hover {
            background: var(--highlight-hover);
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .form-grid-2, .form-grid-3, .options-grid {
                grid-template-columns: 1fr;
            }
            .match-pair-row {
                grid-template-columns: 1fr;
                gap: 8px;
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
        <button type="button" onclick="toggleTheme()" class="btn-theme-toggle" title="Toggle Light/Dark Theme">
            <span id="theme-icon">🌙 Mode</span>
        </button>
    </nav>

    <div class="container">
        <div class="card">
            <div class="header">
                <h1>Create Comprehensive Assessment</h1>
                <p>Configure question formats, per-question timers, passing mark, and guidelines for <strong>{{ $classroom->name }}</strong>.</p>
            </div>

            <form action="{{ route('teachers.quiz.store', $classroom) }}" method="POST" id="quizCreatorForm">
                @csrf
                <div class="form-group">
                    <label for="title">Assessment Title *</label>
                    <input type="text" id="title" name="title" placeholder="e.g. Midterm Examination & Chapter Mastery Quiz" required>
                </div>

                <div class="form-group">
                    <label for="description">Instructions / Student Overview</label>
                    <textarea id="description" name="description" rows="2" placeholder="Describe the topics covered, time expectations, calculator permissions, etc..."></textarea>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label for="pass_percentage">Passing Percentage (%) *</label>
                        <input type="number" id="pass_percentage" name="pass_percentage" value="70" min="1" max="100" required>
                    </div>
                    <div class="form-group">
                        <label for="duration_minutes">Total Quiz Time Limit (Optional, in Minutes)</label>
                        <input type="number" id="duration_minutes" name="duration_minutes" placeholder="e.g. 30 (Leave blank for per-question timers only)" min="1" max="360">
                    </div>
                </div>

                <div id="questions-container">
                    <!-- Dynamic Question Blocks will be rendered here -->
                </div>

                <button type="button" class="btn-add-q" id="btn-add-q">
                    <span style="font-size: 20px;">+</span>
                    <span>Add New Question to Quiz</span>
                </button>

                <div style="display: flex; justify-content: flex-end; align-items: center; gap: 16px; border-top: 1px solid var(--border-color); padding-top: 24px;">
                    <a href="{{ route('teachers.classroom', $classroom) }}" style="color: var(--text-secondary); text-decoration: none; font-weight: 600; font-size: 14px;">Cancel</a>
                    <button type="submit" class="btn-submit">Publish Assessment &rarr;</button>
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

        let questionIndex = 0;

        function renderQuestionBlock(index) {
            const block = document.createElement('div');
            block.className = 'question-block';
            block.id = `q-block-${index}`;
            block.dataset.index = index;

            block.innerHTML = `
                <div class="question-header">
                    <div class="question-badge">
                        <span>📝</span>
                        <span>Question #${index + 1}</span>
                    </div>
                    <div class="question-controls">
                        <button type="button" class="btn-remove-q" onclick="removeQuestion(${index})">Remove &times;</button>
                    </div>
                </div>

                <div class="form-grid-3">
                    <div class="form-group">
                        <label>Question Type *</label>
                        <select name="questions[${index}][type]" onchange="switchQuestionType(${index}, this.value)" style="font-weight: 700;">
                            <option value="choose">🔘 Multiple Choice (4 Options)</option>
                            <option value="true_false">⚖️ True / False</option>
                            <option value="complete">✍️ Complete / Fill in Blank</option>
                            <option value="scientific_term">🔬 Scientific Term / Concept</option>
                            <option value="match">🔗 Matching Pairs</option>
                            <option value="essay">📄 Essay / Free Response</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Question Timer (Seconds)</label>
                        <select name="questions[${index}][timer]">
                            <option value="">No Timer (Unlimited)</option>
                            <option value="15">15 Seconds (Rapid)</option>
                            <option value="30">30 Seconds</option>
                            <option value="45">45 Seconds</option>
                            <option value="60">60 Seconds (1 Min)</option>
                            <option value="90">90 Seconds (1.5 Min)</option>
                            <option value="120">120 Seconds (2 Min)</option>
                            <option value="180">180 Seconds (3 Min)</option>
                            <option value="300">300 Seconds (5 Min)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Points / Marks</label>
                        <input type="number" name="questions[${index}][points]" value="1" min="1" max="50">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 16px;">
                    <label>Question Prompt / Text *</label>
                    <textarea name="questions[${index}][text]" rows="2" placeholder="Type the question prompt here..." required></textarea>
                </div>

                <!-- Dynamic Content Container -->
                <div id="q-type-content-${index}">
                    ${renderChooseType(index)}
                </div>
            `;

            document.getElementById('questions-container').appendChild(block);
        }

        function renderChooseType(index) {
            return `
                <label style="font-size: 12px; font-weight: 700; color: var(--text-secondary); margin-bottom: 6px; display: block;">
                    Answer Choices (Select the radio button next to the correct answer):
                </label>
                <div class="options-grid">
                    <div class="option-item">
                        <input type="radio" name="questions[${index}][correct]" value="a" checked>
                        <input type="text" name="questions[${index}][option_a]" placeholder="Option A" required>
                    </div>
                    <div class="option-item">
                        <input type="radio" name="questions[${index}][correct]" value="b">
                        <input type="text" name="questions[${index}][option_b]" placeholder="Option B" required>
                    </div>
                    <div class="option-item">
                        <input type="radio" name="questions[${index}][correct]" value="c">
                        <input type="text" name="questions[${index}][option_c]" placeholder="Option C" required>
                    </div>
                    <div class="option-item">
                        <input type="radio" name="questions[${index}][correct]" value="d">
                        <input type="text" name="questions[${index}][option_d]" placeholder="Option D" required>
                    </div>
                </div>
            `;
        }

        function renderTrueFalseType(index) {
            return `
                <label style="font-size: 12px; font-weight: 700; color: var(--text-secondary); margin-bottom: 8px; display: block;">
                    Select the Correct Statement Truth Value:
                </label>
                <div style="display: flex; gap: 16px;">
                    <label class="option-item" style="flex: 1; cursor: pointer;">
                        <input type="radio" name="questions[${index}][correct]" value="true" checked>
                        <span style="font-weight: 700; color: var(--success); font-size: 15px;">True</span>
                    </label>
                    <label class="option-item" style="flex: 1; cursor: pointer;">
                        <input type="radio" name="questions[${index}][correct]" value="false">
                        <span style="font-weight: 700; color: var(--danger); font-size: 15px;">False</span>
                    </label>
                </div>
            `;
        }

        function renderCompleteType(index) {
            return `
                <div class="form-group" style="margin-bottom: 0;">
                    <label>Correct Missing Word or Phrase *</label>
                    <input type="text" name="questions[${index}][answer_text]" placeholder="e.g. Mitochondria, Photosynthesis, or exact answer phrase" required>
                    <p style="font-size: 11.5px; color: var(--text-secondary); margin-top: 6px;">
                        💡 Tip: Students must type this word to get full credit (evaluation is case-insensitive).
                    </p>
                </div>
            `;
        }

        function renderScientificTermType(index) {
            return `
                <div class="form-group" style="margin-bottom: 0;">
                    <label>Scientific Term / Concept to Identify *</label>
                    <input type="text" name="questions[${index}][answer_text]" placeholder="e.g. Gravity, Newton's Third Law, Endoplasmic Reticulum" required>
                    <p style="font-size: 11.5px; color: var(--text-secondary); margin-top: 6px;">
                        💡 The question prompt should define the scientific concept; the student types the expected scientific term.
                    </p>
                </div>
            `;
        }

        function renderMatchType(index) {
            return `
                <label style="font-size: 12px; font-weight: 700; color: var(--text-secondary); margin-bottom: 6px; display: block;">
                    Matching Pairs (Items in Column A will be matched against Column B):
                </label>
                <div class="match-pairs-container" id="match-pairs-${index}">
                    <div class="match-pair-row">
                        <input type="text" name="questions[${index}][match_left][]" placeholder="Column A (e.g. Paris)" required>
                        <span style="text-align: center; font-weight: 800; color: var(--text-secondary);">&rarr;</span>
                        <input type="text" name="questions[${index}][match_right][]" placeholder="Column B (e.g. France)" required>
                        <div></div>
                    </div>
                    <div class="match-pair-row">
                        <input type="text" name="questions[${index}][match_left][]" placeholder="Column A (e.g. Tokyo)" required>
                        <span style="text-align: center; font-weight: 800; color: var(--text-secondary);">&rarr;</span>
                        <input type="text" name="questions[${index}][match_right][]" placeholder="Column B (e.g. Japan)" required>
                        <button type="button" class="btn-del-pair" onclick="this.closest('.match-pair-row').remove()">&times;</button>
                    </div>
                </div>
                <button type="button" class="btn-add-pair" onclick="addMatchPair(${index})">
                    <span>+</span> Add Another Pair
                </button>
            `;
        }

        function renderEssayType(index) {
            return `
                <div class="form-group" style="margin-bottom: 0;">
                    <label>Grading Rubric / Model Answer (Optional guide for evaluation)</label>
                    <textarea name="questions[${index}][answer_text]" rows="2" placeholder="Key points, formula derivation, or argument requirements..."></textarea>
                    <p style="font-size: 11.5px; color: var(--text-secondary); margin-top: 6px;">
                        💡 Students will write a comprehensive response in an open text box.
                    </p>
                </div>
            `;
        }

        function switchQuestionType(index, type) {
            const container = document.getElementById(`q-type-content-${index}`);
            if (!container) return;

            if (type === 'choose') {
                container.innerHTML = renderChooseType(index);
            } else if (type === 'true_false') {
                container.innerHTML = renderTrueFalseType(index);
            } else if (type === 'complete') {
                container.innerHTML = renderCompleteType(index);
            } else if (type === 'scientific_term') {
                container.innerHTML = renderScientificTermType(index);
            } else if (type === 'match') {
                container.innerHTML = renderMatchType(index);
            } else if (type === 'essay') {
                container.innerHTML = renderEssayType(index);
            }
        }

        function addMatchPair(index) {
            const container = document.getElementById(`match-pairs-${index}`);
            if (!container) return;
            const row = document.createElement('div');
            row.className = 'match-pair-row';
            row.innerHTML = `
                <input type="text" name="questions[${index}][match_left][]" placeholder="Column A" required>
                <span style="text-align: center; font-weight: 800; color: var(--text-secondary);">&rarr;</span>
                <input type="text" name="questions[${index}][match_right][]" placeholder="Column B" required>
                <button type="button" class="btn-del-pair" onclick="this.closest('.match-pair-row').remove()">&times;</button>
            `;
            container.appendChild(row);
        }

        function removeQuestion(index) {
            const block = document.getElementById(`q-block-${index}`);
            if (block) {
                block.remove();
                renumberQuestions();
            }
        }

        function renumberQuestions() {
            const blocks = document.querySelectorAll('.question-block');
            blocks.forEach((blk, idx) => {
                const badge = blk.querySelector('.question-badge span:last-child');
                if (badge) {
                    badge.textContent = `Question #${idx + 1}`;
                }
            });
        }

        document.getElementById('btn-add-q').addEventListener('click', function() {
            questionIndex++;
            renderQuestionBlock(questionIndex);
        });

        // Initialize with 1 question
        renderQuestionBlock(questionIndex);
    </script>
</body>
</html>
