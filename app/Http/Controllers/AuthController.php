<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // Handle Student and Office Login
    public function login(Request $request)
    {
        // Validate credentials and active role selector from request
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'role' => ['required', 'in:student,office'],
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($request->only('email', 'password'), $remember)) {
            $user = Auth::user();

            // RULE 1: STRICTLY BLOCK SCHOOL REGISTRARS FROM THIS GATEWAY
            if (in_array(strtolower($user->role), ['superadmin', 'school_registrar', 'registrar'])) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Access denied. School Registrars must log in through the secure registrar portal.',
                ])->onlyInput('email');
            }

            // RULE 2: VERIFY AND REDIRECT STUDENT
            if ($request->role === 'student') {
                if ($user->role !== 'student') {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return back()->withErrors([
                        'email' => 'This account does not have student privileges.',
                    ])->onlyInput('email');
                }

                $request->session()->regenerate();
                return redirect()->intended('/dashboard');
            }

            // RULE 3: VERIFY AND REDIRECT SCHOLARSHIP OFFICE
            if ($request->role === 'office') {
                // Case-insensitive match: covers 'office', 'officer', 'admin',
                // and 'Scholarship Admin' (the role saved by Super Admin's
                // "Create Scholarship Admin" form).
                $allowedOfficeRoles = ['office', 'officer', 'admin', 'scholarship admin'];

                if (!in_array(strtolower($user->role), $allowedOfficeRoles)) {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return back()->withErrors([
                        'email' => 'This account does not have scholarship office privileges.',
                    ])->onlyInput('email');
                }

                $request->session()->regenerate();
                return redirect()->intended(route('scholarshipadmin.dashboard'));
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // Handle Student Multi-Step Registration Submission
    public function register(Request $request)
    {
        $request->validate([
            // Step 1
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'dob' => ['required', 'date'],
            'phone' => ['required', 'string', 'unique:users'],
            // Step 2
            'student_number' => ['required', 'string', 'unique:users'],
            'course' => ['required', 'string', 'max:255'],
            // GPA isn't collected on the registration form (it's filled in
            // later on the student's profile), so it must stay optional here.
            'gpa' => ['nullable', 'numeric', 'between:1.00,5.00'],
            'year_level' => ['required', 'string'],
            // Step 3
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // Create user with default 'student' role
        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'dob' => $request->dob,
            'phone' => $request->phone,
            'student_number' => $request->student_number,
            'course' => $request->course,
            'gpa' => $request->gpa,
            'year_level' => $request->year_level,
            'email' => $request->email,
            'role' => 'student', // Ensure new accounts default to student
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return response()->json(['success' => true]);
    }

    // Update Student Account Details
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20', 'unique:users,phone,' . $user->id],
            'student_number' => ['nullable', 'string', 'max:50', 'unique:users,student_number,' . $user->id],
            'course' => ['nullable', 'string', 'max:255'],
            'year_level' => ['nullable', 'string', 'max:50'],
            'gpa' => ['nullable', 'string', 'max:10'],
        ]);

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully!');
    }

    // Update Student Security Password
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        return back()->with('success', 'Password updated successfully!');
    }

    // Handle Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}