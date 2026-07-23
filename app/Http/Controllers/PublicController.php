<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;

class PublicController extends Controller
{
    /**
     * Public landing page — shows real, currently Open scholarship
     * programs pulled straight from the database (no mock/sample data).
     */
    public function landing()
    {
        $scholarships = Scholarship::where('status', 'Open')
            ->orderBy('deadline', 'asc')
            ->take(6)
            ->get();

        return view('landingpage', compact('scholarships'));
    }
}
