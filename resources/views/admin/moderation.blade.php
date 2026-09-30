@extends('admin.layout')

@section('title', 'Content Moderation')
@section('page_title', 'Content Moderation & Safety Center')

@section('styles')
<style>
    .mod-tabs {
        display: flex;
        gap: 8px;
        border-bottom: 2px solid var(--border-color);
        margin-bottom: 24px;
    }

    .mod-tab {
        padding: 10px 18px;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        color: var(--text-secondary);
        border-bottom: 3px solid transparent;
        margin-bottom: -2px;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.15s;
    }

    .mod-tab:hover {
        color: var(--text-primary);
    }

    .mod-tab.active {
        color: var(--highlight);
        border-bottom-color: var(--highlight);
    }

    .tab-badge {
        background: var(--border-color);
        padding: 2px 7px;
        border-radius: 999px;
        font-size: 11px;
    }

    .mod-tab.active .tab-badge {
        background: var(--badge-bg);
        color: var(--badge-text);
    }
</style>
@endsection

@section('content')
    <div class="card">
        <!-- Moderation Tabs -->
        <div class="mod-tabs">
            <a href="{{ route('admin.moderation', ['tab' => 'messages']) }}" class="mod-tab {{ $tab === 'messages' ? 'active' : '' }}">
                <span>💬 Classroom Chat Messages</span>
                <span class="tab-badge">{{ $messages->total() }}</span>
            </a>
            <a href="{{ route('admin.moderation', ['tab' => 'materials']) }}" class="mod-tab {{ $tab === 'materials' ? 'active' : '' }}">
                <span>📚 Uploaded Study Materials</span>
                <span class="tab-badge">{{ $materials->total() }}</span>
            </a>
            <a href="{{ route('admin.moderation', ['tab' => 'announcements']) }}" class="mod-tab {{ $tab === 'announcements' ? 'active' : '' }}">
                <span>📢 Teacher Announcements</span>
                <span class="tab-badge">{{ $announcements->total() }}</span>
            </a>
        </div>

        <!-- TAB 1: Classroom Messages -->
        @if ($tab === 'messages')
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Sender</th>
                            <th>Classroom</th>
                            <th>Message Content</th>
                            <th>Sent At</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($messages->isEmpty())
                            <tr>
                                <td colspan="5" style="text-align: center; color: var(--text-secondary); padding: 30px;">
                                    No classroom discussion messages to moderate.
                                </td>
                            </tr>
                        @else
                            @foreach ($messages as $msg)
                                <tr>
                                    <td>
                                        <strong>{{ $msg->user->name }}</strong>
                                        <div style="font-size: 11px; color: var(--text-secondary);">
                                            <span class="badge badge-{{ $msg->user->role }}">{{ $msg->user->role }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>{{ $msg->classroom->name }}</strong>
                                        <div style="font-size: 11px; color: var(--text-secondary);">{{ $msg->classroom->code }}</div>
                                    </td>
                                    <td>
                                        <div style="max-width: 480px; font-size: 13px; color: var(--text-primary); line-height: 1.4; word-break: break-word;">
                                            {{ $msg->message }}
                                        </div>
                                    </td>
                                    <td style="font-size: 12px; color: var(--text-secondary); white-space: nowrap;">
                                        {{ $msg->created_at->diffForHumans() }}
                                    </td>
                                    <td style="text-align: right;">
                                        <form action="{{ route('admin.moderation.messages.delete', $msg) }}" method="POST" onsubmit="return confirm('Delete this message?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-action-danger" title="Remove message">
                                                Delete &times;
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 20px; display: flex; justify-content: center;">
                {{ $messages->links() }}
            </div>

        <!-- TAB 2: Uploaded Study Materials -->
        @elseif ($tab === 'materials')
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Document Title</th>
                            <th>Classroom & Instructor</th>
                            <th>File Info</th>
                            <th>Uploaded</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($materials->isEmpty())
                            <tr>
                                <td colspan="5" style="text-align: center; color: var(--text-secondary); padding: 30px;">
                                    No study materials uploaded yet.
                                </td>
                            </tr>
                        @else
                            @foreach ($materials as $mat)
                                <tr>
                                    <td>
                                        <strong>{{ $mat->title }}</strong>
                                        @if($mat->description)
                                            <div style="font-size: 11px; color: var(--text-secondary); max-width: 250px;">{{ $mat->description }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $mat->classroom->name }}</strong>
                                        <div style="font-size: 11px; color: var(--text-secondary);">Instructor: {{ $mat->classroom->teacher->name }}</div>
                                    </td>
                                    <td>
                                        <span class="badge badge-student" style="text-transform: uppercase;">{{ $mat->file_type ?? 'File' }}</span>
                                        @if($mat->file_size)
                                            <span style="font-size: 11px; color: var(--text-secondary);">({{ round($mat->file_size / 1024, 1) }} KB)</span>
                                        @endif
                                    </td>
                                    <td style="font-size: 12px; color: var(--text-secondary);">
                                        {{ $mat->created_at->format('M d, Y') }}
                                    </td>
                                    <td style="text-align: right;">
                                        <div style="display: flex; justify-content: flex-end; gap: 6px; align-items: center;">
                                            @if($mat->file_path)
                                                <a href="{{ asset('storage/' . $mat->file_path) }}" download class="btn-action btn-action-outline" title="Download & Inspect file">
                                                    📥 Inspect
                                                </a>
                                            @endif
                                            <form action="{{ route('admin.moderation.materials.delete', $mat) }}" method="POST" onsubmit="return confirm('Delete this material permanently?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-action-danger" title="Remove material">
                                                    Delete &times;
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 20px; display: flex; justify-content: center;">
                {{ $materials->links() }}
            </div>

        <!-- TAB 3: Teacher Announcements -->
        @elseif ($tab === 'announcements')
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Announcement</th>
                            <th>Classroom</th>
                            <th>Instructor</th>
                            <th>Posted</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($announcements->isEmpty())
                            <tr>
                                <td colspan="5" style="text-align: center; color: var(--text-secondary); padding: 30px;">
                                    No announcements found.
                                </td>
                            </tr>
                        @else
                            @foreach ($announcements as $ann)
                                <tr>
                                    <td>
                                        <div style="font-weight: 700; color: var(--text-primary);">
                                            @if($ann->is_pinned)
                                                <span style="background: #e0e7ff; color: #4338ca; font-size: 10px; font-weight: 700; padding: 2px 6px; border-radius: 4px; margin-right: 4px;">PINNED</span>
                                            @endif
                                            {{ $ann->title }}
                                        </div>
                                        <div style="font-size: 12px; color: var(--text-secondary); line-height: 1.4; margin-top: 4px; max-width: 450px;">
                                            {{ $ann->content }}
                                        </div>
                                    </td>
                                    <td>
                                        <strong>{{ $ann->classroom->name }}</strong>
                                    </td>
                                    <td>
                                        <span>{{ $ann->teacher->name }}</span>
                                    </td>
                                    <td style="font-size: 12px; color: var(--text-secondary); white-space: nowrap;">
                                        {{ $ann->created_at->diffForHumans() }}
                                    </td>
                                    <td style="text-align: right;">
                                        <form action="{{ route('admin.moderation.announcements.delete', $ann) }}" method="POST" onsubmit="return confirm('Delete this announcement?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-action-danger" title="Remove announcement">
                                                Delete &times;
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 20px; display: flex; justify-content: center;">
                {{ $announcements->links() }}
            </div>
        @endif
    </div>
@endsection
