<?php

namespace App\Http\Controllers\ScholarshipAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; // Fixed: Imported the correct Laravel Auth Facade
use App\Models\Application;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;

class ScholarshipAdminController extends Controller
{
    /**
     * Display the admin dashboard with stats and review queue.
     */
    public function index()
    {
        // 1. Gather KPIs/Metrics
        $metrics = [
            'totalStudents' => User::where('role', 'student')->count(),
            'pending' => Application::whereIn('status', ['Pending', 'Under Review'])->count(),
            'recommended' => Application::where('status', 'Under Review')->count(), // Using 'Under Review' as the queue state
            'approvedScholars' => Application::where('status', 'Approved')->count(),
            'rejected' => Application::where('status', 'Rejected')->count(),
        ];

        // 2. Fetch applications with relations for the review table queue
        $applications = Application::with(['student', 'scholarship'])->get();

        // 3. Compute dynamic category statistics for chart distributions safely
        $totalApps = Application::count();
        $distribution = [];

        if ($totalApps > 0) {
            $categories = ['STEM', 'Merit', 'Need-Based', 'Government', 'Corporate'];

            foreach ($categories as $category) {
                $count = Application::whereHas('scholarship', function ($query) use ($category) {
                    $query->where('title', 'like', "%{$category}%");
                })->count();

                $distribution[$category] = round(($count / $totalApps) * 100);
            }
        } else {
            $distribution = ['STEM' => 0, 'Merit' => 0, 'Need-Based' => 0, 'Government' => 0, 'Corporate' => 0];
        }

        return view('scholarshipadmin.dashboard', compact('metrics', 'applications', 'distribution'));
    }

    /**
     * Process final application decisions (Approve/Reject).
     */
    public function action(Request $request, Application $application)
    {
        $request->validate([
            'action' => 'required|in:Approve,Reject'
        ]);

        $status = $request->action === 'Approve' ? 'Approved' : 'Rejected';

        $application->update([
            'status' => $status
        ]);

        AuditLog::record(
            "Application {$status}",
            "{$status} application #{$application->id} for " . ($application->student->name ?? 'a student')
        );

        return redirect()->back()->with('success', "Application status updated to {$status} successfully.");
    }

    /**
     * Handle Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landingpage'); // <-- Redirects to '/'
    }
}