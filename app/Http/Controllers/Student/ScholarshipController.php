<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use Illuminate\Http\Request;

class ScholarshipController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // 1. Start querying real database records
        $query = Scholarship::query();

        // 2. Real-time Search Logic
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('provider', 'LIKE', "%{$searchTerm}%");
            });
        }

        // 3. Tab Categorization Filter Logic
        if ($request->has('type') && $request->type !== 'All') {
            $query->where('type', $request->type);
        }

        $scholarships = $query->orderBy('deadline', 'asc')->get();

        return view('student.programs', compact('user', 'scholarships'));
    }
}