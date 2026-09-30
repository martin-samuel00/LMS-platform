@extends('admin.layout')

@section('title', 'Admin Overview')
@section('page_title', 'Platform Management & Diagnostics')

@section('styles')
<style>
    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 28px;
    }

    .metric-card {
        background: var(--card-bg);
        border: 1.5px solid var(--border-color);
        border-radius: 12px;
        padding: 20px;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
    }

    .metric-icon-bg {
        position: absolute;
        right: 14px;
        top: 14px;
        font-size: 28px;
        opacity: 0.15;
    }

    .metric-number {
        font-size: 32px;
        font-weight: 800;
        color: var(--text-primary);
        line-height: 1.1;
        margin-bottom: 4px;
    }

    .metric-label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .metric-subtext {
        font-size: 12px;
        color: var(--highlight);
        margin-top: 6px;
        font-weight: 500;
    }

    .two-col-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        margin-bottom: 28px;
    }

    .form-group {
        margin-bottom: 14px;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 6px;
    }

    .form-control {
        width: 100%;
        padding: 10px 14px;
        background: var(--input-bg);
        color: var(--text-primary);
        border: 1.5px solid var(--input-border);
        border-radius: 8px;
        font-size: 13px;
        outline: none;
        transition: border-color 0.2s;
    }

    .form-control:focus {
        border-color: var(--highlight);
    }

    .diagnostics-list {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .diagnostics-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 10px;
        border-bottom: 1px solid var(--border-color);
        font-size: 13px;
    }

    .diagnostics-label {
        color: var(--text-secondary);
        font-weight: 500;
    }

    .diagnostics-val {
        font-weight: 700;
        color: var(--text-primary);
    }

    @media (max-width: 1100px) {
        .metrics-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .two-col-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
    <!-- Metric Cards -->
    <div class="metrics-grid">
        <div class="metric-card">
            <span class="metric-icon-bg">👥</span>
            <div class="metric-number">{{ $stats['total_users'] }}</div>
            <div class="metric-label">Registered Accounts</div>
            <div class="metric-subtext">{{ $stats['total_students'] }} Students &bull; {{ $stats['total_teachers'] }} Teachers</div>
        </div>

        <div class="metric-card">
            <span class="metric-icon-bg">🏫</span>
            <div class="metric-number">{{ $stats['total_classrooms'] }}</div>
            <div class="metric-label">Active Classrooms</div>
            <div class="metric-subtext">Across all subjects & teachers</div>
        </div>

        <div class="metric-card">
            <span class="metric-icon-bg">📌</span>
            <div class="metric-number">{{ $stats['total_assignments'] }}</div>
            <div class="metric-label">Assignments & Tasks</div>
            <div class="metric-subtext">{{ $stats['total_submissions'] }} Student Deliverables</div>
        </div>

        <div class="metric-card">
            <span class="metric-icon-bg">🏅</span>
            <div class="metric-number">{{ $stats['total_certificates'] }}</div>
            <div class="metric-label">Issued Certificates</div>
            <div class="metric-subtext">{{ $stats['total_quizzes'] }} Quizzes & Exams</div>
        </div>
    </div>

    <!-- Secondary Metrics Strip -->
    <div style="display: flex; gap: 12px; margin-bottom: 24px; flex-wrap: wrap;">
        <span class="badge badge-verified" style="font-size: 12px; padding: 6px 12px;">
            &checkmark; {{ $stats['verified_users'] }} Verified Emails
        </span>
        <span class="badge badge-admin" style="font-size: 12px; padding: 6px 12px;">
            🛡️ {{ $stats['total_moderators'] }} Admins & Moderators
        </span>
        <span class="badge {{ $stats['banned_users'] > 0 ? 'badge-banned' : 'badge-unverified' }}" style="font-size: 12px; padding: 6px 12px;">
            🚫 {{ $stats['banned_users'] }} Suspended Accounts
        </span>
        <span class="badge badge-student" style="font-size: 12px; padding: 6px 12px;">
            📚 {{ $stats['total_materials'] }} Study Materials / PDFs
        </span>
        <span class="badge badge-teacher" style="font-size: 12px; padding: 6px 12px;">
            💬 {{ $stats['total_messages'] + $stats['total_direct_messages'] }} Total Messages
        </span>
    </div>

    <!-- Action Section: System Broadcast & Platform Diagnostics -->
    <div class="two-col-grid">
        <!-- Site-Wide Broadcast -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">📢 Send Site-Wide System Announcement</h2>
            </div>
            <p style="font-size: 13px; color: var(--text-secondary); margin-bottom: 16px;">
                Broadcast an official notification alert directly to user notification centers across the platform.
            </p>

            <form action="{{ route('admin.broadcast') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="broadcast_target">Target Audience:</label>
                    <select id="broadcast_target" name="target" class="form-control" required>
                        <option value="all">Everyone (All Students & Teachers)</option>
                        <option value="students">Students Only</option>
                        <option value="teachers">Teachers Only</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="broadcast_title">Notice Title:</label>
                    <input type="text" id="broadcast_title" name="title" class="form-control" placeholder="e.g. Scheduled Maintenance, Academic Calendar Update" required>
                </div>

                <div class="form-group">
                    <label for="broadcast_message">Announcement Body:</label>
                    <textarea id="broadcast_message" name="message" rows="3" class="form-control" placeholder="Type the complete alert text for all users..." required></textarea>
                </div>

                <button type="submit" class="btn-action btn-action-primary" style="padding: 10px 20px;">
                    🚀 Dispatch Broadcast Notification
                </button>
            </form>
        </div>

        <!-- System Diagnostics -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">⚙️ System Diagnostics</h2>
            </div>
            <ul class="diagnostics-list">
                <li class="diagnostics-item">
                    <span class="diagnostics-label">PHP Version</span>
                    <span class="diagnostics-val">{{ $systemInfo['php_version'] }}</span>
                </li>
                <li class="diagnostics-item">
                    <span class="diagnostics-label">Laravel Framework</span>
                    <span class="diagnostics-val">v{{ $systemInfo['laravel_version'] }}</span>
                </li>
                <li class="diagnostics-item">
                    <span class="diagnostics-label">Environment</span>
                    <span class="diagnostics-val" style="text-transform: uppercase;">{{ $systemInfo['environment'] }}</span>
                </li>
                <li class="diagnostics-item">
                    <span class="diagnostics-label">Database Connection</span>
                    <span class="diagnostics-val" style="color: #10b981;">&check; {{ $systemInfo['db_connection'] }}</span>
                </li>
                <li class="diagnostics-item">
                    <span class="diagnostics-label">Storage Symlink</span>
                    <span class="diagnostics-val">
                        @if ($systemInfo['storage_linked'])
                            <span style="color: #10b981;">&check; Linked (`/public/storage`)</span>
                        @else
                            <span style="color: #ef4444;">&cross; Not linked</span>
                        @endif
                    </span>
                </li>
            </ul>

            <div style="margin-top: 20px; background: var(--subcard-bg); padding: 12px; border-radius: 8px; border: 1px solid var(--border-color); font-size: 12px; color: var(--text-secondary);">
                <strong>💡 Moderator Tip:</strong> To promote or demote any user, navigate to the <a href="{{ route('admin.users') }}" style="color: var(--highlight); font-weight: 700; text-decoration: none;">User Management</a> tab.
            </div>
        </div>
    </div>

    <!-- Recent Activity Split -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
        <!-- Recent Registrations -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">🆕 Recent User Registrations</h2>
                <a href="{{ route('admin.users') }}" style="font-size: 12px; color: var(--highlight); font-weight: 700; text-decoration: none;">View All &rarr;</a>
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentUsers as $user)
                            <tr>
                                <td>
                                    <strong>{{ $user->name }}</strong>
                                    <div style="font-size: 11px; color: var(--text-secondary);">{{ $user->email }}</div>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $user->role }}">{{ $user->role }}</span>
                                </td>
                                <td>
                                    @if ($user->is_banned)
                                        <span class="badge badge-banned">Banned</span>
                                    @elseif ($user->hasVerifiedEmail())
                                        <span class="badge badge-verified">Verified</span>
                                    @else
                                        <span class="badge badge-unverified">Unverified</span>
                                    @endif
                                </td>
                                <td style="font-size: 12px; color: var(--text-secondary);">
                                    {{ $user->created_at->diffForHumans() }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Classrooms -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">🏫 Newest Classrooms</h2>
                <a href="{{ route('admin.classrooms') }}" style="font-size: 12px; color: var(--highlight); font-weight: 700; text-decoration: none;">View All &rarr;</a>
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Classroom</th>
                            <th>Instructor</th>
                            <th>Code</th>
                            <th>Enrolled</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentClassrooms as $class)
                            <tr>
                                <td>
                                    <strong>{{ $class->name }}</strong>
                                    <div style="font-size: 11px; color: var(--text-secondary);">{{ $class->subject ?? 'General' }}</div>
                                </td>
                                <td>
                                    <span style="font-size: 12px;">{{ $class->teacher->name }}</span>
                                </td>
                                <td>
                                    <code style="background: var(--subcard-bg); padding: 2px 6px; border-radius: 4px; font-weight: 700; color: var(--highlight);">{{ $class->code }}</code>
                                </td>
                                <td>
                                    <span style="font-weight: 700; font-size: 12px;">{{ $class->students_count }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
