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

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('email', 'like', "%{$term}%")
                  ->orWhere('student_number', 'like', "%{$term}%");
            });
        }

        $students = $query->latest()->paginate(15)->withQueryString();

        // Mark which of the listed students already have an Approved application
        $scholarIds = Application::where('status', 'Approved')
            ->whereIn('user_id', $students->pluck('id'))
            ->pluck('user_id')
            ->unique();

        return view('scholarshipadmin.students', compact('students', 'scholarIds'));
    }
}
