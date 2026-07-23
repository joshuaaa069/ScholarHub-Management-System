<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScholarshipController extends Controller
{
    /**
     * READ: system-wide list of every scholarship program, across all
     * Scholarship Admins, with optional search/status filter.
     */
    public function index(Request $request)
    {
        $query = Scholarship::withCount('applications')->with('creator');

        if ($request->filled('status') && $request->status !== 'All') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('provider', 'like', "%{$term}%");
            });
        }

        $scholarships = $query->latest()->paginate(12)->withQueryString();

        return view('superadmin.scholarships', compact('scholarships'));
    }

    /**
     * CREATE: store a brand-new scholarship program from the Super Admin panel.
     */
    public function store(Request $request)
    {
        $validated = $this->validated($request);

        $scholarship = Scholarship::create([
            ...$validated,
            'slots_left' => $validated['slots_total'],
            'min_gpa' => $validated['min_gpa'] ?? 0,
            'created_by' => Auth::id(),
        ]);

        AuditLog::record('Created Scholarship', $scholarship->title . ' (via Super Admin)');

        return redirect()->route('superadmin.scholarships')
            ->with('success', 'Scholarship "' . $scholarship->title . '" was created.');
    }

    /**
     * UPDATE: edit an existing scholarship program's details.
     */
    public function update(Request $request, Scholarship $scholarship)
    {
        $validated = $this->validated($request, $scholarship->id);

        // Keep slots_left consistent if the admin raises/lowers slots_total
        $filled = $scholarship->slots_total - $scholarship->slots_left;
        $newSlotsLeft = max(0, $validated['slots_total'] - $filled);

        $scholarship->update([
            ...$validated,
            'slots_left' => $newSlotsLeft,
        ]);

        AuditLog::record('Updated Scholarship', $scholarship->title);

        return redirect()->route('superadmin.scholarships')
            ->with('success', 'Scholarship "' . $scholarship->title . '" was updated.');
    }

    /**
     * DELETE: permanently remove a scholarship program.
     */
    public function destroy(Scholarship $scholarship)
    {
        $title = $scholarship->title;
        $scholarship->delete();

        AuditLog::record('Deleted Scholarship', $title);

        return redirect()->route('superadmin.scholarships')
            ->with('success', "\"{$title}\" was deleted.");
    }

    /**
     * Quickly Open/Close a scholarship program from the Super Admin panel.
     */
    public function toggleStatus(Scholarship $scholarship)
    {
        $scholarship->status = $scholarship->status === 'Open' ? 'Closed' : 'Open';
        $scholarship->save();

        AuditLog::record(
            'Toggled Scholarship Status',
            $scholarship->title . ' set to ' . $scholarship->status
        );

        return redirect()->back()->with('success', "\"{$scholarship->title}\" is now {$scholarship->status}.");
    }

    /**
     * Shared validation rules for store() and update().
     */
    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'provider' => ['required', 'string', 'max:255'],
            'type' => ['nullable', 'string', 'max:255'],
            'benefits' => ['required', 'string', 'max:255'],
            'eligibility' => ['required', 'string'],
            'requirements' => ['required', 'string'],
            'deadline' => ['required', 'date'],
            'slots_total' => ['required', 'integer', 'min:1'],
            'min_gpa' => ['nullable', 'numeric', 'between:1.00,5.00'],
            'status' => ['required', 'in:Open,Closed'],
        ]);
    }
}
