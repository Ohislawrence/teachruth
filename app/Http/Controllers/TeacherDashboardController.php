<?php

namespace App\Http\Controllers;

use App\Models\Available_Job;
use App\Models\User;
//use App\Models\Job;
use App\Models\JobApplication;
use App\Models\TeacherAppraisal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TeacherDashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $teacher = $user->load(['teacherProfile', 'latestAppraisal']);

        $stats = [
            'appraisals_count' => $user->appraisals()->count(),
            'jobs_applied_count' => $user->jobApplications()->count(),
            'shortlisted_count' => $user->jobApplications()->shortlisted()->count(),
        ];

        $recentJobs = Available_Job::active()
            ->with(['school.schoolProfile'])
            ->latest()
            ->take(5)
            ->get();

        return Inertia::render('Teacher/Dashboard', [
            'teacher' => $teacher,
            'stats' => $stats,
            'recentJobs' => $recentJobs,
        ]);
    }

    public function profile()
    {
        $user = Auth::user();
        $teacher = $user->load('teacherProfile');

        return Inertia::render('Teacher/Profile', [
            'teacher' => $teacher,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000',
            'qualification' => 'required|string|max:255',
            'years_of_experience' => 'required|integer|min:0',
            'specialization' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'lga' => 'required|string|max:255',
            'is_public' => 'boolean',
        ]);

        $user->update(['name' => $request->name]);

        $user->teacherProfile()->updateOrCreate(
            ['user_id' => $user->id],
            $request->only([
                'phone', 'bio', 'qualification', 'years_of_experience',
                'specialization', 'state', 'lga', 'is_public'
            ])
        );

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function jobs()
    {
        $jobs = Available_Job::active()
            ->with(['school.schoolProfile'])
            ->latest()
            ->filter(request(['search', 'subject', 'level', 'state']))
            ->paginate(10);

        return Inertia::render('Teacher/Jobs', [
            'jobs' => $jobs,
            'filters' => request()->all(['search', 'subject', 'level', 'state']),
        ]);
    }

    public function showJob(Available_Job $job)
    {
        $job->load(['school.schoolProfile']);

        $hasApplied = JobApplication::where('job_id', $job->id)
            ->where('teacher_id', Auth::id())
            ->exists();

        return Inertia::render('Teacher/JobShow', [
            'job' => $job,
            'hasApplied' => $hasApplied,
        ]);
    }

    public function applyJob(Request $request, Available_Job $job)
    {
        $user = Auth::user();

        // Check if already applied
        $existingApplication = JobApplication::where('job_id', $job->id)
            ->where('teacher_id', $user->id)
            ->first();

        if ($existingApplication) {
            return redirect()->back()->with('error', 'You have already applied for this job.');
        }

        JobApplication::create([
            'job_id' => $job->id,
            'teacher_id' => $user->id,
            'cover_letter' => $request->cover_letter,
        ]);

        return redirect()->route('teacher.applications')->with('success', 'Application submitted successfully.');
    }

    public function applications()
    {
        $teacherId = Auth::id();

        // Get applications with relationships
        $applications = JobApplication::where('teacher_id', $teacherId)
            ->with(['job.school.schoolProfile'])
            ->latest()
            ->paginate(10);

        // Calculate stats in a single query
        $statusCounts = JobApplication::where('teacher_id', $teacherId)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $stats = [
            'total' => array_sum($statusCounts),
            'pending' => $statusCounts['pending'] ?? 0,
            'reviewed' => $statusCounts['reviewed'] ?? 0,
            'shortlisted' => $statusCounts['shortlisted'] ?? 0,
            'rejected' => $statusCounts['rejected'] ?? 0,
        ];

        return Inertia::render('Teacher/Applications', [
            'applications' => $applications,
            'stats' => $stats,
        ]);
    }

    public function appraisals()
    {
        $appraisals = TeacherAppraisal::where('teacher_id', Auth::id())
            ->latest()
            ->paginate(10);

        return Inertia::render('Teacher/Appraisals', [
            'appraisals' => $appraisals,
        ]);
    }

    public function appraisalDetails($id)
    {
        $appraisal = TeacherAppraisal::where('teacher_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        return Inertia::render('Teacher/Appraisaldetails', [
            'appraisal' => $appraisal,
        ]);
    }

    public function reappraise()
    {
        $user = Auth::user();

        // Logic for re-appraisal (might involve payment)
        return Inertia::render('Teacher/Reappraise');
    }
}
