<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Import AuthControllers using clear aliases to resolve conflict
use App\Http\Controllers\AuthController as StudentAuthController;
use App\Http\Controllers\SuperAdmin\AuthController as SuperAdminAuthController;

// Import the Scholarship Controller for dynamic scholarship listings
use App\Http\Controllers\SuperAdmin\UserController as SuperAdminUserController;
use App\Http\Controllers\SuperAdmin\ScholarshipController as SuperAdminScholarshipController;
use App\Http\Controllers\SuperAdmin\AcademicYearController as SuperAdminAcademicYearController;
use App\Http\Controllers\SuperAdmin\ReportController as SuperAdminReportController;
use App\Http\Controllers\SuperAdmin\AuditLogController as SuperAdminAuditLogController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\ScholarshipController;
use App\Http\Controllers\Student\ApplicationController;
use App\Http\Controllers\Student\NotificationController;
use App\Http\Controllers\ScholarshipAdmin\ScholarshipAdminController;
use App\Http\Controllers\ScholarshipAdmin\ProgramController as ScholarshipAdminProgramController;
use App\Http\Controllers\ScholarshipAdmin\ApplicationController as ScholarshipAdminApplicationController;
use App\Http\Controllers\ScholarshipAdmin\OfficerController as ScholarshipAdminOfficerController;
use App\Http\Controllers\ScholarshipAdmin\StudentController as ScholarshipAdminStudentController;
use App\Http\Controllers\ScholarshipAdmin\ReportController as ScholarshipAdminReportController;
use App\Http\Controllers\ScholarshipAdmin\AnnouncementController as ScholarshipAdminAnnouncementController;
use App\Http\Controllers\ScholarshipAdmin\SettingsController as ScholarshipAdminSettingsController;

/*
|--------------------------------------------------------------------------
| Public View & Guest Routes
|--------------------------------------------------------------------------
*/
// FIX: Changed route name from 'home' to 'landingpage' to match your layouts and controllers
Route::get('/', [PublicController::class, 'landing'])->name('landingpage');

Route::middleware('guest')->group(function () {
    // Student Auth Routes
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::post('/login', [StudentAuthController::class, 'login']);
    Route::post('/register', [StudentAuthController::class, 'register']);

    // Dedicated Super Admin Login Routes
    Route::get('/auth/admin-login', [SuperAdminAuthController::class, 'showLogin'])->name('auth.admin-login');
    Route::post('/auth/admin-login', [SuperAdminAuthController::class, 'login']);
});

// Shared Logout route (Requires authentication)
Route::post('/logout', [StudentAuthController::class, 'logout'])->name('logout')->middleware('auth');


/*
|--------------------------------------------------------------------------
| Protected Student Routes (Requires Student Session)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Dashboard Route (With direct boundary safeguard routing checks)
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');

    // Dynamic Scholarship Programs Route
    Route::get('/programs', [ScholarshipController::class, 'index'])->name('student.programs');

    // My Applications Route
    Route::get('/applications', [ApplicationController::class, 'index'])->name('student.applications');

    // Notifications Route
    Route::get('/notifications', [NotificationController::class, 'index'])->name('student.notifications');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('student.notifications.readAll');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('student.notifications.read');

    // Dashboard Search Route
    Route::get('/search', function () {
        $query = request('q');
        $results = [];

        return view('student.search', ['user' => auth()->user(), 'query' => $query, 'results' => $results]);
    })->name('student.search');

    // Profile Settings
    Route::get('/profile', function () {
        return view('student.profile', ['user' => auth()->user()]);
    })->name('student.profile');

    Route::put('/profile/update', [StudentAuthController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [StudentAuthController::class, 'updatePassword'])->name('profile.password');
});

/*
|--------------------------------------------------------------------------
| Protected Super Admin Routes
|--------------------------------------------------------------------------
*/

// Gateway route checking system status for '/superadmin' URL
Route::get('/superadmin', function () {
    if (Auth::check() && Auth::user()->role === 'superadmin') {
        return redirect()->route('superadmin.dashboard');
    }
    return redirect()->route('auth.admin-login');
});

// Admin-only dashboard access
Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::get('/superadmin/dashboard', [SuperAdminAuthController::class, 'dashboard'])->name('superadmin.dashboard');
    Route::get('/superadmin/usermanage', [SuperAdminAuthController::class, 'usermanage'])->name('superadmin.usermanage');
    Route::post('/superadmin/logout', [SuperAdminAuthController::class, 'logout'])->name('superadmin.logout');

    // Route to handle creating the Scholarship Admin
    Route::post('/superadmin/users', [SuperAdminUserController::class, 'store'])->name('superadmin.users.store');

    // Scholarships (system-wide, full CRUD across all Scholarship Admins)
    Route::get('/superadmin/scholarships', [SuperAdminScholarshipController::class, 'index'])->name('superadmin.scholarships');
    Route::post('/superadmin/scholarships', [SuperAdminScholarshipController::class, 'store'])->name('superadmin.scholarships.store');
    Route::put('/superadmin/scholarships/{scholarship}', [SuperAdminScholarshipController::class, 'update'])->name('superadmin.scholarships.update');
    Route::delete('/superadmin/scholarships/{scholarship}', [SuperAdminScholarshipController::class, 'destroy'])->name('superadmin.scholarships.destroy');
    Route::post('/superadmin/scholarships/{scholarship}/toggle', [SuperAdminScholarshipController::class, 'toggleStatus'])->name('superadmin.scholarships.toggle');

    // Academic Years (full CRUD)
    Route::get('/superadmin/academic-years', [SuperAdminAcademicYearController::class, 'index'])->name('superadmin.academic-years');
    Route::post('/superadmin/academic-years', [SuperAdminAcademicYearController::class, 'store'])->name('superadmin.academic-years.store');
    Route::put('/superadmin/academic-years/{academicYear}', [SuperAdminAcademicYearController::class, 'update'])->name('superadmin.academic-years.update');
    Route::delete('/superadmin/academic-years/{academicYear}', [SuperAdminAcademicYearController::class, 'destroy'])->name('superadmin.academic-years.destroy');
    Route::post('/superadmin/academic-years/{academicYear}/set-current', [SuperAdminAcademicYearController::class, 'setCurrent'])->name('superadmin.academic-years.set-current');

    // Reports (read-only computed data; export takes the place of "CRUD" here)
    Route::get('/superadmin/reports', [SuperAdminReportController::class, 'index'])->name('superadmin.reports');
    Route::get('/superadmin/reports/export', [SuperAdminReportController::class, 'exportCsv'])->name('superadmin.reports.export');

    // Audit Logs (read + delete; entries are system-generated only, never edited)
    Route::get('/superadmin/audit-logs', [SuperAdminAuditLogController::class, 'index'])->name('superadmin.audit-logs');
    Route::delete('/superadmin/audit-logs/{auditLog}', [SuperAdminAuditLogController::class, 'destroy'])->name('superadmin.audit-logs.destroy');
    Route::delete('/superadmin/audit-logs', [SuperAdminAuditLogController::class, 'clear'])->name('superadmin.audit-logs.clear');
});

/*
|--------------------------------------------------------------------------
| Scholarship Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:office,officer,admin,scholarship admin'])
    ->prefix('scholarshipadmin')->name('scholarshipadmin.')->group(function () {
        // Dashboard Route (Resolves to URL: /scholarshipadmin/dashboard, Name: scholarshipadmin.dashboard)
        Route::get('/dashboard', [ScholarshipAdminController::class, 'index'])->name('dashboard');

        // FIX: Removed duplicated prefixes. Resolves to URL: /scholarshipadmin/logout, Name: scholarshipadmin.logout
        Route::post('/logout', [ScholarshipAdminController::class, 'logout'])->name('logout');

        // Application Decision Handling Route (Resolves to URL: /scholarshipadmin/applications/{application}/action)
        Route::post('/applications/{application}/action', [ScholarshipAdminController::class, 'action'])->name('applications.action');

        // Scholarship Programs (Create Scholarship)
        Route::get('/programs', [ScholarshipAdminProgramController::class, 'index'])->name('programs');
        Route::post('/programs', [ScholarshipAdminProgramController::class, 'store'])->name('programs.store');

        // Applications (full list, search/filter)
        Route::get('/applications', [ScholarshipAdminApplicationController::class, 'index'])->name('applications');

        // Scholarship Officers (read-only directory)
        Route::get('/officers', [ScholarshipAdminOfficerController::class, 'index'])->name('officers');

        // Students directory
        Route::get('/students', [ScholarshipAdminStudentController::class, 'index'])->name('students');

        // Reports & Analytics
        Route::get('/reports', [ScholarshipAdminReportController::class, 'index'])->name('reports');

        // Announcements
        Route::get('/announcements', [ScholarshipAdminAnnouncementController::class, 'index'])->name('announcements');
        Route::post('/announcements', [ScholarshipAdminAnnouncementController::class, 'store'])->name('announcements.store');

        // Settings (profile / password)
        Route::get('/settings', [ScholarshipAdminSettingsController::class, 'index'])->name('settings');
        Route::put('/settings/profile', [ScholarshipAdminSettingsController::class, 'updateProfile'])->name('settings.profile');
        Route::put('/settings/password', [ScholarshipAdminSettingsController::class, 'updatePassword'])->name('settings.password');
    });
