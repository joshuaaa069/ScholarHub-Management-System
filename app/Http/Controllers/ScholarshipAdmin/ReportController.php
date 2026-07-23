<?php

namespace App\Http\Controllers\ScholarshipAdmin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Scholarship;
use App\Models\User;

class ReportController extends Controller
{
    /**
     * Simple aggregate reports: totals by status and per-scholarship fill rate.
     */
    public function index()
    {
        $summary = [
            'totalStudents' => User::where('role', 'student')->count(),
            'totalApplications' => Application::count(),
            'approved' => Application::where('status', 'Approved')->count(),
            'rejected' => Application::where('status', 'Rejected')->count(),
            'underReview' => Application::whereIn('status', ['Pending', 'Under Review'])->count(),
        ];

        $scholarshipBreakdown = Scholarship::withCount([
            'applications',
            'applications as approved_count' => function ($query) {
                $query->where('status', 'Approved');
            },
        ])->latest()->get();

        return view('scholarshipadmin.reports', compact('summary', 'scholarshipBreakdown'));
    }
}
