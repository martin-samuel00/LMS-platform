@extends('admin.layout')

@section('title', 'User Management')
@section('page_title', 'User & Account Management')

@section('styles')
<style>
    .filter-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .search-box {
        display: flex;
        align-items: center;
        background: var(--input-bg);
        border: 1.5px solid var(--input-border);
        border-radius: 8px;
        padding: 4px 8px;
        flex: 1;
        max-width: 380px;
    }

    .search-box input {
        border: none;
        outline: none;
        padding: 6px 8px;
        background: transparent;
        color: var(--text-primary);
        font-size: 13px;
        width: 100%;
    }

    .search-box button {
        background: var(--highlight);
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
    }

    .filter-pills {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .filter-pill {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        color: var(--text-secondary);
        border: 1px solid var(--border-color);
        background: var(--card-bg);
        transition: all 0.15s;
    }

    .filter-pill:hover, .filter-pill.active {
        color: var(--highlight);
        border-color: var(--highlight);
        background: rgba(99, 102, 241, 0.08);
    }

    .pagination-wrapper {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }
</style>
@endsection

@section('content')
    <div class="card">
        <!-- Filter and Search Bar -->
        <div class="filter-bar">
            <form action="{{ route('admin.users') }}" method="GET" class="search-box">
                @if(request('role')) <input type="hidden" name="role" value="{{ request('role') }}"> @endif
                @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by name, email, phone...">
                <button type="submit">Search</button>
            </form>

            <div class="filter-pills">
                <a href="{{ route('admin.users', array_merge(request()->except('role', 'page'), ['role' => 'all'])) }}" class="filter-pill {{ !request('role') || request('role') === 'all' ? 'active' : '' }}">All Roles</a>
                <a href="{{ route('admin.users', array_merge(request()->except('role', 'page'), ['role' => 'student'])) }}" class="filter-pill {{ request('role') === 'student' ? 'active' : '' }}">👨‍🎓 Students</a>
                <a href="{{ route('admin.users', array_merge(request()->except('role', 'page'), ['role' => 'teacher'])) }}" class="filter-pill {{ request('role') === 'teacher' ? 'active' : '' }}">👩‍🏫 Teachers</a>
                <a href="{{ route('admin.users', array_merge(request()->except('role', 'page'), ['role' => 'moderator'])) }}" class="filter-pill {{ request('role') === 'moderator' ? 'active' : '' }}">🛡️ Moderators</a>
                <a href="{{ route('admin.users', array_merge(request()->except('role', 'page'), ['role' => 'admin'])) }}" class="filter-pill {{ request('role') === 'admin' ? 'active' : '' }}">👑 Admins</a>
                <a href="{{ route('admin.users', array_merge(request()->except('status', 'page'), ['status' => 'banned'])) }}" class="filter-pill {{ request('status') === 'banned' ? 'active' : '' }}" style="color: #ef4444;">🚫 Suspended</a>
            </div>
        </div>

        <!-- Users Table -->
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>User Profile</th>
                        <th>Account Role</th>
                        <th>Verification</th>
                        <th>Status</th>
                        <th>Classes</th>
                        <th>Registered</th>
                        <th style="text-align: right;">Moderation Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($users->isEmpty())
                        <tr>
                            <td colspan="7" style="text-align: center; color: var(--text-secondary); padding: 30px;">
                                No users found matching your search and filter criteria.
                            </td>
                        </tr>
                    @else
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 34px; height: 34px; border-radius: 50%; background: var(--highlight); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 13px;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div style="font-weight: 700; font-size: 14px; color: var(--text-primary);">{{ $user->name }}</div>
                                            <div style="font-size: 12px; color: var(--text-secondary);">{{ $user->email }}</div>
                                            @if($user->phone)
                                                <div style="font-size: 11px; color: var(--text-secondary);">📞 {{ $user->phone }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <!-- Role Selector Form -->
                                    <form action="{{ route('admin.users.role', $user) }}" method="POST" style="display: flex; align-items: center; gap: 6px;">
                                        @csrf
                                        <select name="role" onchange="this.form.submit()" style="padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: 600; border: 1.5px solid var(--border-color); background: var(--input-bg); color: var(--text-primary); cursor: pointer;">
                                            <option value="student" {{ $user->role === 'student' ? 'selected' : '' }}>Student</option>
                                            <option value="teacher" {{ $user->role === 'teacher' ? 'selected' : '' }}>Teacher</option>
                                            <option value="moderator" {{ $user->role === 'moderator' ? 'selected' : '' }}>Moderator</option>
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    @if ($user->hasVerifiedEmail())
                                        <span class="badge badge-verified">&check; Verified</span>
                                    @else
                                        <div style="display: flex; align-items: center; gap: 6px;">
                                            <span class="badge badge-unverified">Unverified</span>
                                            <form action="{{ route('admin.users.verify', $user) }}" method="POST" style="margin: 0;">
                                                @csrf
                                                <button type="submit" class="btn-action btn-action-outline" style="padding: 2px 6px; font-size: 10px;" title="Manually verify email">
                                                    Verify &check;
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->is_banned)
                                        <span class="badge badge-banned" title="Reason: {{ $user->ban_reason }}">
                                            🚫 Suspended
                                        </span>
                                        @if($user->ban_reason)
                                            <div style="font-size: 10px; color: #b91c1c; max-width: 140px; margin-top: 2px;">{{ $user->ban_reason }}</div>
                                        @endif
                                    @else
                                        <span class="badge badge-verified">Active</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->isTeacher())
                                        <span style="font-size: 12px; font-weight: 600;">{{ $user->taught_classrooms_count }} Taught</span>
                                    @else
                                        <span style="font-size: 12px; font-weight: 600;">{{ $user->enrolled_classrooms_count }} Enrolled</span>
                                    @endif
                                </td>
                                <td style="font-size: 12px; color: var(--text-secondary);">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>
                                <td style="text-align: right;">
                                    <div style="display: flex; justify-content: flex-end; gap: 6px; align-items: center;">
                                        <!-- Ban / Unban Form -->
                                        @if ($user->id !== Auth::id())
                                            @if ($user->is_banned)
                                                <form action="{{ route('admin.users.ban', $user) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn-action btn-action-success" title="Reinstate account">
                                                        Lift Ban &check;
                                                    </button>
                                                </form>
                                            @else
                                                <button type="button" class="btn-action btn-action-warning" onclick="openBanModal({{ $user->id }}, '{{ addslashes($user->name) }}')">
                                                    Suspend 🚫
                                                </button>
                                            @endif

                                            <!-- Delete User -->
                                            <form action="{{ route('admin.users.delete', $user) }}" method="POST" onsubmit="return confirm('Permanently delete {{ addslashes($user->name) }} and all associated data? This action cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-action-danger" title="Delete user">
                                                    &times;
                                                </button>
                                            </form>
                                        @else
                                            <span style="font-size: 11px; color: var(--text-secondary); font-style: italic;">Your Account</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Suspend User Modal -->
    <div id="banModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 200; align-items: center; justify-content: center;">
        <div style="background: var(--card-bg); border-radius: 12px; border: 1.5px solid var(--border-color); max-width: 440px; width: 90%; padding: 24px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.3);">
            <h3 style="font-size: 16px; font-weight: 800; margin-bottom: 8px; color: #dc2626;">Suspend User Account</h3>
            <p id="banModalUserText" style="font-size: 13px; color: var(--text-secondary); margin-bottom: 16px;"></p>

            <form id="banForm" method="POST">
                @csrf
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 12px; font-weight: 700; margin-bottom: 6px;">Reason for Suspension:</label>
                    <input type="text" name="ban_reason" placeholder="e.g. Spamming inappropriate materials, abusive language" required style="width: 100%; padding: 10px; background: var(--input-bg); border: 1.5px solid var(--input-border); border-radius: 6px; font-size: 13px; color: var(--text-primary); outline: none;">
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 8px;">
                    <button type="button" class="btn-action btn-action-outline" onclick="closeBanModal()">Cancel</button>
                    <button type="submit" class="btn-action btn-action-danger">Confirm Suspension</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function openBanModal(userId, userName) {
        const modal = document.getElementById('banModal');
        const form = document.getElementById('banForm');
        const text = document.getElementById('banModalUserText');

        form.action = `/admin/users/${userId}/ban`;
        text.textContent = `Are you sure you want to suspend [${userName}]? They will be unable to log in until reinstated.`;
        modal.style.display = 'flex';
    }

    function closeBanModal() {
        document.getElementById('banModal').style.display = 'none';
    }
</script>
@endsection
