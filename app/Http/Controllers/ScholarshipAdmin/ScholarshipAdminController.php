<?php

namespace App\Http\Controllers\ScholarshipAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;
use App\Models\ApplicationDocument;
use App\Models\AuditLog;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ScholarshipAdminController extends Controller
{
    /**
     * Display the admin dashboard with stats and review queue.
     */
    public function index()
    {
        // Scope: a scholarship admin only sees the metrics and review queue
        // tied to the scholarship they own. Super-admins (no scholarship_id)
        // see all.
        $ownScholarshipId = optional(Auth::user())->scholarship_id;
        $applyScope = function ($query) use ($ownScholarshipId) {
            if (!is_null($ownScholarshipId)) {
                $query->where('scholarship_id', $ownScholarshipId);
            }
        };

        // 1. Gather KPIs/Metrics for the two-stage pipeline (scoped)
        $metrics = [
            'totalStudents'   => User::where('role', 'student')->count(),
            'pending'         => Application::where($applyScope)->where('status', Application::STATUS_PENDING)->count(),
            'awaitingDecision' => Application::where($applyScope)->where('status', Application::STATUS_REGISTRAR_APPROVED)->count(),
            'approvedScholars' => Application::where($applyScope)->where('status', Application::STATUS_APPROVED)->count(),
            'rejected'        => Application::where($applyScope)->where('status', Application::STATUS_REJECTED)->count(),
        ];

        // 2. Scholarship admin only sees applications that the registrar
        //    endorsed for their scholarship.
        $applications = Application::with(['student', 'scholarship'])
            ->where($applyScope)
            ->where('status', Application::STATUS_REGISTRAR_APPROVED)
            ->latest()
            ->get();

        // 3. Compute dynamic category statistics for chart distributions safely
        $totalApps = Application::where($applyScope)->count();
        $distribution = [];

        if ($totalApps > 0) {
            $categories = ['STEM', 'Merit', 'Need-Based', 'Government', 'Corporate'];

            foreach ($categories as $category) {
                $count = Application::where($applyScope)
                    ->whereHas('scholarship', function ($query) use ($category) {
                        $query->where('title', 'like', "%{$category}%");
                    })->count();

                $distribution[$category] = round(($count / $totalApps) * 100);
            }
        } else {
            $distribution = ['STEM' => 0, 'Merit' => 0, 'Need-Based' => 0, 'Government' => 0, 'Corporate' => 0];
        }

        return view('scholarshipadmin.dashboard', compact('metrics', 'applications', 'distribution'));
    }

    /**
     * Stage 2: Final application decision (Approve/Reject).
     * Only applications with status 'Registrar Approved' can be acted on here.
     */
    public function action(Request $request, Application $application)
    {
        // Cross-scholarship access guard
        $ownScholarshipId = optional(Auth::user())->scholarship_id;
        if (!is_null($ownScholarshipId) && (int) $application->scholarship_id !== (int) $ownScholarshipId) {
            abort(403, 'This application belongs to a different scholarship.');
        }

        $request->validate([
            'action' => 'required|in:Approve,Reject',
            'admin_remarks' => 'nullable|string|max:2000',
        ]);

        if (!in_array($application->status, Application::adminActionableStatuses(), true)) {
            return back()->with('error', 'This application is not ready for the scholarship admin decision. The registrar must endorse it first.');
        }

        $status = $request->action === 'Approve' ? Application::STATUS_APPROVED : Application::STATUS_REJECTED;

        $application->update([
            'status' => $status,
            'admin_remarks' => $request->admin_remarks,
        ]);

        // Inform the student of the scholarship admin's final decision
        Notification::create([
            'user_id' => $application->user_id,
            'type' => 'application_admin',
            'title' => $status === Application::STATUS_APPROVED
                ? 'Congratulations — your scholarship was approved!'
                : 'Your scholarship application was not approved',
            'message' => $status === Application::STATUS_APPROVED
                ? 'Your application for "' . ($application->scholarship->title ?? 'the scholarship') . '" was approved by the scholarship office. You are now officially a scholar.'
                : 'Your application for "' . ($application->scholarship->title ?? 'the scholarship') . '" was rejected by the scholarship office.' . ($request->admin_remarks ? ' Remarks: ' . $request->admin_remarks : ''),
        ]);

        AuditLog::record(
            "Application {$status}",
            "{$status} application #{$application->id} for " . ($application->student->name ?? 'a student')
                . ($request->admin_remarks ? ' — Remarks: ' . $request->admin_remarks : '')
        );

        return redirect()->back()->with('success', "Application status updated to {$status} successfully.");
    }

    /**
     * Handle Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landingpage');
    }

    /**
     * Show a single application (and its uploaded documents) for the
     * scholarship admin to review before making the final decision.
     */
    public function show(Application $application)
    {
        // Cross-scholarship access guard: a scholarship admin can only view
        // applications tied to the scholarship they own.
        $ownScholarshipId = optional(Auth::user())->scholarship_id;
        if (!is_null($ownScholarshipId) && (int) $application->scholarship_id !== (int) $ownScholarshipId) {
            abort(403, 'This application belongs to a different scholarship.');
        }

        $application->load(['student', 'scholarship', 'registrar', 'documents.requirement']);

        return view('scholarshipadmin.application-show', compact('application'));
    }

    /**
     * Stream an uploaded document for the scholarship admin to view inline.
     */
    public function downloadDocument(Application $application, ApplicationDocument $document)
    {
        // Cross-scholarship access guard
        $ownScholarshipId = optional(Auth::user())->scholarship_id;
        if (!is_null($ownScholarshipId) && (int) $application->scholarship_id !== (int) $ownScholarshipId) {
            abort(403, 'This application belongs to a different scholarship.');
        }

        abort_unless($document->application_id === $application->id, 404);
        abort_unless($document->student_file_path, 404);

        return $this->streamFile($document->student_file_path, $document->student_original_name);
    }

    protected function streamFile(string $path, ?string $downloadName = null)
    {
        $disk = Storage::disk('public');
        abort_unless($disk->exists($path), 404);

        $fullPath = $disk->path($path);
        $mime = $disk->mimeType($path) ?: 'application/octet-stream';
        $name = $downloadName ?: basename($path);

        return Response::make(file_get_contents($fullPath), 200, [
            'Content-Type'        => $mime,
            'Content-Disposition' => 'inline; filename="' . $name . '"',
        ]);
    }
}
