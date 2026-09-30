<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direct Messages - Classroom Hub</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/js/app.js'])
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
            --chat-mine: #4f46e5;
            --chat-theirs: #f1f5f9;
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
            --chat-mine: #6366f1;
            --chat-theirs: #1f2937;
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
            display: flex;
            flex-direction: column;
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
            gap: 10px;
            font-size: 17px;
            font-weight: 800;
            color: var(--highlight);
            text-decoration: none;
        }

        .brand-badge {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #fff;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .nav-link {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.15s;
        }

        .nav-link:hover {
            color: var(--text-primary);
            background: var(--card-subtle);
        }

        .badge-counter {
            background: #ef4444;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 999px;
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

        /* Chat App Layout */
        .chat-app {
            flex: 1;
            max-width: 1180px;
            width: 100%;
            margin: 20px auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 340px 1fr;
            gap: 20px;
            height: calc(100vh - 100px);
        }

        /* Sidebar Contacts */
        .sidebar {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.02);
        }

        .sidebar-header {
            padding: 18px 20px;
            border-bottom: 1px solid var(--border-color);
            font-size: 16px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .contacts-list {
            flex: 1;
            overflow-y: auto;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            text-decoration: none;
            color: var(--text-primary);
            border-bottom: 1px solid var(--border-color);
            transition: all 0.15s;
        }

        .contact-item:hover {
            background: var(--card-subtle);
        }

        .contact-item.active {
            background: var(--accent-glow);
            border-left: 4px solid var(--highlight);
        }

        .avatar {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 16px;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.25);
        }

        .contact-details h4 {
            font-size: 14.5px;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .contact-details p {
            font-size: 12px;
            color: var(--text-secondary);
            text-transform: capitalize;
        }

        /* Chat Pane */
        .chat-pane {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.02);
        }

        .chat-header {
            padding: 16px 22px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 14px;
            background: var(--card-bg);
        }

        .chat-header h3 {
            font-size: 16px;
            font-weight: 800;
        }

        .chat-messages {
            flex: 1;
            padding: 22px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 14px;
            background: var(--bg-color);
        }

        .bubble {
            max-width: 72%;
            padding: 12px 18px;
            border-radius: 16px;
            font-size: 14px;
            line-height: 1.5;
            word-break: break-word;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
        }

        .bubble.mine {
            align-self: flex-end;
            background: var(--chat-mine);
            color: #ffffff;
            border-bottom-right-radius: 4px;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .bubble.theirs {
            align-self: flex-start;
            background: var(--card-bg);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
            border-bottom-left-radius: 4px;
        }

        .bubble-time {
            font-size: 10.5px;
            margin-top: 4px;
            opacity: 0.8;
            text-align: right;
        }

        .chat-input-bar {
            padding: 16px 20px;
            border-top: 1px solid var(--border-color);
            display: flex;
            gap: 12px;
            background: var(--card-bg);
        }

        .chat-input-bar input {
            flex: 1;
            padding: 12px 16px;
            background: var(--input-bg);
            color: var(--text-primary);
            border: 1.5px solid var(--input-border);
            border-radius: 10px;
            font-size: 14px;
            outline: none;
            transition: all 0.2s;
        }

        .chat-input-bar input:focus {
            border-color: var(--highlight);
            box-shadow: 0 0 0 3px var(--accent-glow);
        }

        .btn-send {
            background: var(--highlight);
            color: #ffffff;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.15s;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.25);
        }

        .btn-send:hover {
            background: var(--highlight-hover);
            transform: translateY(-1px);
        }

        .empty-pane {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            padding: 40px;
            text-align: center;
        }

        .empty-pane .icon {
            font-size: 48px;
            margin-bottom: 12px;
        }

        @media (max-width: 800px) {
            .chat-app {
                grid-template-columns: 1fr;
                height: auto;
            }
            .sidebar {
                max-height: 280px;
            }
            .chat-pane {
                height: 500px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('dashboard') }}" class="nav-brand">
            <span class="brand-badge">🎓</span>
            <span>Classroom Hub</span>
        </a>
        <div class="nav-links">
            <button type="button" onclick="toggleTheme()" class="btn-theme-toggle" title="Toggle Light/Dark Theme">
                <span id="theme-icon">🌙</span>
            </button>
            <a href="{{ route('notifications.index') }}" class="nav-link" style="position: relative;">
                <span>🔔</span>
                <span>Alerts</span>
                @php $unreadCount = Auth::user()->unreadNotifications()->count(); @endphp
                @if ($unreadCount > 0)
                    <span class="badge-counter">{{ $unreadCount }}</span>
                @endif
            </a>
            <a href="{{ route('dashboard') }}" class="nav-link">
                <span>Dashboard</span>
            </a>
            <a href="{{ route('profile.show') }}" class="nav-link">
                <span>Profile</span>
            </a>
        </div>
    </nav>

    <div class="chat-app">
        <!-- Sidebar Contacts -->
        <div class="sidebar">
            <div class="sidebar-header">
                <span>💬</span>
                <span>Direct Conversations</span>
            </div>
            <div class="contacts-list">
                @if ($contacts->isEmpty())
                    <p style="padding: 28px 20px; font-size: 13.5px; color: var(--text-secondary); text-align: center; line-height: 1.5;">
                        No conversations yet. Join a classroom or connect with teachers to start messaging.
                    </p>
                @else
                    @foreach ($contacts as $contact)
                        <a href="{{ route('messages.index', ['user_id' => $contact->id]) }}" class="contact-item {{ $selectedUser && $selectedUser->id === $contact->id ? 'active' : '' }}">
                            <div class="avatar">{{ substr($contact->name, 0, 1) }}</div>
                            <div class="contact-details">
                                <h4>{{ $contact->name }}</h4>
                                <p>{{ $contact->role }} &bull; {{ $contact->email }}</p>
                            </div>
                        </a>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Chat History & Input -->
        <div class="chat-pane">
            @if ($selectedUser)
                <div class="chat-header">
                    <div class="avatar">{{ substr($selectedUser->name, 0, 1) }}</div>
                    <div>
                        <h3>{{ $selectedUser->name }}</h3>
                        <p style="font-size: 12px; color: var(--text-secondary); text-transform: capitalize;">
                            {{ $selectedUser->role }} &bull; {{ $selectedUser->email }}
                        </p>
                    </div>
                </div>

                <div class="chat-messages" id="messagesBox">
                    @if ($messages->isEmpty())
                        <div class="empty-pane">
                            <span class="icon">👋</span>
                            <p style="font-size: 16px; font-weight: 700; color: var(--text-primary); margin-bottom: 4px;">Say hello to {{ $selectedUser->name }}!</p>
                            <p style="font-size: 13.5px;">Type a message below to start your private 1-on-1 discussion.</p>
                        </div>
                    @else
                        @foreach ($messages as $msg)
                            <div class="bubble {{ $msg->sender_id === Auth::id() ? 'mine' : 'theirs' }}">
                                <div>{{ $msg->message }}</div>
                                <div class="bubble-time">{{ $msg->created_at->format('h:i A') }}</div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <form action="{{ route('messages.store') }}" method="POST" class="chat-input-bar">
                    @csrf
                    <input type="hidden" name="receiver_id" value="{{ $selectedUser->id }}">
                    <input type="text" name="message" placeholder="Type a message to {{ $selectedUser->name }}..." required autofocus autocomplete="off">
                    <button type="submit" class="btn-send">Send &rarr;</button>
                </form>
            @else
                <div class="empty-pane">
                    <span class="icon">💬</span>
                    <p style="font-size: 17px; font-weight: 700; color: var(--text-primary); margin-bottom: 4px;">Select a conversation</p>
                    <p style="font-size: 14px; max-width: 320px;">Choose a contact from the left sidebar to read messages or start chatting.</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Scroll messages box to bottom automatically
        const box = document.getElementById('messagesBox');
        if (box) {
            box.scrollTop = box.scrollHeight;
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function appendMessageBubble(text, time, type) {
            const container = document.getElementById('messagesBox');
            if (!container) return;
            const emptyPane = container.querySelector('.empty-pane');
            if (emptyPane) emptyPane.remove();

            const bubble = document.createElement('div');
            bubble.className = `bubble ${type}`;
            bubble.innerHTML = `<div>${escapeHtml(text)}</div><div class="bubble-time">${time}</div>`;
            container.appendChild(bubble);
            container.scrollTop = container.scrollHeight;
        }

        // AJAX Message Form Submission (Optimistic UI, No Page Reload)
        const chatForm = document.querySelector('.chat-input-bar');
        if (chatForm) {
            chatForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                const input = chatForm.querySelector('input[name="message"]');
                const text = input.value.trim();
                if (!text) return;

                const nowTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                appendMessageBubble(text, nowTime, 'mine');
                input.value = '';
                input.focus();

                const receiverId = chatForm.querySelector('input[name="receiver_id"]').value;
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

                try {
                    const response = await fetch(chatForm.action, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            receiver_id: receiverId,
                            message: text
                        })
                    });

                    if (!response.ok) {
                        console.error('Message failed to send');
                    }
                } catch (err) {
                    console.error('Network error sending message', err);
                }
            });
        }

        // Listen for Real-Time Incoming DMs via Laravel Echo & Reverb
        document.addEventListener('DOMContentLoaded', function() {
            @if (Auth::check())
                const currentUserId = {{ Auth::id() }};
                const activeChatUserId = {{ $selectedUser ? $selectedUser->id : 'null' }};

                if (window.Echo) {
                    window.Echo.private(`user.${currentUserId}`)
                        .listen('.DirectMessageSent', function(e) {
                            if (activeChatUserId && e.message.sender_id === activeChatUserId) {
                                appendMessageBubble(e.message.message, e.message.created_at, 'theirs');
                            } else {
                                // Increment badge or update contact preview
                                const contactRow = document.querySelector(`a[href*="user_id=${e.message.sender_id}"]`);
                                if (contactRow) {
                                    contactRow.style.fontWeight = 'bold';
                                }
                            }
                        });
                }
            @endif
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

