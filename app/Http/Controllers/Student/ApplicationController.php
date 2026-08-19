<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApplicationController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $applications = Application::with(['scholarship', 'officer'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('student.applications', compact('user', 'applications'));
    }

    public function store(Request $request, Scholarship $scholarship)
    {
        $user = $request->user();

        if (!$scholarship->status || $scholarship->status !== 'Open') {
            return redirect()->back()->with('error', 'This scholarship is no longer open for applications.');
        }

        $alreadyApplied = Application::where('user_id', $user->id)
            ->where('scholarship_id', $scholarship->id)
            ->exists();

        if ($alreadyApplied) {
            return redirect()->route('student.applications')->with('error', 'You have already applied to this scholarship.');
        }

        $application = Application::create([
            'application_code' => 'APP-' . strtoupper(Str::random(8)),
            'user_id' => $user->id,
            'scholarship_id' => $scholarship->id,
            'status' => 'Pending',
        ]);

        if ($scholarship->slots_left > 0) {
            $scholarship->decrement('slots_left');
        }

        return redirect()->route('student.applications')->with('success', 'Application submitted successfully for ' . $scholarship->title . '.');
    }
}