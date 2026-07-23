<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Fetch user's personal applications including dynamic relationship data
        $applications = Application::with(['scholarship', 'officer'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('student.applications', compact('user', 'applications'));
    }
}