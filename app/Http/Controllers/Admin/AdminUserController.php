<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TeacherProfile;
use App\Models\SchoolProfile;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminUserController extends Controller
{
    public function teachers(Request $request)
    {
        $teachers = User::teachers()
            ->with(['teacherProfile', 'appraisals', 'jobApplications'])
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhereHas('teacherProfile', function ($q) use ($search) {
                          $q->where('qualification', 'like', "%{$search}%")
                            ->orWhere('specialization', 'like', "%{$search}%");
                      });
            })
            ->latest()
            ->paginate(10);

        return Inertia::render('Admin/Teachers/Index', [
            'teachers' => $teachers,
            'filters' => $request->only(['search']),
        ]);
    }

    public function showTeacher(User $user)
    {
        if (!$user->isTeacher()) {
            abort(404);
        }

        $teacher = $user->load([
            'teacherProfile',
            'appraisals' => function ($q) {
                $q->latest();
            },
            'jobApplications.job.school.schoolProfile',
            'payments' => function ($q) {
                $q->latest();
            }
        ]);

        return Inertia::render('Admin/Teachers/Show', [
            'teacher' => $teacher,
        ]);
    }

    public function schools(Request $request)
    {
        $schools = User::schools()
            ->with(['schoolProfile', 'jobs'])
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhereHas('schoolProfile', function ($q) use ($search) {
                          $q->where('school_name', 'like', "%{$search}%")
                            ->orWhere('state', 'like', "%{$search}%");
                      });
            })
            ->latest()
            ->paginate(10);

        return Inertia::render('Admin/Schools/Index', [
            'schools' => $schools,
            'filters' => $request->only(['search']),
        ]);
    }

    public function showSchool(User $user)
    {
        if (!$user->isSchool()) {
            abort(404);
        }

        $school = $user->load([
            'schoolProfile',
            'jobs' => function ($q) {
                $q->withCount('applications')->latest();
            },
            'jobs.applications.teacher.teacherProfile'
        ]);

        return Inertia::render('Admin/Schools/Show', [
            'school' => $school,
        ]);
    }

    public function verifySchool(User $user)
    {
        if (!$user->isSchool()) {
            abort(404);
        }

        $user->schoolProfile()->update(['is_verified' => true]);

        return redirect()->back()->with('success', 'School verified successfully.');
    }

    public function unverifySchool(User $user)
    {
        if (!$user->isSchool()) {
            abort(404);
        }

        $user->schoolProfile()->update(['is_verified' => false]);

        return redirect()->back()->with('success', 'School verification removed.');
    }

    public function suspendUser(User $user)
    {
        $user->update(['suspended_at' => now()]);

        return redirect()->back()->with('success', 'User suspended successfully.');
    }

    public function unsuspendUser(User $user)
    {
        $user->update(['suspended_at' => null]);

        return redirect()->back()->with('success', 'User unsuspended successfully.');
    }
}
