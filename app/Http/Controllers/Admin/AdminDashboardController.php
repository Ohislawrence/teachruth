<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Available_Job;
use App\Models\JobApplication;
use App\Models\TeacherAppraisal;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AdminDashboardController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_teachers' => User::teachers()->count(),
            'total_schools' => User::schools()->count(),
            'total_jobs' => Available_Job::count(),
            'total_applications' => JobApplication::count(),
            'total_appraisals' => TeacherAppraisal::count(),
            'total_revenue' => Payment::successful()->sum('amount'),
            'pending_approvals' => User::schools()->whereHas('schoolProfile', function ($q) {
                $q->where('is_verified', false);
            })->count(),
        ];

        // Recent activities
        $recentActivities = [
            'new_teachers' => User::teachers()->with('teacherProfile')
                ->latest()
                ->take(5)
                ->get(),
            'new_schools' => User::schools()->with('schoolProfile')
                ->latest()
                ->take(5)
                ->get(),
            'recent_jobs' => Available_Job::with('school.schoolProfile')
                ->latest()
                ->take(5)
                ->get(),
            'recent_payments' => Payment::with('user')
                ->latest()
                ->take(5)
                ->get(),
        ];

        // Chart data - Teachers registered per month
        $teacherRegistrations = User::teachers()
            ->select(DB::raw('COUNT(*) as count'), DB::raw('MONTH(created_at) as month'))
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Fill missing months
        $teacherChartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $teacherChartData[] = $teacherRegistrations[$i] ?? 0;
        }

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'recentActivities' => $recentActivities,
            'teacherChartData' => $teacherChartData,
        ]);
    }
}
