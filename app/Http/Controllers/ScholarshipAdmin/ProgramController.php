<?php

namespace App\Http\Controllers\ScholarshipAdmin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
{
    /**
     * List scholarship programs and show the Create Scholarship form.
     */
    public function index()
    {
        $scholarships = Scholarship::withCount('applications')->latest()->get();

        return view('scholarshipadmin.programs', compact('scholarships'));
    }

    /**
     * Store a newly created Scholarship program.
     *
     * Required fields: Scholarship Name, Description, Benefits, Eligibility,
     * Requirements, Deadline, Available Slots, and Status (Open/Closed).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'benefits' => ['required', 'string', 'max:255'],
            'eligibility' => ['required', 'string'],
            'requirements' => ['required', 'string'],
            'deadline' => ['required', 'date', 'after_or_equal:today'],
            'slots_total' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'in:Open,Closed'],
            'type' => ['nullable', 'string', 'max:255'],
        ]);

        Scholarship::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'provider' => Auth::user()->scholarship_name ?? 'CKC ScholarHub Office',
            'type' => $validated['type'] ?? 'General',
            'benefits' => $validated['benefits'],
            'eligibility' => $validated['eligibility'],
            'requirements' => $validated['requirements'],
            'slots_total' => $validated['slots_total'],
            'slots_left' => $validated['slots_total'],
            'min_gpa' => 0,
            'deadline' => $validated['deadline'],
            'status' => $validated['status'],
            'created_by' => Auth::id(),
        ]);

        AuditLog::record(
            'Created Scholarship Program',
            $validated['title'] . ' (' . $validated['slots_total'] . ' slots, deadline ' . $validated['deadline'] . ')'
        );

        return redirect()->route('scholarshipadmin.programs')
            ->with('success', 'Scholarship program "' . $validated['title'] . '" was published successfully!');
    }
}
