<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Fetch user's notification timeline
        $notifications = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate unread count for UI badges
        $unreadCount = $notifications->where('is_read', false)->count();

        return view('student.notifications', compact('user', 'notifications', 'unreadCount'));
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())->update(['is_read' => true]);
        return back()->with('success', 'All notifications marked as read.');
    }

    public function markAsRead(Notification $notification)
    {
        // Ownership check: a student can only mark their own notifications read
        abort_unless($notification->user_id === auth()->id(), 403);

        $notification->update(['is_read' => true]);

        return back();
    }
}