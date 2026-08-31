<?php

namespace App\Http\Controllers\Registrar;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\AuditLog;
use App\Models\ApplicationDocument;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class RegistrarController extends Controller
{
    /**
     * Registrar dashboard: shows the queue of applications awaiting
     * registrar review, plus KPI metrics.
     */
    public function index()
    {
        $metrics = [
            'pendingReview' => Application::where('status', Application::STATUS_PENDING)->count(),
            'endorsed' => Application::where('status', Application::STATUS_REGISTRAR_APPROVED)->count(),
            'rejected' => Application::where('status', Application::STATUS_REGISTRAR_REJECTED)->count(),
            'totalStudents' => User::where('role', 'student')->count(),
        ];

        $applications = Application::with(['student', 'scholarship'])
            ->where('status', Application::STATUS_PENDING)
            ->latest()
            ->get();

        return view('registrar.dashboard', compact('metrics', 'applications'));
    }

    /**
     * Full registrar applications list with search/filter.
     */
    public function applications(Request $request)
    {
        $query = Application::with(['student', 'scholarship']);

        if ($request->filled('status') && $request->status !== 'All') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $term = $request->search;
            $query->whereHas('student', function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('email', 'like', "%{$term}%");
            });
        }

        $applications = $query->latest()->paginate(15)->withQueryString();

        return view('registrar.applications', compact('applications'));
    }

    /**
     * Stage 1: Registrar action — endorse (forward to scholarship admin)
     * or reject the application. The application must currently be 'Pending'.
     */
    public function action(Request $request, Application $application)
    {
        $request->validate([
            'action' => 'required|in:Endorse,Reject',
            'remarks' => 'nullable|string|max:2000',
        ]);

        if (!in_array($application->status, Application::registrarActionableStatuses(), true)) {
            return back()->with('error', 'This application is no longer awaiting registrar review.');
        }

        $newStatus = $request->action === 'Endorse'
            ? Application::STATUS_REGISTRAR_APPROVED
            : Application::STATUS_REGISTRAR_REJECTED;

        $application->update([
            'status' => $newStatus,
            'registrar_id' => Auth::id(),
            'registrar_remarks' => $request->remarks,
        ]);

        // Inform the student of the registrar's decision
        Notification::create([
            'user_id' => $application->user_id,
            'type' => 'application_registrar',
            'title' => $newStatus === Application::STATUS_REGISTRAR_APPROVED
                ? 'Registrar endorsed your application'
                : 'Registrar did not endorse your application',
            'message' => $newStatus === Application::STATUS_REGISTRAR_APPROVED
                ? 'Your application for "' . ($application->scholarship->title ?? 'the scholarship') . '" has been endorsed by the registrar and is now awaiting the scholarship admin\'s final decision.'
                : 'Your application for "' . ($application->scholarship->title ?? 'the scholarship') . '" was not endorsed by the registrar.' . ($request->remarks ? ' Remarks: ' . $request->remarks : ''),
        ]);

        AuditLog::record(
            "Registrar {$request->action}",
            "Application #{$application->id} for " . ($application->student->name ?? 'a student')
                . ($request->remarks ? ' — Remarks: ' . $request->remarks : '')
        );

        $actionWord = $newStatus === Application::STATUS_REGISTRAR_APPROVED ? 'endorsed' : 'rejected';
        return back()->with('success', "Application {$actionWord} successfully.");
    }

    /**
     * Registrar logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.admin-login');
    }

    /**
     * Show a single application with all its uploaded documents so the
     * registrar can review what the student submitted before deciding.
     */
    public function show(Application $application)
    {
        $application->load(['student', 'scholarship', 'registrar', 'documents.requirement']);

        return view('registrar.application-show', compact('application'));
    }

    /**
     * Stream an uploaded document for the registrar to view inline.
     */
    public function downloadDocument(Application $application, ApplicationDocument $document)
    {
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
