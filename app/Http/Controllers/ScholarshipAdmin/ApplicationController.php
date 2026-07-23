<?php

namespace App\Http\Controllers\ScholarshipAdmin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Full application list, with simple search/filter (separate from the
     * short review queue shown on the dashboard).
     */
    public function index(Request $request)
    {
        $query = Application::with(['student', 'scholarship']);

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
