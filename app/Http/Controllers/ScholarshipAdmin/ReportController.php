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
        $ownScholarshipId = optional(\Illuminate\Support\Facades\Auth::user())->scholarship_id;
        $scoped = function ($query) use ($ownScholarshipId) {
            if (!is_null($ownScholarshipId)) {
                $query->where('scholarship_id', $ownScholarshipId);
            }
        };

        $summary = [
            'totalStudents' => User::where('role', 'student')->count(),
            'totalApplications' => Application::where($scoped)->count(),
            'approved' => Application::where($scoped)->where('status', 'Approved')->count(),
            'rejected' => Application::where($scoped)->where('status', 'Rejected')->count(),
            'underReview' => Application::where($scoped)->whereIn('status', ['Pending', 'Under Review'])->count(),
        ];

        $scholarships = Scholarship::query();
        if (!is_null($ownScholarshipId)) {
            $scholarships->where('id', $ownScholarshipId);
        }

        $scholarshipBreakdown = $scholarships->withCount([
            'applications',
            'applications as approved_count' => function ($query) {
                $query->where('status', 'Approved');
            },
        ])->latest()->get();

        return view('scholarshipadmin.reports', compact('summary', 'scholarshipBreakdown'));
    }
}
