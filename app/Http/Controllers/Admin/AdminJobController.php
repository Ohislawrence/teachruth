<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Available_Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminJobController extends Controller
{
    public function jobs(Request $request)
    {
        $jobs = Available_Job::with(['school.schoolProfile', 'applications'])
            ->withCount('applications')
            ->when($request->search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhereHas('school.schoolProfile', function ($q) use ($search) {
                          $q->where('school_name', 'like', "%{$search}%");
                      });
            })
            ->when($request->status, function ($query, $status) {
                if ($status === 'active') {
                    $query->active();
                } elseif ($status === 'expired') {
                    $query->where('application_deadline', '<', now())
                          ->orWhere('is_active', false);
                }
            })
            ->latest()
            ->paginate(10);

        return Inertia::render('Admin/Jobs/Index', [
            'jobs' => $jobs,
            'filters' => $request->only(['search', 'status']),
        ]);
    }

    public function showJob(Available_Job $job)
    {
        $job->load([
            'school.schoolProfile',
            'applications.teacher.teacherProfile'
        ]);

        return Inertia::render('Admin/Jobs/Show', [
            'job' => $job,
        ]);
    }

    public function toggleJobStatus(Available_Job $job)
    {
        $job->update(['is_active' => !$job->is_active]);

        $status = $job->is_active ? 'activated' : 'deactivated';

        return redirect()->back()->with('success', "Job {$status} successfully.");
    }

    public function applications(Request $request)
    {
        $applications = JobApplication::with([
                'job.school.schoolProfile',
                'teacher.teacherProfile'
            ])
            ->when($request->search, function ($query, $search) {
                $query->whereHas('teacher', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhereHas('job', function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%");
                });
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(15);

        $stats = [
            'total' => JobApplication::count(),
            'pending' => JobApplication::pending()->count(),
            'reviewed' => JobApplication::reviewed()->count(),
            'shortlisted' => JobApplication::shortlisted()->count(),
            'rejected' => JobApplication::rejected()->count(),
        ];

        return Inertia::render('Admin/Applications/Index', [
            'applications' => $applications,
            'stats' => $stats,
            'filters' => $request->only(['search', 'status']),
        ]);
    }

    public function updateApplicationStatus(Request $request, JobApplication $application)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewed,shortlisted,rejected',
            'school_feedback' => 'nullable|string|max:1000',
        ]);

        $application->update($request->only('status', 'school_feedback'));

        return redirect()->back()->with('success', 'Application status updated successfully.');
    }
}
