<?php
// File: app/Services/PaystackService.php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Payment;
use App\Models\User;

class PaystackService
{
    private $secretKey;
    private $publicKey;
    private $baseUrl = 'https://api.paystack.co';

    public function __construct()
    {
        $this->secretKey = config('services.paystack.secret_key');
        $this->publicKey = config('services.paystack.public_key');

        if (empty($this->secretKey) || empty($this->publicKey)) {
            Log::error('Paystack keys are not configured in services.php');
        }
    }

    /**
     * Initialize a transaction
     */
    public function initializeTransaction(array $data)
    {
        try {
            $response = Http::withToken($this->secretKey)
                ->post($this->baseUrl . '/transaction/initialize', [
                    'email' => $data['email'],
                    'amount' => $data['amount'] * 100, // Convert to kobo
                    'reference' => $data['reference'],
                    'callback_url' => $data['callback_url'],
                    'metadata' => $data['metadata'] ?? [],
                    'currency' => $data['currency'] ?? 'NGN',
                    'channels' => $data['channels'] ?? ['card', 'bank', 'ussd', 'qr', 'mobile_money', 'bank_transfer'],
                ]);

            $result = $response->json();

            if (!$response->successful() || !$result['status']) {
                Log::error('Paystack transaction initialization failed', [
                    'response' => $result,
                    'data' => $data
                ]);
                return [
                    'status' => false,
                    'message' => $result['message'] ?? 'Failed to initialize transaction',
                    'data' => null
                ];
            }

            Log::info('Paystack transaction initialized successfully', [
                'reference' => $data['reference'],
                'authorization_url' => $result['data']['authorization_url']
            ]);

            return [
                'status' => true,
                'message' => 'Transaction initialized successfully',
                'data' => $result['data']
            ];

        } catch (\Exception $e) {
            Log::error('Paystack transaction initialization exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'status' => false,
                'message' => 'Service temporarily unavailable',
                'data' => null
            ];
        }
    }

    /**
     * Verify a transaction
     */
    public function verifyTransaction(string $reference)
    {
        try {
            $response = Http::withToken($this->secretKey)
                ->get($this->baseUrl . '/transaction/verify/' . $reference);

            $result = $response->json();

            if (!$response->successful() || !$result['status']) {
                Log::error('Paystack transaction verification failed', [
                    'reference' => $reference,
                    'response' => $result
                ]);
                return [
                    'status' => false,
                    'message' => $result['message'] ?? 'Transaction verification failed',
                    'data' => null
                ];
            }

            Log::info('Paystack transaction verified', [
                'reference' => $reference,
                'status' => $result['data']['status'],
                'amount' => $result['data']['amount']
            ]);

            return [
                'status' => true,
                'message' => 'Transaction verified',
                'data' => $result['data']
            ];

        } catch (\Exception $e) {
            Log::error('Paystack transaction verification exception', [
                'reference' => $reference,
                'error' => $e->getMessage()
            ]);

            return [
                'status' => false,
                'message' => 'Verification service temporarily unavailable',
                'data' => null
            ];
        }
    }

    /**
     * Create a payment record in database
     */
    public function createPaymentRecord(User $user, string $reference, float $amount, array $metadata = [])
    {
        try {
            $payment = Payment::create([
                'user_id' => $user->id,
                'payment_reference' => $reference,
                'amount' => $amount,
                'currency' => 'NGN',
                'status' => Payment::STATUS_PENDING,
                'metadata' => $metadata,
            ]);

            Log::info('Payment record created', [
                'payment_id' => $payment->id,
                'reference' => $reference,
                'user_id' => $user->id
            ]);

            return $payment;

        } catch (\Exception $e) {
            Log::error('Failed to create payment record', [
                'user_id' => $user->id,
                'reference' => $reference,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Update payment status based on Paystack verification
     */
    public function updatePaymentStatus(Payment $payment, array $verificationData)
    {
        try {
            $paystackStatus = $verificationData['status'];
            $amountPaid = $verificationData['amount'] / 100; // Convert from kobo to Naira

            // Verify amount matches
            if ($amountPaid != $payment->amount) {
                Log::warning('Payment amount mismatch', [
                    'payment_amount' => $payment->amount,
                    'paid_amount' => $amountPaid,
                    'payment_id' => $payment->id
                ]);
            }

            // Map Paystack status to our status
            $statusMap = [
                'success' => Payment::STATUS_SUCCESSFUL,
                'failed' => Payment::STATUS_FAILED,
                'pending' => Payment::STATUS_PENDING,
                'abandoned' => Payment::STATUS_FAILED,
            ];

            $newStatus = $statusMap[$paystackStatus] ?? Payment::STATUS_FAILED;

            $updateData = [
                'status' => $newStatus,
                'gateway_response' => json_encode($verificationData),
            ];

            if ($newStatus === Payment::STATUS_SUCCESSFUL) {
                $updateData['paid_at'] = now();
            }

            $payment->update($updateData);

            Log::info('Payment status updated', [
                'payment_id' => $payment->id,
                'old_status' => $payment->getOriginal('status'),
                'new_status' => $newStatus,
                'paystack_status' => $paystackStatus
            ]);

            return $payment;

        } catch (\Exception $e) {
            Log::error('Failed to update payment status', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Generate a unique reference for transactions
     */
    public function generateReference($prefix = 'TCH')
    {
        return $prefix . '_' . uniqid() . '_' . time();
    }

    /**
     * Complete payment processing for teacher registration
     */
    public function processTeacherRegistrationPayment(User $user, array $options = [])
    {
        $amount = config('app.teacher_registration_fee', 5000);
        $reference = $this->generateReference('TCHREG');
        $callbackUrl = route('teacher.register.payment.callback');

        $metadata = array_merge([
            'user_id' => $user->id,
            'user_email' => $user->email,
            'purpose' => 'teacher_registration',
            'user_type' => 'teacher',
            'registration_step' => 'payment',
        ], $options);

        // Create pending payment record
        $payment = $this->createPaymentRecord($user, $reference, $amount, $metadata);

        if (!$payment) {
            return [
                'status' => false,
                'message' => 'Failed to create payment record',
                'data' => null
            ];
        }

        // Initialize Paystack transaction
        $transactionData = [
            'email' => $user->email,
            'amount' => $amount,
            'reference' => $reference,
            'callback_url' => $callbackUrl,
            'metadata' => $metadata,
            'currency' => 'NGN'
        ];

        $result = $this->initializeTransaction($transactionData);

        if ($result['status'] && $result['data']) {
            // Store payment reference in session for callback verification
            session([
                'payment_reference' => $reference,
                'payment_purpose' => 'teacher_registration'
            ]);

            Log::info('Teacher registration payment initialized', [
                'user_id' => $user->id,
                'reference' => $reference,
                'authorization_url' => $result['data']['authorization_url']
            ]);
        }

        return $result;
    }

    /**
     * Handle payment callback
     */
    public function handleCallback(string $reference)
    {
        // Verify transaction with Paystack
        $verification = $this->verifyTransaction($reference);

        if (!$verification['status'] || !$verification['data']) {
            return [
                'status' => false,
                'message' => $verification['message'],
                'data' => null
            ];
        }

        // Find payment record
        $payment = Payment::where('payment_reference', $reference)->first();

        if (!$payment) {
            Log::error('Payment record not found for reference', ['reference' => $reference]);
            return [
                'status' => false,
                'message' => 'Payment record not found',
                'data' => null
            ];
        }

        // Update payment status
        $updatedPayment = $this->updatePaymentStatus($payment, $verification['data']);

        if (!$updatedPayment) {
            return [
                'status' => false,
                'message' => 'Failed to update payment status',
                'data' => null
            ];
        }

        return [
            'status' => true,
            'message' => 'Payment processed successfully',
            'data' => [
                'payment' => $updatedPayment,
                'verification' => $verification['data']
            ]
        ];
    }

    /**
     * List transactions
     */
    public function listTransactions($perPage = 50, $page = 1, $status = null)
    {
        try {
            $query = http_build_query([
                'perPage' => $perPage,
                'page' => $page,
                'status' => $status
            ]);

            $response = Http::withToken($this->secretKey)
                ->get($this->baseUrl . '/transaction?' . $query);

            return $response->json();

        } catch (\Exception $e) {
            Log::error('Failed to list Paystack transactions', [
                'error' => $e->getMessage()
            ]);
            return ['status' => false, 'message' => 'Failed to fetch transactions'];
        }
    }

    /**
     * Get public key
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    public function processTeacherReappraisalPayment(User $user, array $options = [])
    {
        $amount = config('app.teacher_reappraisal_fee', 2500);
        $reference = $this->generateReference('REAP');
        $callbackUrl = route('teacher.reappraisal.payment.callback');

        $metadata = array_merge([
            'user_id' => $user->id,
            'user_email' => $user->email,
            'purpose' => 'reappraisal',
            'user_type' => 'teacher',
            'process' => 'reappraisal',
        ], $options);

        // Create pending payment record
        $payment = $this->createPaymentRecord($user, $reference, $amount, $metadata);

        if (!$payment) {
            return [
                'status' => false,
                'message' => 'Failed to create payment record',
                'data' => null
            ];
        }

        // Initialize Paystack transaction
        $transactionData = [
            'email' => $user->email,
            'amount' => $amount,
            'reference' => $reference,
            'callback_url' => $callbackUrl,
            'metadata' => $metadata,
            'currency' => 'NGN'
        ];

        $result = $this->initializeTransaction($transactionData);

        if ($result['status'] && $result['data']) {
            // Store payment reference in session (handled by controller)
            Log::info('Teacher reappraisal payment initialized', [
                'user_id' => $user->id,
                'reference' => $reference,
                'authorization_url' => $result['data']['authorization_url']
            ]);
        }

        return $result;
    }
}
