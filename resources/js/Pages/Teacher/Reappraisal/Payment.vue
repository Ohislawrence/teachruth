<!-- File: resources/js/Pages/Teacher/Reappraisal/PaymentTest.vue -->
<template>
  <AppLayout title="Reappraisal Payment">
    <div class="min-h-screen bg-gradient-to-b from-emerald-50 via-teal-50 to-white py-12 px-4 sm:px-6 lg:px-8">
      <div class="max-w-3xl mx-auto">
        <!-- Payment Card -->
        <div class="bg-white shadow-2xl rounded-2xl border border-emerald-100 overflow-hidden">
          <div class="px-6 py-8 sm:px-8 sm:py-10">
            <div class="text-center">
              <!-- Payment Icon -->
              <div class="mx-auto w-20 h-20 bg-gradient-to-r from-emerald-100 to-teal-100 rounded-full flex items-center justify-center mb-6">
                <svg class="w-10 h-10 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
              </div>

              <h2 class="text-2xl font-bold text-gray-900">Complete Payment</h2>
              <p class="mt-2 text-lg text-emerald-700 font-medium">
                Pay ₦2,500 for your updated appraisal
              </p>

              <!-- Pricing Card -->
              <div class="mt-6 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl border-2 border-emerald-200 p-6">
                <div class="text-center">
                  <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-emerald-100 text-emerald-800 mb-3">
                    PAYMENT REQUIRED
                  </div>
                  <p class="text-3xl font-bold text-gray-900">₦2,500</p>
                  <p class="text-emerald-600 text-sm mt-1">One-time payment per reappraisal</p>
                </div>
              </div>

              <!-- Simple Payment Button -->
              <div class="mt-8">
                <button
                  @click="processPayment"
                  :disabled="processing"
                  class="w-full max-w-xs mx-auto inline-flex items-center justify-center px-6 py-3.5 border border-transparent text-base font-bold rounded-xl shadow-lg text-white transition disabled:opacity-50 disabled:cursor-not-allowed"
                  :class="processing
                    ? 'bg-emerald-400'
                    : 'bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-emerald-300'"
                >
                  <svg v-if="processing" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  {{ processing ? 'Processing...' : 'Pay ₦2,500 Now' }}
                </button>

                <!-- Alternative: Use Inertia form -->
                <form @submit.prevent="processPaymentForm" class="mt-4">
                  <input type="hidden" name="_token" :value="$page.props.csrf_token">
                  <button
                    type="submit"
                    :disabled="processing"
                    class="w-full max-w-xs mx-auto inline-flex items-center justify-center px-6 py-3.5 border-2 border-emerald-300 text-base font-semibold rounded-xl text-emerald-700 bg-white hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-200 transition disabled:opacity-50"
                  >
                    Test Payment Form
                  </button>
                </form>
              </div>

              <!-- Navigation -->
              <div class="mt-8 pt-6 border-t border-emerald-100">
                <Link
                  :href="route('teacher.reappraisal.index')"
                  class="inline-flex items-center text-sm font-medium text-emerald-700 hover:text-emerald-800 transition"
                >
                  <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                  </svg>
                  Back to Reappraisal
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const processing = ref(false)
const form = useForm({})

const processPayment = async () => {
  processing.value = true

  try {
    // Simple redirect for testing
    router.post(route('teacher.reappraisal.payment.process'), {}, {
      onSuccess: () => {
        router.visit(route('teacher.reappraisal.questions'))
      },
      onError: (errors) => {
        alert('Payment failed. Please try again.')
      },
      onFinish: () => {
        processing.value = false
      }
    })
  } catch (error) {
    console.error('Payment error:', error)
    processing.value = false
  }
}

const processPaymentForm = () => {
  processing.value = true
  // Use Inertia form for CSRF protection
  form.post(route('teacher.reappraisal.payment.process'), {
    onSuccess: () => {
      router.visit(route('teacher.reappraisal.questions'))
    },
    onFinish: () => {
      processing.value = false
    }
  })
}
</script>
