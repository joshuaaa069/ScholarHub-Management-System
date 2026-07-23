<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Store a newly created Scholarship Admin account.
     *
     * Required fields: Last Name, First Name, Gmail address, Scholarship Name,
     * and a Password for the new account.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
                'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/i',
            ],
            'scholarship_name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'string'],
        ], [
            'email.regex' => 'Please use a valid Gmail address (e.g. name@gmail.com).',
        ]);

        User::create([
            'name' => trim($validated['first_name'] . ' ' . $validated['last_name']),
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'scholarship_name' => $validated['scholarship_name'],
            'role' => $validated['role'],
            'status' => 'Active',
            'password' => Hash::make($validated['password']),
        ]);

        AuditLog::record(
            'Created Scholarship Admin',
            trim($validated['first_name'] . ' ' . $validated['last_name']) . ' (' . $validated['email'] . ') assigned to "' . $validated['scholarship_name'] . '"'
        );

        return redirect()->route('superadmin.usermanage')
            ->with('success', 'Scholarship Admin account for "' . $validated['scholarship_name'] . '" successfully created!');
    }
}
