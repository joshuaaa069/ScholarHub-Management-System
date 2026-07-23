<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    /**
     * READ: list academic years and show the create form.
     */
    public function index()
    {
        $academicYears = AcademicYear::orderByDesc('start_date')->get();

        return view('superadmin.academic-years', compact('academicYears'));
    }

    /**
     * CREATE: store a newly created Academic Year.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'year_label' => ['required', 'string', 'max:255', 'unique:academic_years,year_label'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'status' => ['required', 'in:Upcoming,Active,Archived'],
        ]);

        $academicYear = AcademicYear::create($validated);

        AuditLog::record('Created Academic Year', $academicYear->year_label);

        return redirect()->route('superadmin.academic-years')
            ->with('success', 'Academic Year "' . $academicYear->year_label . '" was added.');
    }

    /**
     * UPDATE: edit an existing Academic Year's details.
     */
    public function update(Request $request, AcademicYear $academicYear)
    {
        $validated = $request->validate([
            'year_label' => ['required', 'string', 'max:255', 'unique:academic_years,year_label,' . $academicYear->id],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'status' => ['required', 'in:Upcoming,Active,Archived'],
        ]);

        $academicYear->update($validated);

        AuditLog::record('Updated Academic Year', $academicYear->year_label);

        return redirect()->route('superadmin.academic-years')
            ->with('success', 'Academic Year "' . $academicYear->year_label . '" was updated.');
    }

    /**
     * DELETE: remove an Academic Year record.
     */
    public function destroy(AcademicYear $academicYear)
    {
        $label = $academicYear->year_label;
        $academicYear->delete();

        AuditLog::record('Deleted Academic Year', $label);

        return redirect()->route('superadmin.academic-years')
            ->with('success', "\"{$label}\" was deleted.");
    }

    /**
     * Mark one Academic Year as the current one (unsets all others).
     */
    public function setCurrent(AcademicYear $academicYear)
    {
        AcademicYear::where('is_current', true)->update(['is_current' => false]);

        $academicYear->update([
            'is_current' => true,
            'status' => 'Active',
        ]);

        AuditLog::record('Set Current Academic Year', $academicYear->year_label);

        return redirect()->route('superadmin.academic-years')
            ->with('success', $academicYear->year_label . ' is now the current academic year.');
    }
}
