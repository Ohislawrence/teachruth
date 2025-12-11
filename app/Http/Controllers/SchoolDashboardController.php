<?php

namespace App\Http\Controllers;

use App\Models\Available_Job;
use App\Models\JobApplication;
use App\Models\SchoolProfile;
use App\Models\TeacherAppraisal;
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

        // Get stats
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

        $jobs = Available_Job::where('school_id', $user->id)
            ->withCount('applications')
            ->latest()
            ->paginate(10);

        return Inertia::render('School/Jobs/Index', [
            'jobs' => $jobs,
            'stats' => $stats, // Ensure this is always set
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
    public function applications(Request $request)
    {
        $user = Auth::user();

        // Get all jobs for the filter dropdown
        $jobs = Available_Job::where('school_id', $user->id)
            ->select('id', 'title')
            ->get();

        // Build query for applications
        $query = JobApplication::whereHas('job', function($query) use ($user) {
                $query->where('school_id', $user->id);
            })
            ->with(['job', 'teacher.teacherProfile']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('job_id')) {
            $query->where('job_id', $request->job_id);
        }

        if ($request->filled('search')) {
            $query->whereHas('teacher', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhereHas('teacherProfile', function($q2) use ($request) {
                    $q2->where('qualification', 'like', '%' . $request->search . '%')
                        ->orWhere('specialization', 'like', '%' . $request->search . '%');
                });
            });
        }

        // Apply sorting
        if ($request->filled('sort')) {
            if ($request->sort === 'oldest') {
                $query->oldest();
            } else {
                $query->latest(); // default to newest
            }
        } else {
            $query->latest(); // default sorting
        }

        $applications = $query->paginate(10);

        return Inertia::render('School/Applications/Index', [
            'applications' => $applications,
            'jobs' => $jobs,
            'filters' => $request->only(['status', 'job_id', 'search', 'sort']),
        ]);
    }

    public function showApplication($id)
    {
        $user = Auth::user();

        $application = JobApplication::whereHas('job', function($query) use ($user) {
                $query->where('school_id', $user->id);
            })
            ->with(['job', 'teacher.teacherProfile', 'teacher.appraisals' => function($query) {
                $query->latest()->take(1); // Get only the latest appraisal
            }])
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

    public function viewAppraisal($teacherId, $appraisalId)
    {
        $user = Auth::user();

        // Verify the appraisal belongs to a teacher who has applied to this school
        $appraisal = TeacherAppraisal::where('id', $appraisalId)
            ->where('teacher_id', $teacherId)
            ->with(['teacher', 'teacher.teacherProfile'])
            ->firstOrFail();

        // Find the application for this teacher
        $application = JobApplication::where('teacher_id', $teacherId)
            ->whereHas('job', function($query) use ($user) {
                $query->where('school_id', $user->id);
            })
            ->first();

        if (!$application) {
            abort(403, 'Unauthorized access to this appraisal.');
        }

        return Inertia::render('School/Appraisals/Show', [
            'appraisal' => $appraisal,
            'teacher' => $appraisal->teacher,
            'application_id' => $application->id // Pass the application ID
        ]);
    }

    public function bulkUpdateApplications(Request $request)
    {
        $request->validate([
            'application_ids' => 'required|array',
            'application_ids.*' => 'exists:job_applications,id',
            'status' => 'required|in:pending,reviewed,shortlisted,rejected',
        ]);

        $user = Auth::user();

        // Verify all applications belong to this school
        JobApplication::whereIn('id', $request->application_ids)
            ->whereHas('job', function($query) use ($user) {
                $query->where('school_id', $user->id);
            })
            ->update(['status' => $request->status]);

        return back()->with('success', 'Applications updated successfully.');
    }

    public function sendBulkEmail(Request $request)
    {
        $request->validate([
            'application_ids' => 'required|array',
            'application_ids.*' => 'exists:job_applications,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $user = Auth::user();

        // Get applications and their teachers
        $applications = JobApplication::whereIn('id', $request->application_ids)
            ->whereHas('job', function($query) use ($user) {
                $query->where('school_id', $user->id);
            })
            ->with('teacher')
            ->get();

        // Send emails (you'll need to implement your email service)
        foreach ($applications as $application) {
            // Send email to $application->teacher->email
            // Mail::to($application->teacher->email)->send(new BulkApplicationEmail($request->subject, $request->message));
        }

        return back()->with('success', 'Emails sent successfully.');
    }

    public function exportApplicants(Request $request, $jobId)
    {
        $user = Auth::user();

        $job = Available_Job::where('school_id', $user->id)->findOrFail($jobId);

        $applications = $job->applications()
            ->with(['teacher.teacherProfile', 'teacher.appraisals' => function($query) {
                $query->latest()->first();
            }])
            ->when($request->search, function($query, $search) {
                $query->whereHas('teacher', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($request->status, function($query, $status) {
                $query->where('status', $status);
            })
            ->get();

        // Return CSV or Excel file
        // You can use Laravel Excel package or generate CSV manually

        return response()->streamDownload(function () use ($applications) {
            $handle = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($handle, ['Name', 'Email', 'Phone', 'Qualification', 'Experience', 'AI Score', 'Status', 'Applied Date']);

            // Add data rows
            foreach ($applications as $application) {
                fputcsv($handle, [
                    $application->teacher->name,
                    $application->teacher->email,
                    $application->teacher->teacherProfile->phone ?? 'N/A',
                    $application->teacher->teacherProfile->qualification ?? 'N/A',
                    $application->teacher->teacherProfile->years_of_experience ?? '0',
                    $application->teacher->appraisals[0]->overall_score ?? 'N/A',
                    $application->status,
                    $application->created_at->format('Y-m-d'),
                ]);
            }

            fclose($handle);
        }, "applicants-{$job->title}-" . now()->format('Y-m-d') . '.csv');
    }
}
