<?php

namespace App\Http\Controllers;

use App\Models\Available_Job;
use App\Models\JobApplication;
use App\Models\SchoolProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SchoolDashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $schoolProfile = $user->schoolProfile;

        // Get stats for the dashboard
        $stats = [
            'total_jobs' => Available_Job::where('school_id', $user->id)->count(),
            'active_jobs' => Available_Job::where('school_id', $user->id)
                ->where('is_active', true)
                ->where('application_deadline', '>=', now())
                ->count(),
            'total_applications' => JobApplication::whereHas('job', function($query) use ($user) {
                $query->where('school_id', $user->id);
            })->count(),
            'pending_applications' => JobApplication::whereHas('job', function($query) use ($user) {
                $query->where('school_id', $user->id);
            })->where('status', JobApplication::STATUS_PENDING)->count(),
        ];

        // Recent job applications
        $recentApplications = JobApplication::whereHas('job', function($query) use ($user) {
                $query->where('school_id', $user->id);
            })
            ->with(['job', 'teacher.teacherProfile'])
            ->latest()
            ->take(5)
            ->get();

        // Recent jobs posted
        $recentJobs = Available_Job::where('school_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return Inertia::render('School/Dashboard', [
            'stats' => $stats,
            'recentApplications' => $recentApplications,
            'recentJobs' => $recentJobs,
            'schoolProfile' => $schoolProfile,
        ]);
    }

    public function profile()
    {
        $user = Auth::user();
        return Inertia::render('School/Profile', [
            'profile' => $user->schoolProfile,
        ]);
    }

    public function updateProfile(Request $request)
    {
        try {
            $user = Auth::user();

            $validated = $request->validate([
                'school_name' => 'required|string|max:255',
                'about' => 'nullable|string|max:1000',
                'phone' => 'required|string|max:20',
                'address' => 'required|string|max:500',
                'state' => 'required|string|max:100',
                'lga' => 'required|string|max:100',
                'website' => 'nullable|url|max:255',
                'school_type' => 'required|in:nursery,primary,secondary,mixed',
                'ownership' => 'required|in:private,public,mission,community',
                'logo' => 'nullable|image|max:2048',
            ], [
                'website.url' => 'Please enter a valid website URL (e.g., https://example.com)',
                'logo.image' => 'Please upload a valid image file (JPEG, PNG, JPG, GIF)',
                'logo.max' => 'Logo size should not exceed 2MB',
            ]);

            // Handle logo upload
            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->store('school-logos', 'public');
                $validated['logo_path'] = $path;
            }

            $user->schoolProfile()->update($validated);

            return back()->with('success', 'Profile updated successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while updating your profile. Please try again.');
        }
    }

    // Jobs Management
    public function jobs()
    {
        $user = Auth::user();
        $jobs = Available_Job::where('school_id', $user->id)
            ->withCount('applications')
            ->latest()
            ->paginate(10);

        return Inertia::render('School/Jobs/Index', [
            'jobs' => $jobs,
        ]);
    }

    public function createJob()
    {
        $subjects = [
            'mathematics', 'english', 'science', 'social_studies', 'physics', 'chemistry',
            'biology', 'history', 'geography', 'computer_science', 'physical_education',
            'arts', 'music', 'french', 'yoruba', 'igbo', 'hausa', 'other'
        ];

        return Inertia::render('School/Applications/Create', [
            'subjects' => $subjects,
        ]);
    }

    public function storeJob(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'subject' => 'required|string|max:100',
                'level' => 'required|in:nursery,primary,junior_secondary,senior_secondary',
                'class_grade' => 'nullable|string|max:50',
                'state' => 'required|string|max:100',
                'lga' => 'required|string|max:100',
                'employment_type' => 'required|in:full_time,part_time,contract,temporary',
                'salary_range_min' => 'nullable|numeric|min:0',
                'salary_range_max' => 'nullable|numeric|min:0|gt:salary_range_min',
                'application_deadline' => 'required|date|after:today',
            ], [
                'salary_range_max.gt' => 'Maximum salary must be greater than minimum salary',
                'application_deadline.after' => 'Application deadline must be a future date',
            ]);

            $user = Auth::user();

            // Add school_id and ensure job is active by default
            $validated['school_id'] = $user->id;
            $validated['is_active'] = true;

            Available_Job::create($validated);

            return redirect()->route('school.jobs')->with('success', 'Job posted successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('school.jobs.create')
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->route('school.jobs.create')
                ->with('error', 'An error occurred while posting the job. Please try again.');
        }
    }

    public function editJob($id)
    {
        $user = Auth::user();
        $job = Available_Job::where('school_id', $user->id)->findOrFail($id);

        $subjects = [
            'mathematics', 'english', 'science', 'social_studies', 'physics', 'chemistry',
            'biology', 'history', 'geography', 'computer_science', 'physical_education',
            'arts', 'music', 'french', 'yoruba', 'igbo', 'hausa', 'other'
        ];

        return Inertia::render('School/Applications/Edit', [
            'job' => $job,
            'subjects' => $subjects,
        ]);
    }

    public function updateJob(Request $request, $id)
    {
        $user = Auth::user();
        $job = Available_Job::where('school_id', $user->id)->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'subject' => 'required|string|max:100',
            'level' => 'required|in:nursery,primary,junior_secondary,senior_secondary',
            'class_grade' => 'nullable|string|max:50',
            'state' => 'required|string|max:100',
            'lga' => 'required|string|max:100',
            'employment_type' => 'required|in:full_time,part_time,contract,temporary',
            'salary_range_min' => 'nullable|numeric|min:0',
            'salary_range_max' => 'nullable|numeric|min:0|gt:salary_range_min',
            'application_deadline' => 'required|date|after:today',
            'is_active' => 'boolean',
        ]);

        $job->update($validated);

        return redirect()->route('school.jobs')->with('success', 'Job updated successfully!');
    }

    public function deleteJob(Request $request, $id)
    {
        $user = Auth::user();
        $job = Available_Job::where('school_id', $user->id)->findOrFail($id);

        // Check if there are applications
        if ($job->applications()->count() > 0) {
            return back()->with('error', 'Cannot delete job with existing applications.');
        }

        $job->delete();

        return redirect()->route('school.jobs')->with('success', 'Job deleted successfully!');
    }

    // Job Applications Management
    public function applications()
    {
        $user = Auth::user();

        $applications = JobApplication::whereHas('job', function($query) use ($user) {
                $query->where('school_id', $user->id);
            })
            ->with(['job', 'teacher.teacherProfile'])
            ->latest()
            ->paginate(10);

        return Inertia::render('School/Applications/Index', [
            'applications' => $applications,
        ]);
    }

    public function showApplication($id)
    {
        $user = Auth::user();

        $application = JobApplication::whereHas('job', function($query) use ($user) {
                $query->where('school_id', $user->id);
            })
            ->with(['job', 'teacher.teacherProfile'])
            ->findOrFail($id);

        return Inertia::render('School/Applications/Show', [
            'application' => $application,
        ]);
    }

    public function updateApplicationStatus(Request $request, $id)
    {
        $user = Auth::user();

        $application = JobApplication::whereHas('job', function($query) use ($user) {
                $query->where('school_id', $user->id);
            })->findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,reviewed,shortlisted,rejected',
            'feedback' => 'nullable|string|max:1000',
        ]);

        $application->update([
            'status' => $validated['status'],
            'school_feedback' => $validated['feedback'] ?? null,
        ]);

        return back()->with('success', 'Application status updated successfully!');
    }

    // View applied teachers
    public function viewApplicants($jobId)
    {
        $user = Auth::user();

        $job = Available_Job::where('school_id', $user->id)->findOrFail($jobId);
        $applications = $job->applications()
            ->with(['teacher.teacherProfile', 'teacher.appraisals' => function($query) {
                $query->latest()->first();
            }])
            ->paginate(10);

        return Inertia::render('School/Applications/Applicants', [
            'job' => $job,
            'applications' => $applications,
        ]);
    }
}
