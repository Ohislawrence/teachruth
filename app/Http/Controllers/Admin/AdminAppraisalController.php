<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeacherAppraisal;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminAppraisalController extends Controller
{
    public function appraisals(Request $request)
    {
        $appraisals = TeacherAppraisal::with(['teacher.teacherProfile'])
            ->when($request->search, function ($query, $search) {
                $query->whereHas('teacher', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($request->date_from, function ($query, $date) {
                $query->where('created_at', '>=', $date);
            })
            ->when($request->date_to, function ($query, $date) {
                $query->where('created_at', '<=', $date);
            })
            ->latest()
            ->paginate(15);

        $stats = [
            'total' => TeacherAppraisal::count(),
            'average_score' => round(TeacherAppraisal::avg('overall_score') ?? 0, 2),
            'this_month' => TeacherAppraisal::whereMonth('created_at', now()->month)->count(),
            'last_month' => TeacherAppraisal::whereMonth('created_at', now()->subMonth()->month)->count(),
        ];

        return Inertia::render('Admin/Appraisals/Index', [
            'appraisals' => $appraisals,
            'stats' => $stats,
            'filters' => $request->only(['search', 'date_from', 'date_to']),
        ]);
    }

    public function showAppraisal(TeacherAppraisal $appraisal)
    {
        $appraisal->load(['teacher.teacherProfile']);

        return Inertia::render('Admin/Appraisals/Show', [
            'appraisal' => $appraisal,
        ]);
    }

    public function generateAppraisalReport(Request $request)
    {
        $request->validate([
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
        ]);

        $query = TeacherAppraisal::with(['teacher.teacherProfile']);

        if ($request->date_from) {
            $query->where('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->where('created_at', '<=', $request->date_to);
        }

        $appraisals = $query->get();

        // Generate report data
        $reportData = [
            'total_appraisals' => $appraisals->count(),
            'average_score' => round($appraisals->avg('overall_score') ?? 0, 2),
            'score_distribution' => $this->getScoreDistribution($appraisals),
            'top_teachers' => $this->getTopTeachers($appraisals),
        ];

        return Inertia::render('Admin/Appraisals/Report', [
            'reportData' => $reportData,
            'filters' => $request->only(['date_from', 'date_to']),
        ]);
    }

    private function getScoreDistribution($appraisals)
    {
        return [
            '90-100' => $appraisals->where('overall_score', '>=', 90)->count(),
            '80-89' => $appraisals->whereBetween('overall_score', [80, 89])->count(),
            '70-79' => $appraisals->whereBetween('overall_score', [70, 79])->count(),
            '60-69' => $appraisals->whereBetween('overall_score', [60, 69])->count(),
            'below_60' => $appraisals->where('overall_score', '<', 60)->count(),
        ];
    }

    private function getTopTeachers($appraisals)
    {
        return $appraisals->sortByDesc('overall_score')
            ->take(10)
            ->map(function ($appraisal) {
                return [
                    'teacher_name' => $appraisal->teacher->name,
                    'score' => $appraisal->overall_score,
                    'grade' => $appraisal->grade,
                    'date' => $appraisal->created_at->format('M j, Y'),
                ];
            })
            ->values();
    }
}
