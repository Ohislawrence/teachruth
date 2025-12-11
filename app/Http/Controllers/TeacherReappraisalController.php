<?php
// File: app/Http/Controllers/TeacherReappraisalController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TeacherProfile;
use App\Models\TeacherAppraisal;
use App\Models\Payment;
use App\Models\QualifyingQuestion;
use App\Services\AIApiService;
use App\Services\PaystackService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use App\Mail\TeacherAppraisalMail;

class TeacherReappraisalController extends Controller
{
    protected $aiService;
    protected $paystackService;

    public function __construct(AIApiService $aiService, PaystackService $paystackService)
    {
        $this->aiService = $aiService;
        $this->paystackService = $paystackService;
    }

    /**
     * Show the reappraisal page
     */
    public function show()
    {
        $user = Auth::user();

        // Get the latest appraisal
        $latestAppraisal = TeacherAppraisal::where('teacher_id', $user->id)
            ->latest()
            ->first();

        return Inertia::render('Teacher/Reappraise', [
            'latestAppraisal' => $latestAppraisal,
            'reappraisalFee' => config('app.teacher_reappraisal_fee', 2500),
        ]);
    }

    /**
     * Show the payment page for reappraisal
     */
    public function showPayment()
    {
        $user = Auth::user();

        // Check for existing valid payment
        $hasActivePayment = Payment::where('user_id', $user->id)
            ->where('metadata->purpose', 'reappraisal')
            ->where('status', Payment::STATUS_SUCCESSFUL)
            ->whereDate('created_at', '>=', now()->subHours(24))
            ->exists();

        if ($hasActivePayment) {
            return redirect()->route('teacher.reappraisal.questions');
        }

        return Inertia::render('Teacher/Reappraisal/SimplePayment', [
            'paymentAmount' => config('app.teacher_reappraisal_fee', 2500),
            'publicKey' => $this->paystackService->getPublicKey(),
        ]);
    }

    /**
     * Process reappraisal payment
     */
    public function processPayment(Request $request)
    {
        $user = Auth::user();

        // Check for existing valid payment
        $existingPayment = Payment::where('user_id', $user->id)
            ->where('metadata->purpose', 'reappraisal')
            ->where('status', Payment::STATUS_SUCCESSFUL)
            ->whereDate('created_at', '>=', now()->subHours(24))
            ->first();

        if ($existingPayment) {
            session(['reappraisal_payment_id' => $existingPayment->id]);

            if ($request->expectsJson() || $request->header('X-Inertia') === 'false') {
                return response()->json([
                    'status' => true,
                    'message' => 'Payment already exists',
                    'redirect_url' => route('teacher.reappraisal.questions')
                ]);
            }

            return redirect()->route('teacher.reappraisal.questions');
        }

        // Process payment using Paystack service
        $paymentResult = $this->paystackService->processTeacherReappraisalPayment($user);

        if (!$paymentResult['status']) {
            Log::error('Failed to initialize reappraisal payment', [
                'user_id' => $user->id,
                'error' => $paymentResult['message']
            ]);

            if ($request->expectsJson() || $request->header('X-Inertia') === 'false') {
                return response()->json([
                    'status' => false,
                    'message' => $paymentResult['message'] ?? 'Failed to initialize payment'
                ], 400);
            }

            return back()->with('error', $paymentResult['message'] ?? 'Failed to initialize payment');
        }

        Log::info('Reappraisal payment initialized', [
            'user_id' => $user->id,
            'reference' => $paymentResult['data']['reference'],
            'authorization_url' => $paymentResult['data']['authorization_url']
        ]);

        if ($request->expectsJson() || $request->header('X-Inertia') === 'false') {
            return response()->json([
                'status' => true,
                'message' => 'Payment initialized successfully',
                'data' => [
                    'authorization_url' => $paymentResult['data']['authorization_url'],
                    'reference' => $paymentResult['data']['reference'],
                    'access_code' => $paymentResult['data']['access_code'] ?? null,
                ],
                'public_key' => $this->paystackService->getPublicKey()
            ]);
        }

        // For non-AJAX requests, redirect to Paystack
        return redirect($paymentResult['data']['authorization_url']);
    }

    /**
     * Payment callback handler for reappraisal
     */
    public function paymentCallback(Request $request)
    {
        $reference = $request->query('reference');
        $user = Auth::user();

        if (!$reference) {
            Log::error('No reference in reappraisal payment callback');
            return redirect()->route('teacher.reappraisal.payment')
                ->with('error', 'Invalid payment reference');
        }

        Log::info('Reappraisal payment callback received', [
            'reference' => $reference,
            'user_id' => $user->id
        ]);

        // Handle payment callback using Paystack service
        $callbackResult = $this->paystackService->handleCallback($reference);

        if (!$callbackResult['status']) {
            Log::error('Reappraisal payment callback failed', [
                'reference' => $reference,
                'error' => $callbackResult['message']
            ]);

            return redirect()->route('teacher.reappraisal.payment')
                ->with('error', $callbackResult['message']);
        }

        $payment = $callbackResult['data']['payment'];

        // Check if payment is successful
        if (!$payment->isSuccessful()) {
            Log::warning('Reappraisal payment was not successful', [
                'payment_id' => $payment->id,
                'status' => $payment->status
            ]);

            return redirect()->route('teacher.reappraisal.payment')
                ->with('error', 'Payment was not successful');
        }

        // Store payment ID in session
        session(['reappraisal_payment_id' => $payment->id]);

        Log::info('Reappraisal payment successful, redirecting to questions', [
            'user_id' => $user->id,
            'payment_id' => $payment->id,
            'reference' => $reference
        ]);

        return redirect()->route('teacher.reappraisal.questions');
    }

    /**
     * Simulate payment for testing
     */
    public function simulatePayment(Request $request)
    {
        $user = Auth::user();

        // Create simulated payment record
        $payment = Payment::create([
            'user_id' => $user->id,
            'payment_reference' => 'SIM_' . uniqid() . '_' . time(),
            'amount' => config('app.teacher_reappraisal_fee', 2500),
            'currency' => 'NGN',
            'status' => Payment::STATUS_SUCCESSFUL,
            'metadata' => [
                'purpose' => 'reappraisal',
                'user_id' => $user->id,
                'user_email' => $user->email,
                'simulated' => true,
            ],
            'paid_at' => now(),
        ]);

        // Store payment ID in session
        session(['reappraisal_payment_id' => $payment->id]);

        Log::info('Simulated payment created for reappraisal', [
            'user_id' => $user->id,
            'payment_id' => $payment->id
        ]);

        if ($request->expectsJson() || $request->header('X-Inertia') === 'false') {
            return response()->json([
                'status' => true,
                'message' => 'Simulated payment successful',
                'redirect_url' => route('teacher.reappraisal.questions')
            ]);
        }

        return redirect()->route('teacher.reappraisal.questions');
    }

    /**
     * Show qualifying questions for reappraisal
     */
    public function showQuestions()
    {
        $user = Auth::user();

        // Check if user has a valid payment
        $paymentId = session('reappraisal_payment_id');
        if (!$paymentId) {
            Log::warning('No payment session for reappraisal questions', ['user_id' => $user->id]);
            return redirect()->route('teacher.reappraisal.payment')
                ->with('error', 'Please complete payment first');
        }

        $payment = Payment::where('id', $paymentId)
            ->where('user_id', $user->id)
            ->where('status', Payment::STATUS_SUCCESSFUL)
            ->first();

        if (!$payment) {
            Log::warning('Payment not found or invalid for reappraisal', [
                'user_id' => $user->id,
                'payment_id' => $paymentId
            ]);
            return redirect()->route('teacher.reappraisal.payment')
                ->with('error', 'Payment not found or expired');
        }

        // Check if payment purpose is reappraisal
        $metadata = $payment->metadata ?? [];
        if (!isset($metadata['purpose']) || $metadata['purpose'] !== 'reappraisal') {
            Log::warning('Payment not for reappraisal purpose', [
                'payment_id' => $payment->id,
                'metadata' => $metadata
            ]);
            return redirect()->route('teacher.reappraisal.payment')
                ->with('error', 'Invalid payment purpose');
        }

        // Check if payment was made within last 24 hours
        if ($payment->created_at->diffInHours(now()) > 24) {
            Log::warning('Reappraisal payment expired', [
                'payment_id' => $payment->id,
                'created_at' => $payment->created_at
            ]);
            return redirect()->route('teacher.reappraisal.payment')
                ->with('error', 'Payment has expired. Please make a new payment.');
        }

        $questions = QualifyingQuestion::active()->ordered()->get();

        return Inertia::render('Teacher/Reappraisal/Questions', [
            'questions' => $questions,
            'isReappraisal' => true,
            'payment' => [
                'reference' => $payment->payment_reference,
                'amount' => $payment->amount,
                'paid_at' => $payment->paid_at ? $payment->paid_at->format('Y-m-d H:i:s') : null,
                'metadata' => $payment->metadata
            ]
        ]);
    }

    /**
     * Process reappraisal questions and generate new appraisal
     */
    public function processReappraisal(Request $request)
    {
        $user = Auth::user();

        // Validate payment
        $paymentId = session('reappraisal_payment_id');
        if (!$paymentId) {
            Log::error('No payment session for reappraisal process', ['user_id' => $user->id]);
            return response()->json(['error' => 'Payment session expired'], 400);
        }

        $payment = Payment::where('id', $paymentId)
            ->where('user_id', $user->id)
            ->where('status', Payment::STATUS_SUCCESSFUL)
            ->first();

        if (!$payment) {
            Log::error('Payment not found for reappraisal', [
                'user_id' => $user->id,
                'payment_id' => $paymentId
            ]);
            return response()->json(['error' => 'Payment not found or expired'], 400);
        }

        // Check payment purpose
        $metadata = $payment->metadata ?? [];
        if (!isset($metadata['purpose']) || $metadata['purpose'] !== 'reappraisal') {
            Log::error('Payment not for reappraisal purpose', [
                'payment_id' => $payment->id,
                'metadata' => $metadata
            ]);
            return response()->json(['error' => 'Invalid payment purpose'], 400);
        }

        // Check if payment was made within last 24 hours
        if ($payment->created_at->diffInHours(now()) > 24) {
            Log::error('Reappraisal payment expired', [
                'payment_id' => $payment->id,
                'created_at' => $payment->created_at
            ]);
            return response()->json(['error' => 'Payment has expired'], 400);
        }

        // Validate answers
        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|string',
        ]);

        try {
            // Get or create teacher profile
            $teacherProfile = TeacherProfile::where('user_id', $user->id)->first();
            if (!$teacherProfile) {
                $teacherProfile = TeacherProfile::create([
                    'user_id' => $user->id,
                    'qualifying_answers' => $request->answers,
                ]);
            } else {
                $teacherProfile->qualifying_answers = $request->answers;
                $teacherProfile->save();
            }

            // Get previous appraisals for context
            $previousAppraisals = TeacherAppraisal::where('teacher_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->limit(3)
                ->get()
                ->toArray();

            // Generate AI appraisal
            $appraisalData = $this->aiService->appraiseTeacher([
                'user' => $user,
                'profile' => $teacherProfile,
                'qualifying_answers' => $request->answers,
                'previous_appraisals' => $previousAppraisals,
                'is_reappraisal' => true,
            ]);

            // Convert arrays to strings for database storage
            $strengths = $appraisalData['strengths'];
            $improvementAreas = $appraisalData['improvement_areas'];

            if (is_array($strengths)) {
                $strengths = implode('. ', array_filter($strengths));
            }

            if (is_array($improvementAreas)) {
                $improvementAreas = implode('. ', array_filter($improvementAreas));
            }

            // Create new appraisal record
            $appraisal = TeacherAppraisal::create([
                'teacher_id' => $user->id,
                'overall_score' => $appraisalData['overall_score'],
                'scores_breakdown' => $appraisalData['scores_breakdown'],
                'strengths' => $strengths,
                'improvement_areas' => $improvementAreas,
                'detailed_feedback' => $appraisalData['detailed_feedback'],
                'is_reappraisal' => true,
                'reappraisal_payment_id' => $payment->id,
            ]);

            $appraisal->markAsLatest();

            // Send email notification
            $this->sendReappraisalEmail($user, $appraisal, $appraisalData);

            // Mark payment metadata with usage
            $metadata = $payment->metadata ?? [];
            $metadata['used_at'] = now()->toISOString();
            $metadata['appraisal_id'] = $appraisal->id;
            $payment->update(['metadata' => $metadata]);

            // Clear session data
            session()->forget(['reappraisal_payment_id']);

            Log::info('Reappraisal completed successfully', [
                'user_id' => $user->id,
                'appraisal_id' => $appraisal->id,
                'payment_id' => $payment->id,
                'score' => $appraisal->overall_score
            ]);

            if ($request->expectsJson() || $request->header('X-Inertia') === 'false') {
                return response()->json([
                    'success' => true,
                    'redirect_url' => route('teacher.appraisals.show', $appraisal->id),
                    'appraisal' => [
                        'id' => $appraisal->id,
                        'overall_score' => $appraisal->overall_score,
                        'grade' => $appraisal->grade,
                        'is_reappraisal' => true,
                    ]
                ]);
            }

            return redirect()->route('teacher.appraisals.show', $appraisal->id);

        } catch (\Exception $e) {
            Log::error('Reappraisal process failed', [
                'user_id' => $user->id,
                'payment_id' => $paymentId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->expectsJson() || $request->header('X-Inertia') === 'false') {
                return response()->json([
                    'success' => false,
                    'error' => 'Reappraisal failed. Please try again.',
                ], 500);
            }

            return back()->with('error', 'Reappraisal failed. Please try again.');
        }
    }

    /**
     * Send reappraisal email
     */
    private function sendReappraisalEmail(User $user, TeacherAppraisal $appraisal, $appraisalData)
    {
        try {
            // Prepare competencies array for email
            $competencies = [];
            if (isset($appraisalData['scores_breakdown'])) {
                foreach ($appraisalData['scores_breakdown'] as $key => $competency) {
                    $competencies[] = [
                        'name' => $competency['name'] ?? $this->formatCompetencyName($key),
                        'score' => $competency['score'] ?? 0,
                        'previous_score' => $this->getPreviousCompetencyScore($user->id, $key)
                    ];
                }
            }

            // Prepare strengths array
            $strengths = is_array($appraisalData['strengths'])
                ? $appraisalData['strengths']
                : $this->parseStringToList($appraisalData['strengths']);

            // Prepare improvement areas array
            $improvementAreas = is_array($appraisalData['improvement_areas'])
                ? $appraisalData['improvement_areas']
                : $this->parseStringToList($appraisalData['improvement_areas']);

            // Get previous appraisal for comparison
            $previousAppraisal = TeacherAppraisal::where('teacher_id', $user->id)
                ->where('id', '!=', $appraisal->id)
                ->latest()
                ->first();

            // Send email
            Mail::to($user->email)->send(new TeacherAppraisalMail([
                'teacher_name' => $user->name,
                'overall_score' => $appraisalData['overall_score'],
                'previous_score' => $previousAppraisal ? $previousAppraisal->overall_score : null,
                'grade' => $this->getGradeFromScore($appraisalData['overall_score']),
                'competencies' => $competencies,
                'strengths' => array_slice($strengths, 0, 3),
                'improvement_areas' => array_slice($improvementAreas, 0, 2),
                'feedback_summary' => $this->truncateFeedback($appraisalData['detailed_feedback'], 200),
                'dashboard_url' => route('teacher.dashboard'),
                'appraisal_url' => route('teacher.appraisals.show', $appraisal->id),
                'is_reappraisal' => true,
            ]));

            Log::info('Reappraisal email sent successfully', ['user_id' => $user->id]);

        } catch (\Exception $e) {
            Log::error('Failed to send reappraisal email', [
                'user_id' => $user->id,
                'appraisal_id' => $appraisal->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Get previous competency score for comparison
     */
    private function getPreviousCompetencyScore($userId, $competencyKey)
    {
        $previousAppraisal = TeacherAppraisal::where('teacher_id', $userId)
            ->latest()
            ->skip(1) // Skip current one
            ->first();

        if ($previousAppraisal && isset($previousAppraisal->scores_breakdown[$competencyKey])) {
            return $previousAppraisal->scores_breakdown[$competencyKey]['score'] ?? 0;
        }

        return null;
    }

    /**
     * Format competency name
     */
    private function formatCompetencyName($key)
    {
        $names = [
            'competency_1' => 'Innovative Teaching',
            'competency_2' => 'Assessment & Reporting',
            'competency_3' => 'Self Development',
            'competency_4' => 'Colleague Development',
            'competency_5' => 'School Leadership'
        ];

        return $names[$key] ?? str_replace('_', ' ', $key);
    }

    /**
     * Parse string to list
     */
    private function parseStringToList($text)
    {
        if (!$text) return [];

        if (is_array($text)) return $text;

        $separators = ['. ', '; ', '| ', '• ', '- '];
        foreach ($separators as $sep) {
            if (str_contains($text, $sep)) {
                return array_filter(array_map('trim', explode($sep, $text)));
            }
        }

        return [$text];
    }

    /**
     * Get grade from score
     */
    private function getGradeFromScore($score)
    {
        if ($score >= 90) return 'A+';
        if ($score >= 80) return 'A';
        if ($score >= 70) return 'B';
        if ($score >= 60) return 'C';
        if ($score >= 50) return 'D';
        return 'F';
    }

    /**
     * Truncate feedback
     */
    private function truncateFeedback($text, $length)
    {
        if (strlen($text) <= $length) return $text;
        return substr($text, 0, $length) . '...';
    }

    /**
     * Check payment status
     */
    public function checkPaymentStatus(Request $request)
    {
        $reference = $request->query('reference');
        $user = Auth::user();

        if (!$reference) {
            return response()->json([
                'status' => false,
                'message' => 'No reference provided'
            ], 400);
        }

        // Find payment
        $payment = Payment::where('payment_reference', $reference)
            ->where('user_id', $user->id)
            ->first();

        if (!$payment) {
            return response()->json([
                'status' => false,
                'message' => 'Payment not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => [
                'payment_status' => $payment->status,
                'paid_at' => $payment->paid_at,
                'amount' => $payment->amount,
                'can_proceed' => $payment->isSuccessful() && $payment->created_at->diffInHours(now()) <= 24
            ]
        ]);
    }
}
