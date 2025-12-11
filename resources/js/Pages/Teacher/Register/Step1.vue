<template>
  <div class="min-h-screen bg-emerald-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <Head>
      <title>Teacher's Registration</title>
    </Head>
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <div class="flex justify-center">
        <svg class="h-12 w-12 text-emerald-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z" fill="currentColor"/>
          <path d="M16 12a4 4 0 11-8 0 4 4 0 018 0z" fill="currentColor"/>
        </svg>
      </div>
      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
        Teacher's Registration
      </h2>
      <p class="mt-2 text-center text-sm text-gray-600">
        Step 1: Create your account
      </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-white py-8 px-6 shadow sm:rounded-xl sm:px-10 border border-emerald-100">
        <!-- Social Login Buttons -->
        <div class="space-y-3">
          <button
            type="button"
            class="w-full inline-flex justify-center items-center px-4 py-2.5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition"
            @click="$inertia.get('/auth/google')"
          >
            <svg class="h-5 w-5 mr-2" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M12.24 10.285V14.4h6.806c-.275 1.765-2.056 5.174-6.806 5.174-4.095 0-7.439-3.389-7.439-7.574s3.344-7.574 7.439-7.574c2.328 0 3.891.911 4.785 1.621l3.29-3.137C18.189 1.207 15.479 0 12.24 0c-6.635 0-12 5.365-12 12s5.365 12 12 12c6.926 0 11.52-4.868 11.52-11.726 0-.788-.085-1.39-.188-1.98H12.24z" fill="#4285F4"/>
            </svg>
            Continue with Google
          </button>

          <button
            type="button"
            class="w-full inline-flex justify-center items-center px-4 py-2.5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition"
            @click="$inertia.get('/auth/apple')"
          >
            <svg class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
              <path d="M17.53 11.515c-.024-.11-.03-.22-.03-.33 0-1.65 1.35-3 3-3 .27 0 .53.035.78.105-.12-.6-.47-1.155-1-1.56-.69-.585-1.59-.93-2.55-.93-2.04 0-3.51 1.305-4.29 2.505-1.05-1.305-2.55-2.505-4.59-2.505-2.07 0-3.39 1.335-3.39 3.345 0 1.065.51 2.13 1.35 2.82-1.365 1.59-2.1 3.75-2.1 6.12 0 1.11.27 2.19.78 3.15.51.96 1.23 1.8 2.13 2.43 1.02.72 2.19 1.08 3.39 1.08 1.515 0 3.015-.675 4.035-1.905.09-.105.165-.225.24-.345.03-.06.06-.105.075-.165.015-.06.03-.12.03-.18 0-.06-.015-.12-.03-.18-.015-.06-.045-.105-.075-.15-.075-.135-.165-.255-.27-.375-.99 1.17-2.295 1.92-3.795 1.92-.915 0-1.785-.33-2.505-.885-.75-.57-1.29-1.365-1.53-2.265.96.105 1.95.165 2.97.165 2.85 0 5.205-1.065 7.035-2.88-2.85-.375-5.04-2.745-5.04-5.595 0-.09.015-.18.015-.27.015-.09 0-.18-.015-.27.015-.045 0-.09 0-.135 0-.285.03-.555.06-.825.81.945 1.89 1.5 3.075 1.5 1.71 0 3.165-1.41 3.165-3.15 0-.225-.03-.435-.075-.645 1.095-.675 1.845-1.83 1.845-3.135-.885.495-1.92.825-3 .825-.3 0-.6-.03-.9-.06z" fill="currentColor"/>
            </svg>
            Continue with Apple
          </button>

          <div class="relative">
            <div class="absolute inset-0 flex items-center">
              <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
              <span class="px-2 bg-white text-gray-500">Or continue with email</span>
            </div>
          </div>
        </div>

        <!-- Email/Password Form -->
        <form @submit.prevent="submitForm" class="mt-8 space-y-6">
          <div class="space-y-5">
            <div>
              <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
              <div class="mt-1">
                <input
                  id="name"
                  v-model="form.name"
                  type="text"
                  required
                  class="appearance-none block w-full px-3 py-2.5 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm"
                  :class="{ 'border-red-300': errors.name }"
                />
                <p v-if="errors.name" class="mt-2 text-sm text-red-600">{{ errors.name }}</p>
              </div>
            </div>

            <div>
              <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
              <div class="mt-1">
                <input
                  id="email"
                  v-model="form.email"
                  type="email"
                  required
                  class="appearance-none block w-full px-3 py-2.5 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm"
                  :class="{ 'border-red-300': errors.email }"
                />
                <p v-if="errors.email" class="mt-2 text-sm text-red-600">{{ errors.email }}</p>
              </div>
            </div>

            <div>
              <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
              <div class="mt-1">
                <input
                  id="password"
                  v-model="form.password"
                  type="password"
                  required
                  class="appearance-none block w-full px-3 py-2.5 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm"
                  :class="{ 'border-red-300': errors.password }"
                />
                <p v-if="errors.password" class="mt-2 text-sm text-red-600">{{ errors.password }}</p>
              </div>
            </div>

            <div>
              <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
              <div class="mt-1">
                <input
                  id="password_confirmation"
                  v-model="form.password_confirmation"
                  type="password"
                  required
                  class="appearance-none block w-full px-3 py-2.5 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm"
                />
              </div>
            </div>

            <div>
              <button
                type="submit"
                :disabled="processing"
                class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 disabled:opacity-50 transition"
              >
                {{ processing ? 'Processing...' : 'Continue to Qualifying Questions' }}
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { Head } from '@inertiajs/vue3'

const processing = ref(false)

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
})

const props = defineProps({
  errors: Object
})

const submitForm = () => {
  processing.value = true
  form.post('/teacher/register', {
    onFinish: () => {
      processing.value = false
    }
  })
}
</script>
