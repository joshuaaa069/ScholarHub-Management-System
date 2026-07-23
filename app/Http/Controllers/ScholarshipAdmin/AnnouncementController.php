<?php

namespace App\Http\Controllers\ScholarshipAdmin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnnouncementController extends Controller
{
    /**
     * List previously published announcements and show the create form.
     */
    public function index()
    {
        $announcements = Announcement::with('creator')->latest()->get();

        return view('scholarshipadmin.announcements', compact('announcements'));
    }

    /**
     * Publish a new announcement and fan it out as a Notification to every student.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);

        $announcement = Announcement::create([
            'title' => $validated['title'],
            'message' => $validated['message'],
            'created_by' => Auth::id(),
        ]);

        // Fan out to every student's Notifications inbox.
        $studentIds = User::where('role', 'student')->pluck('id');
        $now = now();

        $rows = $studentIds->map(function ($id) use ($announcement, $now) {
            return [
                'user_id' => $id,
                'type' => 'info',
                'title' => $announcement->title,
                'message' => $announcement->message,
                'is_read' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        })->all();

        if (! empty($rows)) {
            // Chunk to keep each insert reasonably sized.
            foreach (array_chunk($rows, 500) as $chunk) {
                DB::table('notifications')->insert($chunk);
            }
        }

        return redirect()->route('scholarshipadmin.announcements')
            ->with('success', 'Announcement "' . $announcement->title . '" published to ' . count($rows) . ' student(s).');
    }
}
