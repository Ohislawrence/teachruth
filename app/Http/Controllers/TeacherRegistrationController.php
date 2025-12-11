<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TeacherProfile;
use App\Models\QualifyingQuestion;
use App\Models\Payment;
use App\Models\TeacherAppraisal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use App\Services\AIApiService;
use App\Mail\TeacherAppraisalMail;

class TeacherRegistrationController extends Controller
{
    protected $aiService;

    public function __construct(AIApiService $aiService)
    {
        $this->aiService = $aiService;
    }

    // Step 1: Show name and email form yes
    public function showStep1()
    {
        return Inertia::render('Teacher/Register/Step1');
    }

    // Store step 1 data
    public function storeStep1(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create user but don't log in yet
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => User::TYPE_TEACHER,
        ]);

        Log::info('Step 1 completed', ['user_id' => $user->id, 'email' => $user->email]);

        // Store user ID in session for subsequent steps
        session(['teacher_registration_user_id' => $user->id]);

        return redirect()->route('teacher.register.step2');
    }

    // Step 2: Show qualifying questions
    public function showStep2()
    {
        $userId = session('teacher_registration_user_id');

        if (!$userId) {
            Log::warning('No user ID in session for step 2');
            return redirect()->route('teacher.register.step1');
        }

        $questions = QualifyingQuestion::active()->ordered()->get();

        return Inertia::render('Teacher/Register/Step2', [
            'questions' => $questions
        ]);
    }

    // Store step 2 data
    public function storeStep2(Request $request)
    {
        $userId = session('teacher_registration_user_id');

        if (!$userId) {
            Log::warning('No user ID in session for step 2 store');
            return redirect()->route('teacher.register.step1');
        }

        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|string',
        ]);

        Log::info('Step 2 completed', [
            'user_id' => $userId,
            'answers_count' => count($request->answers)
        ]);

        // Store answers in session for later use
        session(['teacher_qualifying_answers' => $request->answers]);

        return redirect()->route('teacher.register.step3');
    }

    // Step 3: Show resume/LinkedIn upload form
    public function showStep3()
    {
        $userId = session('teacher_registration_user_id');

        if (!$userId) {
            Log::warning('No user ID in session for step 3');
            return redirect()->route('teacher.register.step1');
        }

        return Inertia::render('Teacher/Register/Step3');
    }

    // Store step 3 data
    public function storeStep3(Request $request)
    {
        $userId = session('teacher_registration_user_id');

        if (!$userId) {
            Log::warning('No user ID in session for step 3 store');
            return redirect()->route('teacher.register.step1');
        }

        $request->validate([
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'linkedin_url' => 'nullable|url',
        ]);

        $resumePath = null;
        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes', 'public');
            Log::info('Resume uploaded', ['user_id' => $userId, 'path' => $resumePath]);
        }

        // Store in session for final creation
        session([
            'teacher_resume_path' => $resumePath,
            'teacher_linkedin_url' => $request->linkedin_url,
        ]);

        Log::info('Step 3 completed', [
            'user_id' => $userId,
            'has_resume' => !is_null($resumePath),
            'has_linkedin' => !empty($request->linkedin_url)
        ]);

        // Uncomment this line to enable payment step
        return redirect()->route('teacher.register.step4');

        // Comment this out when payment is enabled
        // return redirect()->route('teacher.register.step5');
    }

    // Step 4: Show payment form
    public function showStep4()
    {
        $userId = session('teacher_registration_user_id');

        if (!$userId) {
            Log::warning('No user ID in session for step 4');
            return redirect()->route('teacher.register.step1');
        }

        Log::info('Showing payment step', ['user_id' => $userId]);

        return Inertia::render('Teacher/Register/Step4', [
            'paymentAmount' => config('app.teacher_registration_fee', 5000), // 5000 Naira default
        ]);
    }


    // Process payment
    public function processPayment(Request $request)
    {
        $userId = session('teacher_registration_user_id');

        if (!$userId) {
            Log::error('No user ID in session for payment');
            return response()->json(['error' => 'Session expired'], 400);
        }

        $user = User::find($userId);
        if (!$user) {
            Log::error('User not found for payment', ['user_id' => $userId]);
            return response()->json(['error' => 'User not found'], 400);
        }

        Log::info('Processing payment', ['user_id' => $userId, 'email' => $user->email]);

        // Initialize Paystack payment
        // This would integrate with Paystack API
        $paymentData = [
            'amount' => config('app.teacher_registration_fee', 5000) * 100, // Convert to kobo
            'email' => $user->email,
            'reference' => 'TCH_' . uniqid() . '_' . time(),
            'callback_url' => route('teacher.register.payment.callback'),
            'metadata' => [
                'user_id' => $userId,
                'purpose' => 'teacher_registration'
            ]
        ];

        // Store payment reference in session
        session(['payment_reference' => $paymentData['reference']]);

        Log::info('Payment initialized', [
            'user_id' => $userId,
            'reference' => $paymentData['reference'],
            'amount' => $paymentData['amount']
        ]);

        // Return payment data for frontend to initialize Paystack
        // For now, simulate successful payment for testing
        return response()->json([
            'status' => true,
            'message' => 'Payment initialized',
            'data' => [
                'authorization_url' => route('teacher.register.step5'), // Simulate direct to step 5
                'reference' => $paymentData['reference']
            ],
            'public_key' => config('services.paystack.public_key', 'test_key')
        ]);
    }

    // Payment callback handler
    public function paymentCallback(Request $request)
    {
        $reference = $request->query('reference');
        $userId = session('teacher_registration_user_id');

        if (!$reference || !$userId) {
            Log::error('Invalid payment callback', [
                'reference' => $reference,
                'user_id' => $userId
            ]);
            return redirect()->route('teacher.register.step1')->with('error', 'Invalid payment callback');
        }

        // Verify payment with Paystack
        $paymentVerified = $this->verifyPaystackPayment($reference);

        if ($paymentVerified) {
            // Create payment record
            Payment::create([
                'user_id' => $userId,
                'payment_reference' => $reference,
                'amount' => config('app.teacher_registration_fee', 5000),
                'status' => Payment::STATUS_SUCCESSFUL,
                'paid_at' => now(),
            ]);

            Log::info('Payment verified successfully', [
                'user_id' => $userId,
                'reference' => $reference
            ]);

            return redirect()->route('teacher.register.step5');
        }

        Log::error('Payment verification failed', [
            'user_id' => $userId,
            'reference' => $reference
        ]);

        return redirect()->route('teacher.register.step4')->with('error', 'Payment verification failed');
    }

    // Step 5: Show appraisal in progress
    public function showStep5()
    {
        $userId = session('teacher_registration_user_id');

        if (!$userId) {
            Log::warning('No user ID in session for step 5');
            return redirect()->route('teacher.register.step1');
        }

        $user = User::find($userId);
        if (!$user) {
            Log::error('User not found for step 5', ['user_id' => $userId]);
            return redirect()->route('teacher.register.step1');
        }

        Log::info('Showing appraisal step', [
            'user_id' => $userId,
            'has_answers' => !empty(session('teacher_qualifying_answers')),
            'has_resume' => !empty(session('teacher_resume_path'))
        ]);

        return Inertia::render('Teacher/Register/Step5');
    }

    // Process appraisal and complete registration
    public function completeRegistration(Request $request)
    {
        $userId = session('teacher_registration_user_id');

        if (!$userId) {
            Log::error('No user ID in session for complete registration');
            return response()->json(['error' => 'Session expired'], 400);
        }

        $user = User::find($userId);
        if (!$user) {
            Log::error('User not found for complete registration', ['user_id' => $userId]);
            return response()->json(['error' => 'User not found'], 400);
        }

        Log::info('Starting complete registration', [
            'user_id' => $userId,
            'name' => $user->name,
            'session_data' => [
                'has_answers' => !empty(session('teacher_qualifying_answers')),
                'has_resume' => !empty(session('teacher_resume_path')),
                'has_linkedin' => !empty(session('teacher_linkedin_url'))
            ]
        ]);

        try {
            // Create teacher profile with all collected data
            $teacherProfile = TeacherProfile::create([
                'user_id' => $userId,
                'qualifying_answers' => session('teacher_qualifying_answers'),
                'resume_path' => session('teacher_resume_path'),
                'linkedin_url' => session('teacher_linkedin_url'),
            ]);

            Log::info('Teacher profile created', [
                'profile_id' => $teacherProfile->id,
                'user_id' => $userId
            ]);

            // Generate AI appraisal
            Log::info('Calling AI service for appraisal...');
            $appraisalData = $this->aiService->appraiseTeacher([
                'user' => $user,
                'profile' => $teacherProfile,
                'qualifying_answers' => $teacherProfile->qualifying_answers
            ]);

            Log::info('AI appraisal generated', [
                'overall_score' => $appraisalData['overall_score'],
                'strengths_type' => gettype($appraisalData['strengths']),
                'improvement_areas_type' => gettype($appraisalData['improvement_areas']),
                'user_id' => $userId
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

            // Create appraisal record
            $appraisal = TeacherAppraisal::create([
                'teacher_id' => $user->id,
                'overall_score' => $appraisalData['overall_score'],
                'scores_breakdown' => $appraisalData['scores_breakdown'],
                'strengths' => $strengths,
                'improvement_areas' => $improvementAreas,
                'detailed_feedback' => $appraisalData['detailed_feedback'],
            ]);

            $appraisal->markAsLatest();

            $this->sendAppraisalEmail($user, $appraisal, $appraisalData);

            Log::info('Appraisal saved to database', [
                'appraisal_id' => $appraisal->id,
                'teacher_id' => $user->id,
                'score' => $appraisal->overall_score,
                'strengths_length' => strlen($strengths),
                'improvement_areas_length' => strlen($improvementAreas)
            ]);

            // Log in the user
            Auth::login($user);

            Log::info('User logged in', ['user_id' => $userId]);

            // Clear session data
            session()->forget([
                'teacher_registration_user_id',
                'teacher_qualifying_answers',
                'teacher_resume_path',
                'teacher_linkedin_url',
                'payment_reference'
            ]);

            Log::info('Registration completed successfully', [
                'user_id' => $userId,
                'redirecting_to' => route('teacher.dashboard')
            ]);

            return response()->json([
                'success' => true,
                'redirect_url' => route('teacher.dashboard'),
                'appraisal' => [
                    'id' => $appraisal->id,
                    'overall_score' => $appraisal->overall_score,
                    'grade' => $appraisal->grade,
                    'strengths' => $appraisal->strengths,
                    'improvement_areas' => $appraisal->improvement_areas,
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Registration completion failed', [
                'user_id' => $userId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Registration failed. Please try again.',
                'debug_error' => app()->environment('local') ? $e->getMessage() : null
            ], 500);
        }

    }

    private function sendAppraisalEmail(User $user, TeacherAppraisal $appraisal, $appraisalData)
    {
        try {
            // Prepare competencies array for email
            $competencies = [];
            if (isset($appraisalData['scores_breakdown'])) {
                foreach ($appraisalData['scores_breakdown'] as $key => $competency) {
                    $competencies[] = [
                        'name' => $competency['name'] ?? $this->formatCompetencyName($key),
                        'score' => $competency['score'] ?? 0
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

            // Send email
            Mail::to($user->email)->send(new TeacherAppraisalMail([
                'teacher_name' => $user->name,
                'overall_score' => $appraisalData['overall_score'],
                'grade' => $this->getGradeFromScore($appraisalData['overall_score']),
                'competencies' => $competencies,
                'strengths' => array_slice($strengths, 0, 3), // Send top 3 strengths
                'improvement_areas' => array_slice($improvementAreas, 0, 2), // Send top 2 improvement areas
                'feedback_summary' => $this->truncateFeedback($appraisalData['detailed_feedback'], 200),
                'dashboard_url' => route('teacher.dashboard'),
            ]));

            Log::info('Appraisal email sent successfully', ['user_id' => $user->id]);

        } catch (\Exception $e) {
            Log::error('Failed to send appraisal email', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
        }
    }

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

    private function getGradeFromScore($score)
    {
        if ($score >= 90) return 'A+';
        if ($score >= 80) return 'A';
        if ($score >= 70) return 'B';
        if ($score >= 60) return 'C';
        if ($score >= 50) return 'D';
        return 'F';
    }

    private function truncateFeedback($text, $length)
    {
        if (strlen($text) <= $length) return $text;
        return substr($text, 0, $length) . '...';
    }


    // Helper method to verify Paystack payment
    private function verifyPaystackPayment($reference)
    {
        // For testing/demo purposes, always return true
        // In production, implement actual Paystack verification
        Log::info('Verifying payment (simulated)', ['reference' => $reference]);
        return true;
    }
}
