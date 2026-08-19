<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Make sure to import your User model here for the dashboard view

class AuthController extends Controller // <-- MAKE SURE THIS SAYS AuthController, NOT UserController
{
    // Show the Super Admin Login Page
    public function showLogin()
    {
        if (Auth::check() && in_array(strtolower(Auth::user()->role), ['superadmin', 'school_registrar', 'registrar'])) {
            return redirect()->route('superadmin.dashboard');
        }
        return view('auth.admin-login');
    }

    // Handle Authentication Attempt
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            if (in_array(strtolower(Auth::user()->role), ['superadmin', 'school_registrar', 'registrar'])) {
                $request->session()->regenerate();
                return redirect()->intended(route('superadmin.dashboard'));
            }

            Auth::logout();
            return back()->withErrors([
                'email' => 'Access Denied. You do not have administrator privileges.',
            ]);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // Render the dashboard with dynamic user rows
    public function dashboard()
    {
        $users = User::where('role', 'Scholarship Admin')->latest()->get();
        $totalUsers = $users->count();

        return view('superadmin.dashboard', compact('users', 'totalUsers'));
    }

    public function usermanage()
    {
        $users = User::where('role', 'Scholarship Admin')->latest()->get();
        $totalUsers = $users->count();

        return view('superadmin.usermanage', compact('users', 'totalUsers'));
    }

    // Handle Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.admin-login');
    }
}