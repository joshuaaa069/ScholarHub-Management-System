<?php

namespace App\Http\Controllers\ScholarshipAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;

class OfficerController extends Controller
{
    /**
     * Read-only directory of Scholarship Admin / office-type accounts.
     * (Full account management such as create/deactivate stays with
     * Super Admin's User Management page.)
     */
    public function index()
    {
        $officers = User::whereIn('role', ['officer', 'admin', 'office', 'Scholarship Admin'])
            ->latest()
            ->get();

        return view('scholarshipadmin.officers', compact('officers'));
    }
}
