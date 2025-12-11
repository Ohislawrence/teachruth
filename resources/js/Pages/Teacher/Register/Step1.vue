<template>
  <div class="min-h-screen bg-gradient-to-b from-emerald-50 via-teal-50/30 to-white">
    <!-- Background decorative elements -->
    <div class="absolute inset-0 overflow-hidden">
      <div class="absolute top-1/4 -left-1/4 w-96 h-96 bg-gradient-to-br from-emerald-200/20 to-teal-300/10 rounded-full blur-3xl"></div>
      <div class="absolute bottom-1/4 -right-1/4 w-96 h-96 bg-gradient-to-tr from-teal-200/20 to-emerald-300/10 rounded-full blur-3xl"></div>
    </div>

    <!-- Back to Home link -->
    <div class="absolute top-6 left-6 z-10">
      <button
        @click="$inertia.get(route('welcome'))"
        class="inline-flex items-center text-sm font-medium text-emerald-700 hover:text-emerald-800 group transition-colors"
      >
        <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Back to Home
      </button>
    </div>

    <!-- Progress Indicator -->
    <div class="absolute top-6 right-6 z-10">
      <div class="flex items-center space-x-2">
        <div class="flex items-center">
          <div class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs font-bold">
            1
          </div>
          <div class="ml-2 text-sm font-medium text-emerald-700">Account</div>
        </div>
        <div class="w-8 h-0.5 bg-emerald-200"></div>
        <div class="flex items-center opacity-40">
          <div class="w-6 h-6 rounded-full bg-emerald-200 text-emerald-500 flex items-center justify-center text-xs font-bold">
            2
          </div>
          <div class="ml-2 text-sm font-medium text-emerald-500">Profile</div>
        </div>
        <div class="w-8 h-0.5 bg-emerald-200"></div>
        <div class="flex items-center opacity-40">
          <div class="w-6 h-6 rounded-full bg-emerald-200 text-emerald-500 flex items-center justify-center text-xs font-bold">
            3
          </div>
          <div class="ml-2 text-sm font-medium text-emerald-500">Qualification</div>
        </div>
      </div>
    </div>

    <div class="relative min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
      <div class="w-full max-w-md">
        <!-- Logo and Title -->
        <div class="text-center mb-8">
          <div class="flex justify-center mb-6">
            <div class="relative">

              <div class="absolute -top-1 -right-1 w-4 h-4 bg-gradient-to-r from-emerald-400 to-teal-500 rounded-full animate-pulse"></div>
            </div>
          </div>

          <h2 class="text-3xl font-bold bg-gradient-to-r from-emerald-700 to-teal-800 bg-clip-text text-transparent">
            Join as Teacher
          </h2>
          <p class="mt-2 text-gray-600">
            Step 1: Create your account
          </p>
        </div>

        <!-- Registration Card -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-emerald-100/50 overflow-hidden">
          <!-- Card Header -->
          <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-8 py-6 border-b border-emerald-100">
            <h3 class="text-lg font-semibold text-emerald-800">Create Your Teacher Account</h3>
            <p class="text-sm text-emerald-600 mt-1">Start your journey to better teaching evaluations</p>
          </div>

          <div class="p-8">


            <!-- Email/Password Form -->
            <form @submit.prevent="submitForm" class="mt-8 space-y-6">
              <div class="space-y-5">
                <!-- Full Name -->
                <div class="space-y-2">
                  <label for="name" class="block text-sm font-semibold text-gray-700">Full Name</label>
                  <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <svg class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                      </svg>
                    </div>
                    <input
                      id="name"
                      v-model="form.name"
                      type="text"
                      required
                      placeholder="John Doe"
                      class="pl-10 w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                      :class="{ 'border-red-300': errors.name, 'focus:border-red-500 focus:ring-red-200': errors.name }"
                    />
                  </div>
                  <p v-if="errors.name" class="text-sm text-red-600 mt-1">{{ errors.name }}</p>
                </div>

                <!-- Email Address -->
                <div class="space-y-2">
                  <label for="email" class="block text-sm font-semibold text-gray-700">Email Address</label>
                  <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <svg class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                      </svg>
                    </div>
                    <input
                      id="email"
                      v-model="form.email"
                      type="email"
                      required
                      placeholder="you@example.com"
                      class="pl-10 w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                      :class="{ 'border-red-300': errors.email, 'focus:border-red-500 focus:ring-red-200': errors.email }"
                    />
                  </div>
                  <p v-if="errors.email" class="text-sm text-red-600 mt-1">{{ errors.email }}</p>
                </div>

                <!-- Password -->
                <div class="space-y-2">
                  <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                  <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <svg class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                      </svg>
                    </div>
                    <input
                      id="password"
                      v-model="form.password"
                      type="password"
                      required
                      placeholder="••••••••"
                      class="pl-10 w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                      :class="{ 'border-red-300': errors.password, 'focus:border-red-500 focus:ring-red-200': errors.password }"
                      @input="updatePasswordStrength"
                    />
                  </div>

                  <!-- Password Strength Indicator -->
                  <div v-if="form.password" class="mt-3">
                    <div class="flex justify-between text-xs mb-1">
                      <span class="text-gray-600">Password strength</span>
                      <span class="font-medium" :class="{
                        'text-red-500': passwordStrength < 50,
                        'text-amber-500': passwordStrength >= 50 && passwordStrength < 75,
                        'text-emerald-500': passwordStrength >= 75
                      }">
                        {{ passwordStrength < 50 ? 'Weak' : passwordStrength < 75 ? 'Good' : 'Strong' }}
                      </span>
                    </div>
                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                      <div class="h-full transition-all duration-300" :style="{ width: passwordStrength + '%' }" :class="{
                        'bg-red-400': passwordStrength < 50,
                        'bg-amber-400': passwordStrength >= 50 && passwordStrength < 75,
                        'bg-emerald-500': passwordStrength >= 75
                      }"></div>
                    </div>
                  </div>

                  <p v-if="errors.password" class="text-sm text-red-600 mt-1">{{ errors.password }}</p>
                </div>

                <!-- Confirm Password -->
                <div class="space-y-2">
                  <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">Confirm Password</label>
                  <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <svg class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                      </svg>
                    </div>
                    <input
                      id="password_confirmation"
                      v-model="form.password_confirmation"
                      type="password"
                      required
                      placeholder="••••••••"
                      class="pl-10 w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                    />
                  </div>

                  <!-- Password Match Indicator -->
                  <div v-if="form.password_confirmation" class="mt-2">
                    <div class="flex items-center text-xs" :class="{ 'text-emerald-600': form.password === form.password_confirmation, 'text-red-500': form.password !== form.password_confirmation }">
                      <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="form.password === form.password_confirmation ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12'" />
                      </svg>
                      {{ form.password === form.password_confirmation ? 'Passwords match' : 'Passwords do not match' }}
                    </div>
                  </div>
                </div>

                <!-- Terms and Conditions -->
                <div class="flex items-start mt-4">
                  <div class="flex items-center h-5">
                    <input
                      id="terms"
                      v-model="form.terms"
                      type="checkbox"
                      required
                      class="w-4 h-4 text-emerald-600 border-emerald-300 rounded focus:ring-emerald-500/20"
                    />
                  </div>
                  <div class="ml-3 text-sm">
                    <label for="terms" class="text-gray-600">
                      I agree to the
                      <a :href="route('terms.show')" target="_blank" class="font-medium text-emerald-600 hover:text-emerald-700">Terms of Service</a>
                      and
                      <a :href="route('policy.show')" target="_blank" class="font-medium text-emerald-600 hover:text-emerald-700">Privacy Policy</a>
                    </label>
                    <p v-if="errors.terms" class="text-red-600 mt-1">{{ errors.terms }}</p>
                  </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                  <button
                    type="submit"
                    :disabled="processing || form.password !== form.password_confirmation || !form.terms"
                    class="group relative w-full flex items-center justify-center px-6 py-4 text-base font-bold rounded-xl text-white shadow-lg shadow-emerald-300/50 hover:shadow-xl hover:shadow-emerald-400/50 transition-all duration-300 transform hover:-translate-y-1 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:transform-none"
                    :class="{
                      'from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700': !processing && form.password === form.password_confirmation && form.terms
                    }"
                  >
                    <div v-if="!processing" class="absolute inset-0 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-xl"></div>
                    <div v-if="!processing" class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-teal-700 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <span v-if="!processing" class="relative flex items-center">
                      <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                      </svg>
                      Continue to Next Step
                    </span>
                    <span v-else class="relative flex items-center">
                      <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                      </svg>
                      Creating Account...
                    </span>
                  </button>

                  <p class="text-center text-sm text-gray-500 mt-4">
                    Next: Qualification & Profile Details
                  </p>
                </div>
              </div>
            </form>

            <!-- Already have account -->
            <div class="mt-8 pt-6 border-t border-emerald-100 text-center">
              <p class="text-sm text-gray-600">
                Already have an account?
                <a :href="route('login')" class="font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">
                  Sign in here
                </a>
              </p>
            </div>
          </div>
        </div>

        <!-- Benefits Section -->
        <div class="mt-8 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-2xl p-6 border border-emerald-100">
          <h4 class="text-sm font-semibold text-emerald-800 mb-4">Why Join as a Teacher?</h4>
          <ul class="space-y-3">
            <li class="flex items-start text-sm">
              <svg class="w-5 h-5 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              <span class="text-gray-700">AI-powered teaching appraisals & insights</span>
            </li>
            <li class="flex items-start text-sm">
              <svg class="w-5 h-5 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              <span class="text-gray-700">Access exclusive teaching job opportunities</span>
            </li>
            <li class="flex items-start text-sm">
              <svg class="w-5 h-5 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              <span class="text-gray-700">Track professional growth with data analytics</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'

const processing = ref(false)
const passwordStrength = ref(0)

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  terms: false,
})

const props = defineProps({
  errors: Object
})

const updatePasswordStrength = () => {
  const password = form.password
  let strength = 0

  if (password.length >= 8) strength += 25
  if (/[A-Z]/.test(password)) strength += 25
  if (/[0-9]/.test(password)) strength += 25
  if (/[^A-Za-z0-9]/.test(password)) strength += 25

  passwordStrength.value = strength
}

const submitForm = () => {
  if (!form.terms || form.password !== form.password_confirmation) {
    return
  }

  processing.value = true
  form.post(route('teacher.register.step1'), {
    onFinish: () => {
      processing.value = false
    }
  })
}
</script>

<style scoped>
/* Smooth focus states */
input:focus {
  outline: none;
  ring-width: 2px;
}

/* Custom checkbox styling */
input[type='checkbox']:checked {
  background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/%3e%3c/svg%3e");
  border-color: transparent;
  background-color: currentColor;
  background-size: 100% 100%;
  background-position: center;
  background-repeat: no-repeat;
}
</style>
