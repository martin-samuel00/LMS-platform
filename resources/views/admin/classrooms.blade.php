@extends('admin.layout')

@section('title', 'Classroom Management')
@section('page_title', 'All Virtual Classrooms')

@section('styles')
<style>
    .filter-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .search-box {
        display: flex;
        align-items: center;
        background: var(--input-bg);
        border: 1.5px solid var(--input-border);
        border-radius: 8px;
        padding: 4px 8px;
        max-width: 400px;
        width: 100%;
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
        padding: 6px 14px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
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
        <div class="filter-bar">
            <form action="{{ route('admin.classrooms') }}" method="GET" class="search-box">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by name, subject, code, teacher...">
                <button type="submit">Search</button>
            </form>
            <div style="font-size: 13px; color: var(--text-secondary);">
                Total Classrooms: <strong>{{ $classrooms->total() }}</strong>
            </div>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Classroom Details</th>
                        <th>Instructor / Teacher</th>
                        <th>Join Code</th>
                        <th>Students</th>
                        <th>Materials</th>
                        <th>Assignments</th>
                        <th>Discussions</th>
                        <th>Created</th>
                        <th style="text-align: right;">Moderation</th>
                    </tr>
                </thead>
                <tbody>
                    @if($classrooms->isEmpty())
                        <tr>
                            <td colspan="9" style="text-align: center; color: var(--text-secondary); padding: 30px;">
                                No classrooms found matching your search query.
                            </td>
                        </tr>
                    @else
                        @foreach ($classrooms as $classroom)
                            <tr>
                                <td>
                                    <strong>{{ $classroom->name }}</strong>
                                    <div style="font-size: 11px; color: var(--text-secondary);">{{ $classroom->subject ?? 'General' }}</div>
                                    @if($classroom->description)
                                        <div style="font-size: 11px; color: var(--text-secondary); max-width: 200px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                                            {{ $classroom->description }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $classroom->teacher->name }}</strong>
                                    <div style="font-size: 11px; color: var(--text-secondary);">{{ $classroom->teacher->email }}</div>
                                </td>
                                <td>
                                    <code style="background: var(--subcard-bg); padding: 3px 8px; border-radius: 6px; font-weight: 700; color: var(--highlight);">
                                        {{ $classroom->code }}
                                    </code>
                                </td>
                                <td>
                                    <span style="font-weight: 700; font-size: 13px;">{{ $classroom->students_count }}</span>
                                </td>
                                <td>
                                    <span style="font-size: 12px; color: var(--text-secondary);">{{ $classroom->materials_count }} files</span>
                                </td>
                                <td>
                                    <span style="font-size: 12px; color: var(--text-secondary);">{{ $classroom->assignments_count }} tasks</span>
                                </td>
                                <td>
                                    <span style="font-size: 12px; color: var(--text-secondary);">{{ $classroom->messages_count }} msgs</span>
                                </td>
                                <td style="font-size: 12px; color: var(--text-secondary);">
                                    {{ $classroom->created_at->format('M d, Y') }}
                                </td>
                                <td style="text-align: right;">
                                    <div style="display: flex; justify-content: flex-end; gap: 6px; align-items: center;">
                                        <!-- Enter Classroom Preview -->
                                        <a href="{{ route('teachers.classroom', $classroom) }}" target="_blank" class="btn-action btn-action-outline" title="Inspect Classroom">
                                            View &nearr;
                                        </a>

                                        <!-- Delete Classroom -->
                                        <form action="{{ route('admin.classrooms.delete', $classroom) }}" method="POST" onsubmit="return confirm('Permanently delete classroom \'{{ addslashes($classroom->name) }}\' and all its assignments, quizzes, materials, and messages? This cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-action-danger" title="Delete classroom">
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

        <div class="pagination-wrapper">
            {{ $classrooms->links() }}
        </div>
    </div>
@endsection
