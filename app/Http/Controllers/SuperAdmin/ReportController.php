<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Scholarship;
use App\Models\User;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    /**
     * System-wide reports: totals across students, scholarship admins,
     * scholarship programs, and applications.
     */
    public function index()
    {
        $summary = [
            'totalStudents' => User::where('role', 'student')->count(),
            'totalScholarshipAdmins' => User::where('role', 'Scholarship Admin')->count(),
            'totalScholarships' => Scholarship::count(),
            'openScholarships' => Scholarship::where('status', 'Open')->count(),
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

        return view('superadmin.reports', compact('summary', 'scholarshipBreakdown'));
    }

    /**
     * Export the program performance table as a downloadable CSV.
     * (Reports are computed/read-only data, not an editable resource, so
     * "export" is the equivalent of a full CRUD action here.)
     */
    public function exportCsv(): StreamedResponse
    {
        $scholarships = Scholarship::withCount([
            'applications',
            'applications as approved_count' => function ($query) {
                $query->where('status', 'Approved');
            },
        ])->latest()->get();

        $filename = 'scholarship-report-' . now()->format('Y-m-d') . '.csv';

        $callback = function () use ($scholarships) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Program', 'Applications', 'Approved', 'Slots Total', 'Slots Filled']);

            foreach ($scholarships as $s) {
                fputcsv($handle, [
                    $s->title,
                    $s->applications_count,
                    $s->approved_count,
                    $s->slots_total,
                    $s->slots_total - $s->slots_left,
                ]);
            }

            fclose($handle);
        };

        return response()->streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
