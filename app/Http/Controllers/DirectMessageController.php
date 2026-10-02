<?php

namespace App\Http\Controllers;

use App\Models\DirectMessage;
use App\Models\User;
use App\Models\Classroom;
use App\Models\AppNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DirectMessageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $selectedUserId = $request->query('user_id');
        $selectedUser = null;
        $messages = collect();

        // Find available contacts (peers or teachers/students connected through classrooms)
        if ($user->isTeacher()) {
            $classroomIds = $user->taughtClassrooms()->pluck('id');
            $contacts = User::whereHas('enrolledClassrooms', function ($q) use ($classroomIds) {
                $q->whereIn('classroom_id', $classroomIds);
            })->distinct()->get();
        } else {
            $classroomIds = $user->enrolledClassrooms()->pluck('classroom_id');
            $teacherIds = Classroom::whereIn('id', $classroomIds)->pluck('teacher_id')->unique();
            $contacts = User::whereIn('id', $teacherIds)->get();
        }

        // Also include anyone who has messaged the user even if not in current class
        $messagedUserIds = DirectMessage::where('sender_id', $user->id)
            ->pluck('receiver_id')
            ->merge(DirectMessage::where('receiver_id', $user->id)->pluck('sender_id'))
            ->unique();
        
        $moreContacts = User::whereIn('id', $messagedUserIds)->get();
        $contacts = $contacts->merge($moreContacts)->unique('id');

        if ($selectedUserId) {
            $selectedUser = User::find($selectedUserId);
            if ($selectedUser) {
                // Fetch conversation history
                $messages = DirectMessage::where(function ($q) use ($user, $selectedUser) {
                    $q->where('sender_id', $user->id)->where('receiver_id', $selectedUser->id);
                })->orWhere(function ($q) use ($user, $selectedUser) {
                    $q->where('sender_id', $selectedUser->id)->where('receiver_id', $user->id);
                })->oldest()->get();

                // Mark incoming messages as read
                DirectMessage::where('sender_id', $selectedUser->id)
                    ->where('receiver_id', $user->id)
                    ->where('is_read', false)
                    ->update(['is_read' => true]);
            }
        }

        return view('messages.index', compact('contacts', 'selectedUser', 'messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => ['required', 'exists:users,id'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $user = Auth::user();
        $receiver = User::findOrFail($request->receiver_id);

        $dm = DirectMessage::create([
            'sender_id' => $user->id,
            'receiver_id' => $receiver->id,
            'message' => $request->message,
            'is_read' => false,
        ]);

        try {
            broadcast(new \App\Events\DirectMessageSent($dm))->toOthers();
        } catch (\Throwable $e) {
            // Fail gracefully if websocket server is not started
        }

        // Dispatch notification to receiver
        AppNotification::send(
            $receiver->id,
            "💬 New message from {$user->name}",
            \Illuminate\Support\Str::limit($request->message, 80),
            route('messages.index', ['user_id' => $user->id]),
            'message'
        );

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => [
                    'id' => $dm->id,
                    'sender_id' => $dm->sender_id,
                    'receiver_id' => $dm->receiver_id,
                    'sender_name' => $user->name,
                    'message' => $dm->message,
                    'created_at' => $dm->created_at ? $dm->created_at->format('M d, g:i A') : now()->format('M d, g:i A'),
                ]
            ]);
        }

        return redirect()->route('messages.index', ['user_id' => $receiver->id])
            ->with('success', 'Message sent!');
    }

    // Poll new messages between current user and target user
    public function poll(Request $request, User $user)
    {
        $currentUser = Auth::user();
        $afterId = (int) $request->query('after', 0);

        $query = DirectMessage::where(function ($q) use ($currentUser, $user) {
            $q->where('sender_id', $currentUser->id)->where('receiver_id', $user->id);
        })->orWhere(function ($q) use ($currentUser, $user) {
            $q->where('sender_id', $user->id)->where('receiver_id', $currentUser->id);
        });

        if ($afterId > 0) {
            $query->where('id', '>', $afterId);
        }

        $newMessages = $query->orderBy('id', 'asc')->get();

        // Mark incoming messages as read
        DirectMessage::where('sender_id', $user->id)
            ->where('receiver_id', $currentUser->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'messages' => $newMessages->map(function ($dm) use ($currentUser) {
                return [
                    'id' => $dm->id,
                    'sender_id' => $dm->sender_id,
                    'is_mine' => $dm->sender_id === $currentUser->id,
                    'message' => $dm->message,
                    'created_at' => $dm->created_at ? $dm->created_at->format('M d, g:i A') : 'Just now',
                ];
            })
        ]);
    }
}
