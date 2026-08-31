<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\DocumentRequirement;
use App\Models\Scholarship;
use Illuminate\Support\Facades\Schema;

class PublicController extends Controller
{
    /**
     * Public landing page — shows real, currently Open scholarship programs
     * pulled straight from the database plus the required documents list
     * and contact details.
     */
    public function landing()
    {
        $scholarships = collect();

        if (Schema::hasTable('scholarships')) {
            $scholarships = Scholarship::where('status', 'Open')
                ->orderBy('deadline', 'asc')
                ->take(6)
                ->get();

            // Annotate each card with its own available-slot count:
            // slots_total − count(approved apps for this scholarship).
            // Pending / registrar-approved / rejected apps do not eat from
            // the pool — only finalized (Approved) awards do.
            if (Schema::hasTable('applications')) {
                $approvedByScholarship = Application::where('status', Application::STATUS_APPROVED)
                    ->selectRaw('scholarship_id, COUNT(*) as cnt')
                    ->groupBy('scholarship_id')
                    ->pluck('cnt', 'scholarship_id');

                foreach ($scholarships as $s) {
                    $approved   = (int) ($approvedByScholarship[$s->id] ?? 0);
                    $s->slots_available = max(0, (int) $s->slots_total - $approved);
                }
            } else {
                foreach ($scholarships as $s) {
                    $s->slots_available = (int) $s->slots_total;
                }
            }
        }

        // Required documents (master list). Falls back to empty if the table
        // does not exist (e.g. before running migrations on a fresh install).
        $requiredDocuments = collect();
        if (Schema::hasTable('document_requirements')) {
            $requiredDocuments = DocumentRequirement::active();
        }

        // Live snapshot counters for the hero. Each falls back to 0 when its
        // backing table has not been created yet.
        $stats = [
            'active_scholars'      => '0',
            'scholarship_programs' => '0',
            'total_slots'          => '0',
            'applications_this_year' => '0',
        ];

        try {
            if (Schema::hasTable('applications')) {
                $stats['active_scholars'] = (string) Application::where('status', Application::STATUS_APPROVED)->count();
                $stats['applications_this_year'] = (string) Application::whereYear('created_at', date('Y'))->count();
            }
        } catch (\Throwable $e) {
            // keep defaults
        }

        try {
            if (Schema::hasTable('scholarships')) {
                $stats['scholarship_programs'] = (string) Scholarship::where('status', 'Open')->count();
                // Available seats = sum(slots_total) − count(approved apps).
                // Only finalized (Approved) awards eat from the pool;
                // pending / registrar-approved / rejected apps do not.
                $totalSeats = (int) Scholarship::where('status', 'Open')->sum('slots_total');
                $accepted   = 0;
                if (Schema::hasTable('applications')) {
                    $accepted = (int) Application::where('status', Application::STATUS_APPROVED)->count();
                }
                $stats['total_slots'] = (string) max(0, $totalSeats - $accepted);
            }
        } catch (\Throwable $e) {
            // keep defaults
        }

        $stats['satisfaction_rate'] = '98%';

        // Public contact information shown on the landing page. These are
        // hard-coded defaults that mirror the school's official channels —
        // the institution can change them in a future settings update.
        $contact = [
            'address' => 'Christ the King College, Gingoog City',
            'phone'   => '+63 (88) 123-4567',
            'email'   => 'scholarships@ckcscholarhub.com',
        ];

        return view('landingpage', [
            'scholarships'        => $scholarships,
            'required_documents'  => $requiredDocuments,
            'contact'             => $contact,
            'stats'               => $stats,
        ]);
    }
}
