<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Check if user's role is in the allowed list (case-insensitive, so
        // 'Scholarship Admin' matches a 'scholarship admin' rule, etc.)
        $normalizedRoles = array_map('strtolower', $roles);
        if (in_array(strtolower($user->role), $normalizedRoles)) {
            return $next($request);
        }

        // If a superadmin tries to access student routes, send them to their own dashboard
        if ($user->role === 'superadmin') {
            return redirect()->route('superadmin.dashboard');
        }

        // Otherwise, send back to login
        Auth::logout();
        return redirect()->route('login')->withErrors([
            'email' => 'Unauthorized access. You do not have the required permissions.'
        ]);
    }
}