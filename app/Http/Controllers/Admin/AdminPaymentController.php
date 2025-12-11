<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminPaymentController extends Controller
{
    public function payments(Request $request)
    {
        $payments = Payment::with(['user'])
            ->when($request->search, function ($query, $search) {
                $query->where('payment_reference', 'like', "%{$search}%")
                      ->orWhereHas('user', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                      });
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
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
            'total_revenue' => Payment::successful()->sum('amount'),
            'total_payments' => Payment::count(),
            'successful_payments' => Payment::successful()->count(),
            'pending_payments' => Payment::pending()->count(),
            'failed_payments' => Payment::failed()->count(),
            'today_revenue' => Payment::successful()->whereDate('created_at', today())->sum('amount'),
        ];

        return Inertia::render('Admin/Payments/Index', [
            'payments' => $payments,
            'stats' => $stats,
            'filters' => $request->only(['search', 'status', 'date_from', 'date_to']),
        ]);
    }

    public function revenueReport(Request $request)
    {
        $request->validate([
            'year' => 'nullable|integer|min:2020|max:' . date('Y'),
        ]);

        $year = $request->year ?? date('Y');

        // Monthly revenue data
        $monthlyRevenue = Payment::successful()
            ->selectRaw('MONTH(created_at) as month, SUM(amount) as revenue')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('revenue', 'month')
            ->toArray();

        // Fill missing months
        $revenueData = [];
        for ($i = 1; $i <= 12; $i++) {
            $revenueData[] = $monthlyRevenue[$i] ?? 0;
        }

        // Payment methods distribution
        $paymentMethods = Payment::successful()
            ->selectRaw('gateway_response, COUNT(*) as count')
            ->groupBy('gateway_response')
            ->pluck('count', 'gateway_response')
            ->toArray();

        return Inertia::render('Admin/Payments/RevenueReport', [
            'revenueData' => $revenueData,
            'paymentMethods' => $paymentMethods,
            'selectedYear' => $year,
        ]);
    }
}
