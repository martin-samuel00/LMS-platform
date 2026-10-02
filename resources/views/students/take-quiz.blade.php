<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $quiz->title }} - Taking Assessment</title>
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
            --option-bg: #ffffff;
            --option-border: #cbd5e1;
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
            --option-bg: #111827;
            --option-border: #374151;
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
            background: var(--bg-color);
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
            padding: 6px 14px;
            border-radius: 9999px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .container {
            max-width: 860px;
            margin: 28px auto;
            padding: 0 20px;
        }

        /* Sticky Quiz Bar */
        .quiz-sticky-bar {
            position: sticky;
            top: 65px;
            z-index: 40;
            background: var(--card-bg);
            border: 1.5px solid var(--border-color);
            border-radius: 16px;
            padding: 12px 20px;
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.06);
            backdrop-filter: blur(10px);
        }

        .quiz-timer-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 16px;
            font-weight: 800;
            background: var(--accent-glow);
            color: var(--highlight);
            padding: 6px 14px;
            border-radius: 10px;
            font-variant-numeric: tabular-nums;
        }

        .quiz-timer-badge.timer-warning {
            background: rgba(239, 68, 68, 0.15);
            color: var(--danger);
            animation: pulse-danger 1s infinite alternate;
        }

        @keyframes pulse-danger {
            from { transform: scale(1); }
            to { transform: scale(1.04); }
        }

        .quiz-progress-track {
            flex: 1;
            height: 8px;
            background: var(--card-subtle);
            border-radius: 999px;
            overflow: hidden;
            border: 1px solid var(--border-color);
        }

        .quiz-progress-fill {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, var(--highlight), #7c3aed);
            border-radius: 999px;
            transition: width 0.3s ease;
        }

        .quiz-questions-nav {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .quiz-nav-dot {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            background: var(--card-subtle);
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11.5px;
            font-weight: 700;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.15s;
        }

        .quiz-nav-dot.answered {
            background: var(--highlight);
            color: #ffffff;
            border-color: var(--highlight);
        }

        .quiz-nav-dot:hover {
            border-color: var(--highlight);
        }

        .card {
            background: var(--card-bg);
            border-radius: 20px;
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
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        .meta-pills {
            display: flex;
            gap: 10px;
            margin-top: 10px;
            flex-wrap: wrap;
        }

        .meta-pill {
            background: var(--card-subtle);
            padding: 5px 12px;
            border-radius: 999px;
            font-size: 12.5px;
            font-weight: 700;
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }

        /* Question Cards */
        .question-card {
            background: var(--card-subtle);
            border: 1.5px solid var(--border-color);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .question-card:hover {
            border-color: rgba(99, 102, 241, 0.4);
        }

        .q-header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .q-type-badge {
            font-size: 11.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            background: var(--accent-glow);
            color: var(--highlight);
            padding: 3px 10px;
            border-radius: 999px;
        }

        .q-timer-badge {
            font-size: 12px;
            font-weight: 800;
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
            border: 1px solid rgba(239, 68, 68, 0.2);
            padding: 3px 10px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .q-points-badge {
            font-size: 11.5px;
            font-weight: 700;
            color: var(--text-secondary);
        }

        .q-text {
            font-size: 16.5px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 18px;
            line-height: 1.55;
        }

        /* Option items for choose */
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
            padding: 13px 18px;
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

        /* True/False Buttons */
        .tf-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .tf-card {
            background: var(--option-bg);
            border: 2px solid var(--option-border);
            border-radius: 12px;
            padding: 16px;
            text-align: center;
            font-size: 16px;
            font-weight: 800;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.15s;
        }

        .tf-card:hover {
            border-color: var(--highlight);
            background: var(--accent-glow);
        }

        .tf-card input[type="radio"] {
            display: none;
        }

        .tf-card.selected-true {
            border-color: var(--success);
            background: rgba(16, 185, 129, 0.12);
            color: var(--success);
        }

        .tf-card.selected-false {
            border-color: var(--danger);
            background: rgba(239, 68, 68, 0.12);
            color: var(--danger);
        }

        /* Text Input for Complete / Scientific Term */
        .quiz-text-input {
            width: 100%;
            padding: 14px 18px;
            border: 1.5px solid var(--option-border);
            border-radius: 12px;
            background: var(--option-bg);
            color: var(--text-primary);
            font-size: 15px;
            font-weight: 600;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .quiz-text-input:focus {
            border-color: var(--highlight);
            box-shadow: 0 0 0 3px var(--accent-glow);
        }

        /* Match Question Grid */
        .match-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .match-row-item {
            display: grid;
            grid-template-columns: 1fr 30px 1.2fr;
            align-items: center;
            gap: 12px;
            background: var(--option-bg);
            padding: 12px 16px;
            border-radius: 12px;
            border: 1.5px solid var(--option-border);
        }

        .match-row-item select {
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid var(--option-border);
            background: var(--card-subtle);
            color: var(--text-primary);
            font-size: 14px;
            font-weight: 600;
            outline: none;
        }

        .match-row-item select:focus {
            border-color: var(--highlight);
        }

        /* Essay Textarea */
        .essay-textarea {
            width: 100%;
            padding: 16px;
            border: 1.5px solid var(--option-border);
            border-radius: 12px;
            background: var(--option-bg);
            color: var(--text-primary);
            font-size: 14.5px;
            outline: none;
            resize: vertical;
            line-height: 1.5;
            transition: border-color 0.2s;
        }

        .essay-textarea:focus {
            border-color: var(--highlight);
            box-shadow: 0 0 0 3px var(--accent-glow);
        }

        .btn-submit {
            background: var(--highlight);
            color: #ffffff;
            border: none;
            padding: 16px 28px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 800;
            cursor: pointer;
            width: 100%;
            transition: all 0.2s;
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.35);
        }

        .btn-submit:hover {
            background: var(--highlight-hover);
            transform: translateY(-2px);
        }

        .question-locked {
            opacity: 0.65;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('students.classroom', $classroom) }}" class="nav-brand">
            <span>&larr;</span>
            <span>Back to {{ $classroom->name }}</span>
        </a>
        <button type="button" onclick="toggleTheme()" class="btn-theme-toggle" title="Toggle Light/Dark Theme">
            <span id="theme-icon">🌙 Mode</span>
        </button>
    </nav>

    <div class="container">
        <!-- Floating Live Quiz Timer & Question Navigator -->
        <div class="quiz-sticky-bar">
            <div class="quiz-timer-badge" id="quizTimerBadge">
                <span>⏱️</span>
                <span id="quizTimerText">15:00</span>
            </div>
            <div class="quiz-progress-track" title="Assessment Progress">
                <div class="quiz-progress-fill" id="quizProgressFill"></div>
            </div>
            <div class="quiz-questions-nav">
                @foreach ($quiz->questions as $index => $q)
                    <a href="#question-{{ $q->id }}" class="quiz-nav-dot" id="nav-dot-{{ $q->id }}" title="Go to Question {{ $index + 1 }}">{{ $index + 1 }}</a>
                @endforeach
            </div>
        </div>

        <div class="card">
            <div class="quiz-header">
                <h1>{{ $quiz->title }}</h1>
                <div class="meta-pills">
                    <span class="meta-pill">Pass Score: {{ $quiz->pass_percentage }}%</span>
                    <span class="meta-pill">Total Questions: {{ $quiz->questions->count() }}</span>
                    <span class="meta-pill" id="answeredCountBadge">0 / {{ $quiz->questions->count() }} Answered</span>
                </div>
                @if ($quiz->description)
                    <p style="margin-top: 12px; color: var(--text-secondary); line-height: 1.5;">{{ $quiz->description }}</p>
                @endif
            </div>

            <form id="quizForm" action="{{ route('students.quiz.submit', $quiz) }}" method="POST">
                @csrf

                @foreach ($quiz->questions as $index => $q)
                    @php
                        $type = $q->question_type ?? 'choose';
                    @endphp
                    <div class="question-card" id="question-{{ $q->id }}" data-qid="{{ $q->id }}" data-timer="{{ $q->time_limit_seconds }}">
                        <div class="q-header-row">
                            <span class="q-type-badge">
                                @if($type === 'choose') 🔘 Multiple Choice
                                @elseif($type === 'true_false') ⚖️ True or False
                                @elseif($type === 'complete') ✍️ Complete the Sentence
                                @elseif($type === 'scientific_term') 🔬 Scientific Concept
                                @elseif($type === 'match') 🔗 Matching Pairs
                                @elseif($type === 'essay') 📄 Essay Question
                                @else 📝 Question {{ $index + 1 }}
                                @endif
                            </span>

                            <div style="display: flex; gap: 8px; align-items: center;">
                                @if ($q->time_limit_seconds)
                                    <div class="q-timer-badge" id="q-timer-badge-{{ $q->id }}">
                                        <span>⏱️</span>
                                        <span id="q-timer-text-{{ $q->id }}">{{ $q->time_limit_seconds }}s</span>
                                    </div>
                                @endif
                                <span class="q-points-badge">{{ $q->points ?: 1 }} Pt</span>
                            </div>
                        </div>

                        <div class="q-text">{{ $q->question_text }}</div>

                        <!-- Choose Question -->
                        @if ($type === 'choose')
                            <div class="options-list">
                                <label class="option-label">
                                    <input type="radio" name="answers[{{ $q->id }}]" value="a" onchange="markAnswered({{ $q->id }})">
                                    <span><strong>A.</strong> {{ $q->option_a }}</span>
                                </label>
                                <label class="option-label">
                                    <input type="radio" name="answers[{{ $q->id }}]" value="b" onchange="markAnswered({{ $q->id }})">
                                    <span><strong>B.</strong> {{ $q->option_b }}</span>
                                </label>
                                <label class="option-label">
                                    <input type="radio" name="answers[{{ $q->id }}]" value="c" onchange="markAnswered({{ $q->id }})">
                                    <span><strong>C.</strong> {{ $q->option_c }}</span>
                                </label>
                                <label class="option-label">
                                    <input type="radio" name="answers[{{ $q->id }}]" value="d" onchange="markAnswered({{ $q->id }})">
                                    <span><strong>D.</strong> {{ $q->option_d }}</span>
                                </label>
                            </div>

                        <!-- True or False Question -->
                        @elseif ($type === 'true_false')
                            <div class="tf-grid">
                                <label class="tf-card" id="tf-true-{{ $q->id }}" onclick="selectTF({{ $q->id }}, 'a')">
                                    <input type="radio" name="answers[{{ $q->id }}]" value="a" id="input-tf-a-{{ $q->id }}">
                                    <span>✅ TRUE</span>
                                </label>
                                <label class="tf-card" id="tf-false-{{ $q->id }}" onclick="selectTF({{ $q->id }}, 'b')">
                                    <input type="radio" name="answers[{{ $q->id }}]" value="b" id="input-tf-b-{{ $q->id }}">
                                    <span>❌ FALSE</span>
                                </label>
                            </div>

                        <!-- Complete the Sentence / Fill in the blank -->
                        @elseif ($type === 'complete')
                            <div>
                                <input type="text" name="answers[{{ $q->id }}]" class="quiz-text-input" placeholder="Type your answer here..." oninput="markAnswered({{ $q->id }})">
                            </div>

                        <!-- Scientific Term -->
                        @elseif ($type === 'scientific_term')
                            <div>
                                <input type="text" name="answers[{{ $q->id }}]" class="quiz-text-input" placeholder="Enter scientific term / concept..." oninput="markAnswered({{ $q->id }})">
                            </div>

                        <!-- Match Question -->
                        @elseif ($type === 'match')
                            @php
                                $pairs = is_array($q->matching_pairs) ? $q->matching_pairs : json_decode($q->matching_pairs, true) ?? [];
                                $rightOptions = collect($pairs)->pluck('right')->shuffle();
                            @endphp
                            <div class="match-list">
                                @foreach ($pairs as $pIdx => $pair)
                                    <div class="match-row-item">
                                        <div style="font-weight: 700; font-size: 14.5px;">{{ $pair['left'] }}</div>
                                        <div style="text-align: center; color: var(--text-secondary);">&rarr;</div>
                                        <select name="answers[{{ $q->id }}][{{ $pIdx }}]" onchange="markAnswered({{ $q->id }})">
                                            <option value="">-- Select Matching Item --</option>
                                            @foreach ($rightOptions as $opt)
                                                <option value="{{ $opt }}">{{ $opt }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endforeach
                            </div>

                        <!-- Essay Question -->
                        @elseif ($type === 'essay')
                            <div>
                                <textarea name="answers[{{ $q->id }}]" rows="5" class="essay-textarea" placeholder="Write your full written answer here..." oninput="markAnswered({{ $q->id }})"></textarea>
                            </div>
                        @endif
                    </div>
                @endforeach

                <button type="submit" class="btn-submit">Submit Quiz Answers &rarr;</button>
            </form>
        </div>
    </div>

    <script>
        const totalQuestions = {{ $quiz->questions->count() }};
        const answeredMap = {};

        function markAnswered(qId) {
            answeredMap[qId] = true;
            const dot = document.getElementById('nav-dot-' + qId);
            if (dot) dot.classList.add('answered');

            const answeredCount = Object.keys(answeredMap).length;
            const percent = totalQuestions > 0 ? (answeredCount / totalQuestions) * 100 : 0;
            const fill = document.getElementById('quizProgressFill');
            if (fill) fill.style.width = percent + '%';

            const badge = document.getElementById('answeredCountBadge');
            if (badge) badge.textContent = `${answeredCount} / ${totalQuestions} Answered`;
        }

        function selectTF(qId, val) {
            const trueCard = document.getElementById('tf-true-' + qId);
            const falseCard = document.getElementById('tf-false-' + qId);
            const inputA = document.getElementById('input-tf-a-' + qId);
            const inputB = document.getElementById('input-tf-b-' + qId);

            if (val === 'a') {
                inputA.checked = true;
                trueCard.classList.add('selected-true');
                falseCard.classList.remove('selected-false');
            } else {
                inputB.checked = true;
                falseCard.classList.add('selected-false');
                trueCard.classList.remove('selected-true');
            }
            markAnswered(qId);
        }

        // --- Overall Countdown Timer ---
        @if ($quiz->duration_minutes)
            let secondsLeft = {{ $quiz->duration_minutes * 60 }};
        @else
            let secondsLeft = Math.max(300, totalQuestions * 120);
        @endif

        const timerText = document.getElementById('quizTimerText');
        const timerBadge = document.getElementById('quizTimerBadge');
        const quizForm = document.getElementById('quizForm');
        let autoSubmitted = false;

        function updateOverallTimer() {
            if (secondsLeft <= 0) {
                if (!autoSubmitted) {
                    autoSubmitted = true;
                    if (window.HubToast) {
                        window.HubToast.warning('Assessment time is up! Submitting answers automatically...', 'Time Expired');
                    }
                    setTimeout(() => quizForm.submit(), 1200);
                }
                return;
            }

            secondsLeft--;
            const mins = Math.floor(secondsLeft / 60);
            const secs = secondsLeft % 60;
            if (timerText) {
                timerText.textContent = `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
            }

            if (secondsLeft <= 60 && timerBadge && !timerBadge.classList.contains('timer-warning')) {
                timerBadge.classList.add('timer-warning');
            }
        }

        setInterval(updateOverallTimer, 1000);

        // --- Per-Question Timers ---
        const questionCards = document.querySelectorAll('.question-card[data-timer]');
        questionCards.forEach(card => {
            const qId = card.dataset.qid;
            const timerSecs = parseInt(card.dataset.timer, 10);
            if (!timerSecs || isNaN(timerSecs)) return;

            let remaining = timerSecs;
            const textEl = document.getElementById(`q-timer-text-${qId}`);

            const qInterval = setInterval(() => {
                remaining--;
                if (textEl) {
                    textEl.textContent = `${remaining}s`;
                }

                if (remaining <= 0) {
                    clearInterval(qInterval);
                    if (textEl) {
                        textEl.textContent = 'Expired';
                    }
                    card.classList.add('question-locked');
                    const badge = document.getElementById(`q-timer-badge-${qId}`);
                    if (badge) {
                        badge.style.background = 'rgba(239, 68, 68, 0.2)';
                        badge.style.color = '#ef4444';
                    }
                }
            }, 1000);
        });

        // Submit confirmation
        quizForm.addEventListener('submit', function(e) {
            const answeredCount = Object.keys(answeredMap).length;
            if (answeredCount < totalQuestions && !autoSubmitted) {
                const unanswered = totalQuestions - answeredCount;
                if (!confirm(`You still have ${unanswered} unanswered question(s). Are you sure you want to submit your assessment now?`)) {
                    e.preventDefault();
                }
            }
        });

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
