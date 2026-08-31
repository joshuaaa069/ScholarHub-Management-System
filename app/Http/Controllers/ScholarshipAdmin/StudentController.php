<?php

namespace App\Http\Controllers\ScholarshipAdmin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Directory of all registered students, flagged as an active Scholar
     * if they have at least one Approved application.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'student');

        // Scope: only show students who applied to this admin's scholarship.
        $ownScholarshipId = optional(\Illuminate\Support\Facades\Auth::user())->scholarship_id;
        if (!is_null($ownScholarshipId)) {
            $query->whereHas('applications', function ($q) use ($ownScholarshipId) {
                $q->where('scholarship_id', $ownScholarshipId);
            });
        }

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('email', 'like', "%{$term}%")
                  ->orWhere('student_number', 'like', "%{$term}%");
            });
        }

        $students = $query->latest()->paginate(15)->withQueryString();

        // Mark which of the listed students already have an Approved
        // application on this admin's scholarship.
        $scholarQuery = Application::where('status', 'Approved')
            ->whereIn('user_id', $students->pluck('id'));
        if (!is_null($ownScholarshipId)) {
            $scholarQuery->where('scholarship_id', $ownScholarshipId);
        }
        $scholarIds = $scholarQuery->pluck('user_id')->unique();

        return view('scholarshipadmin.students', compact('students', 'scholarIds'));
    }
}
