<?php

namespace App\Http\Controllers\ScholarshipAdmin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    /**
     * Full application list, with simple search/filter.
     * Includes all post-registrar statuses (endorsed, approved, rejected) so the
     * scholarship admin can also review history.
     */
    public function index(Request $request)
    {
        $query = Application::with(['student', 'scholarship']);

        // Scope: a scholarship admin only sees applications tied to the
        // scholarship they own. Super-admins (no scholarship_id) see all.
        $ownScholarshipId = optional(Auth::user())->scholarship_id;
        if (!is_null($ownScholarshipId)) {
            $query->where('scholarship_id', $ownScholarshipId);
        }

        if ($request->filled('status') && $request->status !== 'All') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $term = $request->search;
            $query->whereHas('student', function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('email', 'like', "%{$term}%");
            });
        }

        $applications = $query->latest()->paginate(15)->withQueryString();

        return view('scholarshipadmin.applications', compact('applications'));
    }
}
