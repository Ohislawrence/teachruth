<?php

use App\Http\Controllers\Admin\AdminAppraisalController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminJobController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\AdminSettingsController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\PaystackWebhookController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TeacherRegistrationController;
use App\Http\Controllers\TeacherDashboardController;
use App\Http\Controllers\TeacherReappraisalController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use App\Http\Controllers\SchoolRegistrationController;
use App\Http\Controllers\SchoolDashboardController;

Route::get('/dashboard', function () {
    if (auth()->check()) {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->isSchool()) {
            return redirect()->route('school.dashboard');
        }elseif (auth()->user()->isTeacher()) {
            return redirect()->route('teacher.dashboard');
        }
    }
    return redirect()->route('login');
})->middleware(['auth:sanctum'])->name('dashboard');



// Teacher Registration Routes
Route::prefix('teacher/register')->group(function () {
    Route::get('/', [TeacherRegistrationController::class, 'showStep1'])->name('teacher.register.step1');
    Route::post('/', [TeacherRegistrationController::class, 'storeStep1'])->name('teacher.register.storeStep1');

    Route::get('/qualifying-questions', [TeacherRegistrationController::class, 'showStep2'])->name('teacher.register.step2');
    Route::post('/qualifying-questions', [TeacherRegistrationController::class, 'storeStep2'])->name('teacher.register.storeStep2');

    Route::get('/resume', [TeacherRegistrationController::class, 'showStep3'])->name('teacher.register.step3');
    Route::post('/resume', [TeacherRegistrationController::class, 'storeStep3'])->name('teacher.register.storeStep3');

    Route::get('/payment', [TeacherRegistrationController::class, 'showStep4'])->name('teacher.register.step4');
    Route::post('/payment/process', [TeacherRegistrationController::class, 'processPayment'])->name('teacher.register.payment.process');
    Route::get('/payment/callback', [TeacherRegistrationController::class, 'paymentCallback'])->name('teacher.register.payment.callback');

    Route::get('/appraisal', [TeacherRegistrationController::class, 'showStep5'])->name('teacher.register.step5');
    Route::post('/complete', [TeacherRegistrationController::class, 'completeRegistration'])->name('teacher.register.complete');
});


Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('welcome');

Route::get('terms', function () {
    return Inertia::render('Welcome');
})->name('terms.show');

Route::get('policy', function () {
    return Inertia::render('Welcome');
})->name('policy.show');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified', 'teacher'
])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [TeacherDashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [TeacherDashboardController::class, 'updateProfile'])->name('profile.update');

    Route::get('/jobs', [TeacherDashboardController::class, 'jobs'])->name('jobs');
    Route::get('/jobs/{job}', [TeacherDashboardController::class, 'showJob'])->name('jobs.show');
    Route::post('/jobs/{job}/apply', [TeacherDashboardController::class, 'applyJob'])->name('jobs.apply');

    Route::get('/applications', [TeacherDashboardController::class, 'applications'])->name('applications');
    Route::get('/appraisals', [TeacherDashboardController::class, 'appraisals'])->name('appraisals');
    Route::get('/appraisals/{appraise}', [TeacherDashboardController::class, 'appraisalDetails'])->name('appraisals.show');
    Route::get('/reappraise', [TeacherDashboardController::class, 'reappraise'])->name('reappraise');
    // Teacher Reappraisal Routes
    Route::prefix('reappraisal')->name('reappraisal.')->group(function () {
        Route::get('/', [TeacherReappraisalController::class, 'show'])->name('index');
        Route::get('/payment', [TeacherReappraisalController::class, 'showPayment'])->name('payments');
        Route::post('/payment/process', [TeacherReappraisalController::class, 'processPayment'])->name('payment.process');
        Route::get('/payment/callback', [TeacherReappraisalController::class, 'paymentCallback'])->name('payment.callback');
        Route::get('/payment/verify/{reference}', [TeacherReappraisalController::class, 'verifyPayment'])->name('payment.verify');
        Route::get('/questions', [TeacherReappraisalController::class, 'showQuestions'])->name('questions');
        Route::post('/process', [TeacherReappraisalController::class, 'processReappraisal'])->name('process');
    });
    Route::post('reappraisal/payment/simulate', [TeacherReappraisalController::class, 'simulatePayment'])
    ->name('reappraisal.payment.simulate');
});


Route::post('/paystack/webhook', [PaystackWebhookController::class, 'handleWebhook'])
    ->name('paystack.webhook')
    ->withoutMiddleware([VerifyCsrfToken::class]);



    //admin
Route::prefix('admin')->middleware(['auth:sanctum',
    config('jetstream.auth_session'),
    'verified', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');

    // Users Management
    Route::get('/teachers', [AdminUserController::class, 'teachers'])->name('admin.teachers');
    Route::get('/teachers/{user}', [AdminUserController::class, 'showTeacher'])->name('admin.teachers.show');
    Route::get('/schools', [AdminUserController::class, 'schools'])->name('admin.schools');
    Route::get('/schools/{user}', [AdminUserController::class, 'showSchool'])->name('admin.schools.show');
    Route::post('/schools/{user}/verify', [AdminUserController::class, 'verifySchool'])->name('admin.schools.verify');
    Route::post('/schools/{user}/unverify', [AdminUserController::class, 'unverifySchool'])->name('admin.schools.unverify');
    Route::post('/users/{user}/suspend', [AdminUserController::class, 'suspendUser'])->name('admin.users.suspend');
    Route::post('/users/{user}/unsuspend', [AdminUserController::class, 'unsuspendUser'])->name('admin.users.unsuspend');

    // Jobs Management
    Route::get('/jobs', [AdminJobController::class, 'jobs'])->name('admin.jobs');
    Route::get('/jobs/{job}', [AdminJobController::class, 'showJob'])->name('admin.jobs.show');
    Route::post('/jobs/{job}/toggle-status', [AdminJobController::class, 'toggleJobStatus'])->name('admin.jobs.toggle-status');
    Route::get('/applications', [AdminJobController::class, 'applications'])->name('admin.applications');
    Route::post('/applications/{application}/status', [AdminJobController::class, 'updateApplicationStatus'])->name('admin.applications.update-status');

    // Appraisals Management
    Route::get('/appraisals', [AdminAppraisalController::class, 'appraisals'])->name('admin.appraisals');
    Route::get('/appraisals/{appraisal}', [AdminAppraisalController::class, 'showAppraisal'])->name('admin.appraisals.show');
    Route::get('/appraisals-report', [AdminAppraisalController::class, 'generateAppraisalReport'])->name('admin.appraisals.report');

    // Payments Management
    Route::get('/payments', [AdminPaymentController::class, 'payments'])->name('admin.payments');
    Route::get('/revenue-report', [AdminPaymentController::class, 'revenueReport'])->name('admin.payments.revenue-report');

    // Settings
    Route::get('/settings/qualifying-questions', [AdminSettingsController::class, 'qualifyingQuestions'])->name('admin.settings.questions');
    Route::post('/settings/qualifying-questions', [AdminSettingsController::class, 'storeQualifyingQuestion'])->name('admin.settings.questions.store');
    Route::put('/settings/qualifying-questions/{question}', [AdminSettingsController::class, 'updateQualifyingQuestion'])->name('admin.settings.questions.update');
    Route::delete('/settings/qualifying-questions/{question}', [AdminSettingsController::class, 'destroyQualifyingQuestion'])->name('admin.settings.questions.destroy');
    Route::post('/settings/qualifying-questions/{question}/toggle', [AdminSettingsController::class, 'toggleQuestionStatus'])->name('admin.settings.questions.toggle');
});




// School Registration Routes
Route::prefix('school/register')->group(function () {
    Route::get('/', [SchoolRegistrationController::class, 'showStep1'])->name('school.register.step1');
    Route::post('/', [SchoolRegistrationController::class, 'storeStep1'])->name('school.register.storeStep1');

    Route::get('/details', [SchoolRegistrationController::class, 'showStep2'])->name('school.register.step2');
    Route::post('/details', [SchoolRegistrationController::class, 'storeStep2'])->name('school.register.storeStep2');

    Route::get('/complete', [SchoolRegistrationController::class, 'showStep3'])->name('school.register.step3');
    Route::post('/complete', [SchoolRegistrationController::class, 'completeRegistration'])->name('school.register.complete');
});

// School Routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified', 'school'
])->prefix('school')->name('school.')->group(function () {
    Route::get('/dashboard', [SchoolDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [SchoolDashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [SchoolDashboardController::class, 'updateProfile'])->name('profile.update');

    // Jobs Management
    Route::get('/jobs', [SchoolDashboardController::class, 'jobs'])->name('jobs');
    Route::get('/jobs/create', [SchoolDashboardController::class, 'createJob'])->name('jobs.create');
    Route::post('/jobs', [SchoolDashboardController::class, 'storeJob'])->name('jobs.store');
    Route::get('/jobs/{job}/edit', [SchoolDashboardController::class, 'editJob'])->name('jobs.edit');
    Route::put('/jobs/{job}', [SchoolDashboardController::class, 'updateJob'])->name('jobs.update');
    Route::delete('/jobs/{job}', [SchoolDashboardController::class, 'deleteJob'])->name('jobs.delete');
    Route::get('/jobs/{job}/applicants', [SchoolDashboardController::class, 'viewApplicants'])->name('jobs.applicants');

    // Applications Management
    Route::get('/applications', [SchoolDashboardController::class, 'applications'])->name('applications');
    Route::get('/applications/{application}', [SchoolDashboardController::class, 'showApplication'])->name('applications.show');
    Route::post('/applications/{application}/status', [SchoolDashboardController::class, 'updateApplicationStatus'])->name('applications.update-status');

    Route::get('/teacher/{teacher}/appraisal/{appraisal}', [SchoolDashboardController::class, 'viewAppraisal'])
        ->name('teacher.appraisal');

    // Applicants management
    Route::get('/jobs/{job}/applicants', [SchoolDashboardController::class, 'viewApplicants'])
        ->name('jobs.applicants');

    Route::post('/applications/bulk-update', [SchoolDashboardController::class, 'bulkUpdateApplications'])
        ->name('applications.bulk-update');

    Route::post('/applications/bulk-email', [SchoolDashboardController::class, 'sendBulkEmail'])
        ->name('applications.bulk-email');

    Route::post('/applications/{job}/export', [SchoolDashboardController::class, 'exportApplicants'])
        ->name('applications.export');
});
