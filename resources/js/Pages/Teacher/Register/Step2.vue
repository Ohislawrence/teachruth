<template>
  <div class="min-h-screen bg-emerald-50 py-12 px-4 sm:px-6 lg:px-8">
    <Head>
      <title>Qualifying Questions</title>
    </Head>
    <div class="max-w-3xl mx-auto">
      <div class="text-center">
        <h2 class="text-3xl font-extrabold text-gray-900">
          Qualifying Questions
        </h2>
        <p class="mt-2 text-lg text-gray-600">
          Step 2: Please answer these questions to help us understand your teaching background
        </p>

        <!-- Progress Bar -->
        <div class="mt-8 max-w-xl mx-auto">
          <div class="flex justify-between text-sm text-gray-600 mb-2">
            <span>Question {{ currentQuestionIndex + 1 }} of {{ questions.length }}</span>
            <span>{{ Math.round(((currentQuestionIndex + 1) / questions.length) * 100) }}% Complete</span>
          </div>
          <div class="w-full bg-gray-200 rounded-full h-2.5">
            <div
              class="bg-emerald-600 h-2.5 rounded-full transition-all duration-300 ease-out"
              :style="{ width: `${((currentQuestionIndex + 1) / questions.length) * 100}%` }"
            ></div>
          </div>
        </div>
      </div>

      <div class="mt-8 bg-white shadow-sm overflow-hidden sm:rounded-xl border border-emerald-100">
        <div class="px-5 py-6 sm:px-6 sm:py-7">
          <form @submit.prevent="submitForm">
            <!-- Current Question -->
            <div class="space-y-6">
              <div class="mb-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-emerald-100 text-emerald-800">
                  Question {{ currentQuestionIndex + 1 }} of {{ questions.length }}
                </span>
              </div>

              <h3 class="text-xl font-semibold text-gray-900 mb-6">
                {{ currentQuestion.question }}
              </h3>

              <!-- Multiple Choice -->
              <div v-if="currentQuestion.type === 'multiple_choice'" class="space-y-3">
                <div
                  v-for="option in currentQuestion.options"
                  :key="option"
                  class="relative flex items-start group"
                >
                  <div class="flex items-center h-5">
                    <input
                      :id="`question-${currentQuestion.id}-${option}`"
                      v-model="form.answers[currentQuestion.id]"
                      :name="`question-${currentQuestion.id}`"
                      type="radio"
                      :value="option"
                      :checked="form.answers[currentQuestion.id] === option"
                      class="focus:ring-emerald-500 h-5 w-5 text-emerald-600 border-gray-300 transition"
                    />
                  </div>
                  <div class="ml-3 text-sm">
                    <label
                      :for="`question-${currentQuestion.id}-${option}`"
                      class="font-medium text-gray-700 cursor-pointer transition hover:text-emerald-700"
                    >
                      {{ option }}
                    </label>
                  </div>
                  <div
                    v-if="form.answers[currentQuestion.id] === option"
                    class="ml-auto text-emerald-600"
                  >
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                  </div>
                </div>
              </div>

              <!-- Boolean (Yes/No) -->
              <div v-else-if="currentQuestion.type === 'boolean'" class="space-y-4">
                <div class="flex flex-col sm:flex-row gap-4">
                  <label
                    :class="[
                      'flex-1 p-4 border-2 rounded-lg cursor-pointer transition-all',
                      form.answers[currentQuestion.id] === 'Yes'
                        ? 'border-emerald-500 bg-emerald-50'
                        : 'border-gray-200 hover:border-emerald-200'
                    ]"
                  >
                    <div class="flex items-center">
                      <input
                        :id="`question-${currentQuestion.id}-yes`"
                        v-model="form.answers[currentQuestion.id]"
                        :name="`question-${currentQuestion.id}`"
                        type="radio"
                        value="Yes"
                        class="sr-only"
                      />
                      <div class="flex items-center justify-center w-6 h-6 mr-3 border-2 rounded-full">
                        <div
                          v-if="form.answers[currentQuestion.id] === 'Yes'"
                          class="w-3 h-3 rounded-full bg-emerald-500"
                        ></div>
                      </div>
                      <span class="text-lg font-medium text-gray-700">Yes</span>
                    </div>
                  </label>

                  <label
                    :class="[
                      'flex-1 p-4 border-2 rounded-lg cursor-pointer transition-all',
                      form.answers[currentQuestion.id] === 'No'
                        ? 'border-emerald-500 bg-emerald-50'
                        : 'border-gray-200 hover:border-emerald-200'
                    ]"
                  >
                    <div class="flex items-center">
                      <input
                        :id="`question-${currentQuestion.id}-no`"
                        v-model="form.answers[currentQuestion.id]"
                        :name="`question-${currentQuestion.id}`"
                        type="radio"
                        value="No"
                        class="sr-only"
                      />
                      <div class="flex items-center justify-center w-6 h-6 mr-3 border-2 rounded-full">
                        <div
                          v-if="form.answers[currentQuestion.id] === 'No'"
                          class="w-3 h-3 rounded-full bg-emerald-500"
                        ></div>
                      </div>
                      <span class="text-lg font-medium text-gray-700">No</span>
                    </div>
                  </label>
                </div>
              </div>

              <!-- Text Area -->
              <div v-else-if="currentQuestion.type === 'text'">
                <div class="mt-1 relative">
                  <textarea
                    v-model="form.answers[currentQuestion.id]"
                    rows="4"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm placeholder:text-gray-400 transition"
                    placeholder="Type your answer here..."
                    @input="autoResizeTextarea"
                  ></textarea>
                  <div class="absolute bottom-2 right-2 text-xs text-gray-400">
                    {{ form.answers[currentQuestion.id]?.length || 0 }} characters
                  </div>
                </div>
              </div>

              <!-- Error Message -->
              <p v-if="errors[`answers.${currentQuestion.id}`]" class="mt-2 text-sm text-red-600">
                {{ errors[`answers.${currentQuestion.id}`] }}
              </p>

              <!-- Answer Status -->
              <div class="pt-4 border-t border-gray-100">
                <div class="flex items-center text-sm text-gray-500">
                  <svg
                    v-if="form.answers[currentQuestion.id]"
                    class="h-5 w-5 text-emerald-500 mr-2"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <span v-if="form.answers[currentQuestion.id]">
                    You've answered this question
                  </span>
                  <span v-else class="text-amber-600">
                    Please answer this question before continuing
                  </span>
                </div>
              </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-between pt-8 mt-6 border-t border-gray-200">
              <div>
                <button
                  v-if="currentQuestionIndex > 0"
                  type="button"
                  @click="goToPrevious"
                  class="inline-flex items-center px-4 py-2.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition"
                >
                  <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                  </svg>
                  Previous
                </button>
                <button
                  v-else
                  type="button"
                  @click="$inertia.visit('/teacher/register')"
                  class="inline-flex items-center px-4 py-2.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition"
                >
                  ← Back to Registration
                </button>
              </div>

              <div>
                <button
                  v-if="currentQuestionIndex < questions.length - 1"
                  type="button"
                  @click="goToNext"
                  :disabled="!form.answers[currentQuestion.id]"
                  :class="[
                    'inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white focus:outline-none focus:ring-2 focus:ring-offset-2 transition',
                    form.answers[currentQuestion.id]
                      ? 'bg-emerald-600 hover:bg-emerald-700 focus:ring-emerald-500'
                      : 'bg-gray-300 cursor-not-allowed'
                  ]"
                >
                  Next Question
                  <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                  </svg>
                </button>
                <button
                  v-else
                  type="submit"
                  :disabled="processing || !form.answers[currentQuestion.id]"
                  :class="[
                    'inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white focus:outline-none focus:ring-2 focus:ring-offset-2 transition',
                    processing
                      ? 'bg-emerald-400 cursor-not-allowed'
                      : form.answers[currentQuestion.id]
                      ? 'bg-emerald-600 hover:bg-emerald-700 focus:ring-emerald-500'
                      : 'bg-gray-300 cursor-not-allowed'
                  ]"
                >
                  {{ processing ? 'Processing...' : 'Complete Registration' }}
                  <svg v-if="!processing" class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                </button>
              </div>
            </div>

            <!-- Question Navigation Dots -->
            <div class="mt-6 pt-4 border-t border-gray-100">
              <div class="flex flex-wrap justify-center gap-2">
                <button
                  v-for="(question, index) in questions"
                  :key="question.id"
                  type="button"
                  @click="goToQuestion(index)"
                  :class="[
                    'w-8 h-8 rounded-full text-sm font-medium transition-all',
                    index === currentQuestionIndex
                      ? 'bg-emerald-600 text-white'
                      : form.answers[question.id]
                      ? 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200'
                      : 'bg-gray-100 text-gray-500 hover:bg-gray-200'
                  ]"
                  :title="`Question ${index + 1}: ${question.question.substring(0, 30)}...`"
                >
                  {{ index + 1 }}
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
import { ref, computed } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { Head } from '@inertiajs/vue3'

const processing = ref(false)
const currentQuestionIndex = ref(0)

const props = defineProps({
  questions: Array,
  errors: Object
})

const form = useForm({
  answers: {}
})

const currentQuestion = computed(() => {
  return props.questions[currentQuestionIndex.value]
})

const goToNext = () => {
  if (form.answers[currentQuestion.value.id]) {
    if (currentQuestionIndex.value < props.questions.length - 1) {
      currentQuestionIndex.value++
      // Scroll to top of question
      window.scrollTo({ top: 0, behavior: 'smooth' })
    }
  }
}

const goToPrevious = () => {
  if (currentQuestionIndex.value > 0) {
    currentQuestionIndex.value--
    // Scroll to top of question
    window.scrollTo({ top: 0, behavior: 'smooth' })
  }
}

const goToQuestion = (index) => {
  // Only allow navigation to answered questions or the next unanswered one
  const answeredQuestions = props.questions.filter(q => form.answers[q.id])
  const lastAnsweredIndex = props.questions.findIndex(q => q.id === answeredQuestions[answeredQuestions.length - 1]?.id)

  if (index <= lastAnsweredIndex + 1) {
    currentQuestionIndex.value = index
    window.scrollTo({ top: 0, behavior: 'smooth' })
  }
}

const autoResizeTextarea = (event) => {
  const textarea = event.target
  textarea.style.height = 'auto'
  textarea.style.height = textarea.scrollHeight + 'px'
}

const submitForm = () => {
  // Validate all questions are answered
  const unansweredQuestions = props.questions.filter(q => !form.answers[q.id])

  if (unansweredQuestions.length > 0) {
    // Go to first unanswered question
    const firstUnansweredIndex = props.questions.findIndex(q => q.id === unansweredQuestions[0].id)
    currentQuestionIndex.value = firstUnansweredIndex
    window.scrollTo({ top: 0, behavior: 'smooth' })
    return
  }

  processing.value = true
  form.post('/teacher/register/qualifying-questions', {
    onFinish: () => {
      processing.value = false
    }
  })
}
</script>
