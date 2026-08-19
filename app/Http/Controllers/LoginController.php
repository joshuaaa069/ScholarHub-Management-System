<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validate the form request
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'role' => ['required', 'in:student,office'], // Only student or office can log in here
        ]);

        $remember = $request->boolean('remember');

        // 2. Attempt authentication
        if (Auth::attempt($request->only('email', 'password'), $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // RULE 1: STRICTLY BLOCK SCHOOL REGISTRARS
            // If the user logging in has a registrar role, immediately kick them out!
            if (in_array(strtolower($user->role), ['superadmin', 'school_registrar', 'registrar', 'admin_super'])) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Access denied. School Registrars must log in through the secure registrar portal.',
                ])->onlyInput('email');
            }

            // RULE 2: ENFORCE STUDENT ROLE SELECTOR
            if ($request->role === 'student') {
                if ($user->role !== 'student') {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return back()->withErrors([
                        'email' => 'This account does not have student privileges.',
                    ])->onlyInput('email');
                }

                // Force redirect to student dashboard
                return redirect()->route('student.dashboard');
            }

            // RULE 3: ENFORCE SCHOLARSHIP OFFICE ROLE SELECTOR
            if ($request->role === 'office') {
                // Adjust strings to match the exact role names in your database (e.g., 'officer', 'office_admin')
                $allowedOfficeRoles = ['office', 'officer', 'scholarship_admin'];

                if (!in_array($user->role, $allowedOfficeRoles)) {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return back()->withErrors([
                        'email' => 'This account does not have office administrator privileges.',
                    ])->onlyInput('email');
                }

                // Force redirect to office dashboard
                return redirect()->route('scholarshipadmin.dashboard');
            }
        }

        // Incorrect email/password fallback
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}