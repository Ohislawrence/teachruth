<?php
// File: app/Http/Controllers/PaystackWebhookController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\PaystackService;
use App\Models\Payment;

class PaystackWebhookController extends Controller
{
    protected $paystackService;

    public function __construct(PaystackService $paystackService)
    {
        $this->paystackService = $paystackService;
    }

    /**
     * Handle Paystack webhook events
     */
    public function handleWebhook(Request $request)
    {
        Log::info('Paystack webhook received', [
            'event' => $request->event,
            'data' => $request->data
        ]);

        // Verify the request is from Paystack by checking the IP
        $ip = $request->ip();
        $allowedIps = ['52.31.139.75', '52.49.173.169', '52.214.14.220']; // Paystack IPs

        if (!in_array($ip, $allowedIps)) {
            Log::warning('Unauthorized webhook request from IP: ' . $ip);
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Verify the event
        $signature = $request->header('x-paystack-signature');
        $payload = $request->getContent();

        if (!$this->verifySignature($signature, $payload)) {
            Log::warning('Invalid webhook signature');
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        $event = $request->event;
        $data = $request->data;

        switch ($event) {
            case 'charge.success':
                return $this->handleChargeSuccess($data);

            case 'charge.failed':
                return $this->handleChargeFailed($data);

            case 'transfer.success':
                return $this->handleTransferSuccess($data);

            case 'transfer.failed':
                return $this->handleTransferFailed($data);

            default:
                Log::info('Unhandled webhook event', ['event' => $event]);
                return response()->json(['status' => 'ignored']);
        }
    }

    /**
     * Handle successful charge
     */
    private function handleChargeSuccess($data)
    {
        $reference = $data['reference'];

        Log::info('Processing charge.success webhook', ['reference' => $reference]);

        // Verify the transaction
        $verification = $this->paystackService->verifyTransaction($reference);

        if ($verification['status'] && $verification['data']) {
            // Find and update payment
            $payment = Payment::where('payment_reference', $reference)->first();

            if ($payment) {
                $this->paystackService->updatePaymentStatus($payment, $verification['data']);

                // Trigger any post-payment actions here
                // Example: Send email, update user status, etc.

                Log::info('Webhook processed successfully', [
                    'payment_id' => $payment->id,
                    'reference' => $reference
                ]);
            } else {
                Log::warning('Payment not found for webhook reference', ['reference' => $reference]);
            }
        }

        return response()->json(['status' => 'processed']);
    }

    /**
     * Handle failed charge
     */
    private function handleChargeFailed($data)
    {
        $reference = $data['reference'];

        Log::info('Processing charge.failed webhook', ['reference' => $reference]);

        $payment = Payment::where('payment_reference', $reference)->first();

        if ($payment) {
            $payment->markAsFailed(json_encode($data));

            Log::info('Payment marked as failed via webhook', [
                'payment_id' => $payment->id,
                'reference' => $reference
            ]);
        }

        return response()->json(['status' => 'processed']);
    }

    /**
     * Verify Paystack webhook signature
     */
    private function verifySignature($signature, $payload)
    {
        $secret = config('services.paystack.secret_key');
        $hash = hash_hmac('sha512', $payload, $secret);

        return hash_equals($hash, $signature);
    }

    /**
     * Handle successful transfer (if you implement transfers later)
     */
    private function handleTransferSuccess($data)
    {
        Log::info('Transfer successful webhook', ['data' => $data]);
        // Implement transfer success logic
        return response()->json(['status' => 'processed']);
    }

    /**
     * Handle failed transfer (if you implement transfers later)
     */
    private function handleTransferFailed($data)
    {
        Log::info('Transfer failed webhook', ['data' => $data]);
        // Implement transfer failure logic
        return response()->json(['status' => 'processed']);
    }
}
