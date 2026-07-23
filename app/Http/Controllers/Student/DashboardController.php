<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Application;
use App\Models\Scholarship;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Student dashboard — every figure here comes from the database.
     * No mock/sample data.
     */
    public function index()
    {
        $user = Auth::user();

        // Redirect Superadmins if they hit the common /dashboard route
        if ($user->role === 'superadmin') {
            return redirect()->route('superadmin.dashboard');
        }

        // Redirect Office/Scholarship Admin members if they hit the common /dashboard route
        if (in_array(strtolower($user->role), ['office', 'officer', 'admin', 'scholarship admin'])) {
            return redirect()->route('scholarshipadmin.dashboard');
        }

        // Student Stats & Views (real database queries, no mock data)
        $myApplications = Application::where('user_id', $user->id);

        $stats = [
            'available_scholarships' => Scholarship::where('status', 'Open')->count(),
            'available_scholarships_delta' => Scholarship::where('status', 'Open')
                ->where('created_at', '>=', now()->subMonth())
                ->count(),
            'submitted_applications' => (clone $myApplications)->count(),
            'submitted_applications_note' => (clone $myApplications)->whereDate('created_at', today())->exists()
                ? 'Updated today'
                : 'No updates today',
            'approved' => (clone $myApplications)->where('status', 'Approved')->count(),
            'approved_delta' => (clone $myApplications)->where('status', 'Approved')
                ->where('updated_at', '>=', now()->subMonth())
                ->count(),
            'pending_review' => (clone $myApplications)->whereIn('status', ['Pending', 'Under Review'])->count(),
        ];

        // Last 6 months of this student's application activity, for the bar chart
        $applicationHistory = collect(range(5, 0))->map(function ($monthsAgo) use ($user) {
            $month = now()->subMonths($monthsAgo);
            $count = Application::where('user_id', $user->id)
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            return [
                'month' => $month->format('M'),
                'count' => $count,
            ];
        })->all();

        // Only show the chart if the student has any application history at all
        $hasApplicationHistory = collect($applicationHistory)->sum('count') > 0;

        $announcements = Announcement::latest()->take(5)->get()->map(function ($a) {
            return [
                'title' => $a->title,
                'date' => $a->created_at,
                'tag' => 'Announcement',
            ];
        })->all();

        $upcomingDeadlines = Scholarship::where('status', 'Open')
            ->where('deadline', '>=', now())
            ->orderBy('deadline', 'asc')
            ->take(5)
            ->get()
            ->map(function ($s) {
                return [
                    'icon' => '🎓',
                    'name' => $s->title,
                    'date' => $s->deadline,
                ];
            })->all();

        return view('student.dashboard', compact(
            'user',
            'stats',
            'applicationHistory',
            'hasApplicationHistory',
            'announcements',
            'upcomingDeadlines'
        ));
    }
}
