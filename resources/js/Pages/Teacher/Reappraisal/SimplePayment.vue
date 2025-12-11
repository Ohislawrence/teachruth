<!-- File: resources/js/Pages/Teacher/Reappraisal/SimplePayment.vue -->
<template>
  <AppLayout title="Reappraisal Payment">
    <div class="min-h-screen bg-emerald-50 py-12 px-4 sm:px-6 lg:px-8">
      <div class="max-w-md mx-auto">
        <!-- Back Button -->
        <div class="mb-6">
          <Link
            :href="route('teacher.reappraisal.index')"
            class="inline-flex items-center text-emerald-700 hover:text-emerald-800"
          >
            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back
          </Link>
        </div>

        <!-- Payment Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-emerald-100 overflow-hidden">
          <!-- Header -->
          <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-8 text-center">
            <div class="w-16 h-16 mx-auto bg-white/20 rounded-full flex items-center justify-center mb-4">
              <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
              </svg>
            </div>
            <h1 class="text-2xl font-bold text-white">Reappraisal Payment</h1>
            <p class="text-emerald-100 mt-2">Get your updated AI-powered appraisal</p>
          </div>

          <!-- Payment Details -->
          <div class="p-6">
            <!-- Amount -->
            <div class="text-center mb-8">
              <div class="text-5xl font-bold text-gray-900">₦2,500</div>
              <p class="text-emerald-600 mt-2">One-time payment for new appraisal</p>
            </div>

            <!-- Features -->
            <div class="space-y-3 mb-8">
              <div class="flex items-center p-3 bg-emerald-50 rounded-lg">
                <svg class="w-5 h-5 text-emerald-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-sm text-gray-700">Updated AI-powered analysis</span>
              </div>
              <div class="flex items-center p-3 bg-emerald-50 rounded-lg">
                <svg class="w-5 h-5 text-emerald-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-sm text-gray-700">Personalized improvement suggestions</span>
              </div>
              <div class="flex items-center p-3 bg-emerald-50 rounded-lg">
                <svg class="w-5 h-5 text-emerald-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-sm text-gray-700">Detailed PDF report</span>
              </div>
            </div>

            <!-- Payment Button -->
            <button
              @click="processPayment"
              :disabled="processing"
              class="w-full py-3.5 px-4 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold rounded-lg shadow-lg transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center"
            >
              <svg v-if="processing" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              <svg v-else class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
              </svg>
              {{ processing ? 'Processing...' : 'Pay ₦2,500 Now' }}
            </button>

            <!-- Test Payment Button (remove in production) -->
            <button
              @click="simulatePayment"
              :disabled="processing"
              class="w-full mt-4 py-3 px-4 border-2 border-emerald-300 text-emerald-700 font-semibold rounded-lg hover:bg-emerald-50 transition disabled:opacity-50"
            >
              Test Payment (Simulate)
            </button>

            <!-- Info -->
            <div class="mt-6 p-4 bg-emerald-50/50 rounded-lg border border-emerald-100">
              <div class="flex items-start">
                <svg class="w-5 h-5 text-emerald-600 mt-0.5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-sm text-emerald-700">
                  After payment, you'll answer updated questions to get your fresh appraisal.
                </p>
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

const processPayment = () => {
  processing.value = true

  // Tell Inertia to handle as a regular form submission, not AJAX
  form.post(route('teacher.reappraisal.payment.process'), {
    preserveScroll: true,
    // Force regular form submission to get proper redirect
    onBefore: () => {
      // Add header to indicate this is not an Inertia AJAX request
      form.transform((data) => ({
        ...data,
        headers: {
          'X-Inertia': 'false'
        }
      }))
    },
    onSuccess: () => {
      // This will handle the redirect from the controller
    },
    onError: (errors) => {
      alert('Payment failed. Please try again.')
      console.error('Payment errors:', errors)
    },
    onFinish: () => {
      processing.value = false
    }
  })
}

// Alternative: Use direct form submission
const processPaymentDirect = () => {
  processing.value = true

  // Create a hidden form and submit it
  const form = document.createElement('form')
  form.method = 'POST'
  form.action = route('teacher.reappraisal.payment.process')
  form.style.display = 'none'

  // Add CSRF token
  const csrfInput = document.createElement('input')
  csrfInput.type = 'hidden'
  csrfInput.name = '_token'
  csrfInput.value = document.querySelector('meta[name="csrf-token"]').content
  form.appendChild(csrfInput)

  // Add header to indicate this is not an Inertia AJAX request
  const inertiaInput = document.createElement('input')
  inertiaInput.type = 'hidden'
  inertiaInput.name = 'headers[X-Inertia]'
  inertiaInput.value = 'false'
  form.appendChild(inertiaInput)

  document.body.appendChild(form)
  form.submit()
}

const simulatePayment = () => {
  processing.value = true
  router.post(route('teacher.reappraisal.payment.simulate'), {}, {
    onFinish: () => {
      processing.value = false
    }
  })
}
</script>
