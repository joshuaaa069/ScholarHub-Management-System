<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\ApplicationDocument;
use App\Models\DocumentRequirement;
use App\Models\Notification;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ApplicationController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $applications = Application::with(['scholarship', 'officer', 'registrar', 'documents.requirement'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('student.applications', compact('user', 'applications'));
    }

    /**
     * Show a single application with all its uploaded documents.
     * Students can only view their own applications.
     */
    public function show(Application $application)
    {
        abort_unless($application->user_id === auth()->id(), 403);

        $application->load(['scholarship', 'officer', 'registrar', 'documents.requirement']);

        return view('student.application-show', [
            'user' => auth()->user(),
            'application' => $application,
        ]);
    }

    /**
     * Serve an uploaded file through an authenticated route so the URL
     * doesn't 403 (the public storage symlink is not always available).
     * The student can only download their own documents.
     */
    public function downloadDocument(Application $application, ApplicationDocument $document)
    {
        abort_unless($application->user_id === auth()->id(), 403);
        abort_unless($document->application_id === $application->id, 404);
        abort_unless($document->student_file_path, 404);

        return $this->streamFile($document->student_file_path, $document->student_original_name);
    }

    /**
     * Stream a file from the public disk to the browser. Returns 404 if the
     * file is missing on disk so the user gets a clean error.
     */
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

    /**
     * Step 1: When a student clicks "Apply Now" we land them on the upload
     * form. We do NOT create the application yet — it is created together
     * with all required documents when the form is submitted.
     */
    public function create(Scholarship $scholarship)
    {
        if (!$scholarship->status || $scholarship->status !== 'Open') {
            return redirect()->back()->with('error', 'This scholarship is no longer open for applications.');
        }

        $user = auth()->user();

        $alreadyApplied = Application::where('user_id', $user->id)
            ->where('scholarship_id', $scholarship->id)
            ->exists();

        if ($alreadyApplied) {
            return redirect()->route('student.applications')->with('error', 'You have already applied to this scholarship.');
        }

        $requirements = DocumentRequirement::active();

        return view('student.application-upload', [
            'user' => $user,
            'scholarship' => $scholarship,
            'requirements' => $requirements,
        ]);
    }

    /**
     * Step 2: Persist the application along with all required documents in a
     * single transaction. If any required file is missing the transaction
     * is rolled back and the form is re-displayed with errors.
     */
    public function store(Request $request, Scholarship $scholarship)
    {
        $user = $request->user();

        if (!$scholarship->status || $scholarship->status !== 'Open') {
            return redirect()->back()->with('error', 'This scholarship is no longer open for applications.');
        }

        $alreadyApplied = Application::where('user_id', $user->id)
            ->where('scholarship_id', $scholarship->id)
            ->exists();

        if ($alreadyApplied) {
            return redirect()->route('student.applications')->with('error', 'You have already applied to this scholarship.');
        }

        $requirements = DocumentRequirement::active();

        // Build dynamic validation rules — one file per requirement.
        $rules = [];
        foreach ($requirements as $req) {
            $rules["documents.{$req->id}"] = $req->is_required
                ? ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120']
                : ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'];
        }

        $validated = $request->validate($rules, [
            'required' => 'Please upload :attribute.',
            'mimes'    => ':attribute must be a PDF, JPG, or PNG file.',
            'max'      => ':attribute may not be larger than 5MB.',
        ]);

        try {
            DB::beginTransaction();

            $application = Application::create([
                'application_code' => 'APP-' . strtoupper(Str::random(8)),
                'user_id' => $user->id,
                'scholarship_id' => $scholarship->id,
                'status' => Application::STATUS_PENDING,
            ]);

            foreach ($requirements as $req) {
                $file = $request->file("documents.{$req->id}");

                $path = null;
                $originalName = null;

                if ($file) {
                    // Store under applications/{application_id}/{requirement_name}.ext
                    $extension = $file->getClientOriginalExtension();
                    $safeName = Str::slug($req->name) . '_' . Str::random(6) . '.' . $extension;
                    $path = $file->storeAs(
                        "applications/{$application->id}",
                        $safeName,
                        'public'
                    );
                    $originalName = $file->getClientOriginalName();
                }

                ApplicationDocument::create([
                    'application_id' => $application->id,
                    'document_requirement_id' => $req->id,
                    'student_file_path' => $path,
                    'student_original_name' => $originalName,
                    'student_uploaded_at' => $file ? now() : null,
                    'is_complete' => (bool) $file,
                ]);
            }

            if ($scholarship->slots_left > 0) {
                $scholarship->decrement('slots_left');
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            // Clean up any uploaded files on a failed transaction
            if (isset($application)) {
                Storage::disk('public')->deleteDirectory("applications/{$application->id}");
            }
            return back()->withInput()->with('error', 'Failed to submit application: ' . $e->getMessage());
        }

        // Confirm the submission back to the student
        Notification::create([
            'user_id' => $user->id,
            'type' => 'application_submitted',
            'title' => 'Application submitted',
            'message' => 'Your application for "' . $scholarship->title . '" has been submitted with all required documents. It is now awaiting the registrar\'s review.',
        ]);

        return redirect()->route('student.applications')->with('success', 'Application submitted successfully for ' . $scholarship->title . ' with all required documents.');
    }
}
