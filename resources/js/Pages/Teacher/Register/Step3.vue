<template>
  <div class="min-h-screen bg-emerald-50 py-12 px-4 sm:px-6 lg:px-8">
    <Head>
      <title>Professional background</title>
    </Head>
    <div class="max-w-2xl mx-auto">
      <div class="text-center">
        <h2 class="text-3xl font-extrabold text-gray-900">
          Upload Your Resume
        </h2>
        <p class="mt-2 text-lg text-gray-600">
          Step 3: Share your professional background <span class="text-emerald-600">(Optional)</span>
        </p>
      </div>

      <div class="mt-8 bg-white shadow-sm overflow-hidden sm:rounded-xl border border-emerald-100">
        <div class="px-5 py-6 sm:px-6 sm:py-7">
          <form @submit.prevent="submitForm">
            <div class="space-y-7">
              <!-- Resume Upload -->
              <div>
                <label class="block text-sm font-medium text-gray-700">
                  Upload Resume
                </label>
                <div
                  class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed rounded-lg transition-colors"
                  :class="form.resume ? 'border-emerald-400 bg-emerald-50' : 'border-gray-300 hover:border-emerald-300'"
                >
                  <div class="space-y-2 text-center">
                    <svg
                      class="mx-auto h-10 w-10"
                      :class="form.resume ? 'text-emerald-600' : 'text-gray-400'"
                      stroke="currentColor"
                      fill="none"
                      viewBox="0 0 48 48"
                    >
                      <path
                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-1 text-sm text-gray-600">
                      <label
                        for="resume"
                        class="relative cursor-pointer font-medium text-emerald-600 hover:text-emerald-700 focus-within:outline-none focus-within:ring-2 focus-within:ring-emerald-500 focus-within:ring-offset-2"
                      >
                        <span>Upload a file</span>
                        <input
                          id="resume"
                          ref="resumeInput"
                          type="file"
                          class="sr-only"
                          @change="handleFileUpload"
                          accept=".pdf,.doc,.docx"
                        />
                      </label>
                      <p class="hidden sm:block text-gray-500">or</p>
                      <p class="text-gray-500">drag and drop</p>
                    </div>
                    <p class="text-xs text-gray-500">
                      PDF, DOC, DOCX up to 5MB
                    </p>
                  </div>
                </div>

                <div v-if="form.resume" class="mt-3">
                  <p class="text-sm font-medium text-emerald-700 flex items-center">
                    <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Selected: {{ form.resume.name }}
                  </p>
                </div>

                <p v-if="errors.resume" class="mt-2 text-sm text-red-600">
                  {{ errors.resume }}
                </p>
              </div>

              <!-- LinkedIn URL -->
              <div>
                <label for="linkedin_url" class="block text-sm font-medium text-gray-700">
                  LinkedIn Profile URL <span class="text-gray-500">(Optional)</span>
                </label>
                <div class="mt-1.5">
                  <input
                    id="linkedin_url"
                    v-model="form.linkedin_url"
                    type="url"
                    class="w-full px-3 py-2.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm placeholder:text-gray-400"
                    placeholder="https://linkedin.com/in/your-profile"
                    :class="{ 'border-red-300': errors.linkedin_url }"
                  />
                  <p v-if="errors.linkedin_url" class="mt-2 text-sm text-red-600">
                    {{ errors.linkedin_url }}
                  </p>
                </div>
              </div>

              <!-- Navigation Buttons -->
              <div class="flex justify-between pt-4 mt-4">
                <button
                  type="button"
                  @click="$inertia.visit('/teacher/register/qualifying-questions')"
                  class="inline-flex items-center px-4 py-2.5 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition"
                >
                  ← Back
                </button>
                <button
                type="submit"
                :disabled="processing"
                class="inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 disabled:opacity-50 transition"
                >
                {{ processing ? 'Processing...' : 'Continue to Payment' }}
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { Head } from '@inertiajs/vue3'

const processing = ref(false)
const resumeInput = ref(null)

const props = defineProps({
  errors: Object
})

const form = useForm({
  resume: null,
  linkedin_url: '',
})

const handleFileUpload = (event) => {
  form.resume = event.target.files[0]
}

const submitForm = () => {
  processing.value = true
  form.post('/teacher/register/resume', {
    forceFormData: true,
    onFinish: () => {
      processing.value = false
    }
  })
}
</script>
