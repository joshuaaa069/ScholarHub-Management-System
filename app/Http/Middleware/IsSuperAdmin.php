<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsSuperAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. If not logged in, redirect to Super Admin Login
        if (!Auth::check()) {
            return redirect()->route('auth.admin-login');
        }

        // 2. If logged in but not a Super Admin, abort or redirect
        if (Auth::user()->role !== 'superadmin') {
            Auth::logout();
            return redirect()->route('auth.admin-login')->withErrors([
                'email' => 'Unauthorized access. Super Admins only.'
            ]);
        }

        return $next($request);
    }
}