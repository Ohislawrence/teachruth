<template>
    <AppLayout title="New Appraisal">
        <div class="min-h-screen bg-gradient-to-b from-emerald-50 via-teal-50 to-white">
            <!-- Navigation -->
            <nav class="bg-gradient-to-r from-emerald-600 to-teal-600 shadow-lg">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <div class="flex items-center space-x-3">
                                <Link :href="route('teacher.appraisals')" class="text-white hover:text-emerald-100 transition">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                </Link>
                                <div>
                                    <h1 class="text-xl font-bold text-white">New Teacher Appraisal</h1>
                                    <p class="text-xs text-emerald-100">Get fresh AI-powered insights</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <Link
                                :href="route('teacher.dashboard')"
                                class="text-sm font-medium text-white hover:text-emerald-100 transition"
                            >
                                Dashboard
                            </Link>
                            <Link
                                :href="route('teacher.appraisals')"
                                class="text-sm font-medium text-white hover:text-emerald-100 transition"
                            >
                                My Appraisals
                            </Link>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="py-8">
                <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                    <!-- Main Content Card -->
                    <div class="bg-white shadow-2xl rounded-2xl border border-emerald-100 overflow-hidden mb-8">
                        <div class="px-8 py-8 sm:px-10 sm:py-10">
                            <div class="text-center">
                                <!-- AI Icon -->
                                <div class="mx-auto w-24 h-24 bg-gradient-to-r from-emerald-100 to-teal-100 rounded-full flex items-center justify-center mb-6">
                                    <svg class="w-12 h-12 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                </div>

                                <h2 class="text-3xl font-bold text-gray-900">Get a New Teacher Appraisal</h2>
                                <p class="mt-3 text-xl text-emerald-700 font-medium">
                                    Update your profile and get fresh AI-powered insights
                                </p>

                                <!-- Pricing Card -->
                                <div class="mt-8 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-2xl border-2 border-emerald-200 p-8 max-w-lg mx-auto">
                                    <div class="text-center">
                                        <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-emerald-100 text-emerald-800 mb-3">
                                            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            SPECIAL OFFER
                                        </div>
                                        <p class="text-sm font-medium text-emerald-600">Appraisal Fee</p>
                                        <p class="text-4xl font-bold text-gray-900 mt-2">₦2,500</p>
                                        <p class="text-emerald-600 mt-1 font-medium">One-time payment per appraisal</p>
                                    </div>

                                    <ul class="mt-6 space-y-3">
                                        <li class="flex items-start p-3 bg-white rounded-lg border border-emerald-100">
                                            <div class="flex-shrink-0 mt-0.5">
                                                <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                            <span class="ml-3 text-sm font-medium text-gray-700">
                                                Comprehensive performance analysis across 5 competencies
                                            </span>
                                        </li>
                                        <li class="flex items-start p-3 bg-white rounded-lg border border-emerald-100">
                                            <div class="flex-shrink-0 mt-0.5">
                                                <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                            <span class="ml-3 text-sm font-medium text-gray-700">
                                                Personalized improvement suggestions
                                            </span>
                                        </li>
                                        <li class="flex items-start p-3 bg-white rounded-lg border border-emerald-100">
                                            <div class="flex-shrink-0 mt-0.5">
                                                <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                            <span class="ml-3 text-sm font-medium text-gray-700">
                                                Detailed PDF report with actionable insights
                                            </span>
                                        </li>
                                        <li class="flex items-start p-3 bg-white rounded-lg border border-emerald-100">
                                            <div class="flex-shrink-0 mt-0.5">
                                                <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                            <span class="ml-3 text-sm font-medium text-gray-700">
                                                Track your teaching progress over time
                                            </span>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Action Buttons -->
                                <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                                    <Link
                                        :href="route('teacher.appraisals')"
                                        class="inline-flex items-center justify-center px-6 py-3.5 border-2 border-emerald-300 text-base font-semibold rounded-xl text-emerald-700 bg-white hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-200 transition"
                                    >
                                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Cancel
                                    </Link>
                                    <button
                                        @click="startReappraisal"
                                        :disabled="processing"
                                        class="inline-flex items-center justify-center px-8 py-3.5 border border-transparent text-base font-bold rounded-xl shadow-lg text-white transition transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                                        :class="processing
                                            ? 'bg-emerald-400'
                                            : 'bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-4 focus:ring-emerald-300'"
                                    >
                                        <svg v-if="processing" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <svg v-else class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        {{ processing ? 'Processing...' : 'Proceed to Payment' }}
                                    </button>
                                </div>

                                <!-- Additional Info -->
                                <div class="mt-8 pt-6 border-t border-emerald-100">
                                    <div class="flex items-start justify-center">
                                        <svg class="w-5 h-5 text-emerald-500 mt-0.5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-sm text-emerald-700 max-w-xl">
                                            Your new appraisal will analyze your current profile and qualifications to provide updated insights into your teaching performance and career progression.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Previous Appraisal Summary -->
                    <div v-if="latestAppraisal" class="bg-white shadow-2xl rounded-2xl border border-emerald-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-5 sm:px-8">
                            <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                Your Latest Appraisal
                            </h3>
                            <p class="mt-1 text-sm text-emerald-700">Compare with your previous results</p>
                        </div>

                        <div class="px-6 py-8 sm:px-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                <!-- Overall Score -->
                                <div class="text-center p-5 bg-gradient-to-br from-emerald-50 to-emerald-100/50 rounded-xl border border-emerald-100">
                                    <div class="text-3xl font-bold" :class="scoreColor(latestAppraisal.overall_score)">
                                        {{ latestAppraisal.overall_score }}%
                                    </div>
                                    <div class="text-sm font-medium text-emerald-700 mt-1">Overall Score</div>
                                    <div class="mt-2 text-xs text-emerald-600">Based on 5 competencies</div>
                                </div>

                                <!-- Grade -->
                                <div class="text-center p-5 bg-gradient-to-br from-emerald-50 to-emerald-100/50 rounded-xl border border-emerald-100">
                                    <div class="text-3xl font-bold px-3 py-1.5 rounded-lg inline-block" :class="gradeBackground(latestAppraisal.grade)">
                                        {{ latestAppraisal.grade }}
                                    </div>
                                    <div class="text-sm font-medium text-emerald-700 mt-3">Performance Grade</div>
                                </div>

                                <!-- Date -->
                                <div class="text-center p-5 bg-gradient-to-br from-emerald-50 to-emerald-100/50 rounded-xl border border-emerald-100">
                                    <div class="text-2xl font-bold text-gray-900">
                                        {{ formatDate(latestAppraisal.created_at) }}
                                    </div>
                                    <div class="text-sm font-medium text-emerald-700 mt-1">Appraisal Date</div>
                                    <div class="mt-2 flex items-center justify-center text-xs text-emerald-600">
                                        <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ formatFullDate(latestAppraisal.created_at) }}
                                    </div>
                                </div>

                                <!-- Days Ago -->
                                <div class="text-center p-5 bg-gradient-to-br from-emerald-50 to-emerald-100/50 rounded-xl border border-emerald-100">
                                    <div class="text-3xl font-bold text-gray-900">
                                        {{ daysSinceLastAppraisal }}
                                    </div>
                                    <div class="text-sm font-medium text-emerald-700 mt-1">Days Ago</div>
                                    <div class="mt-2 text-xs" :class="daysSinceLastAppraisal < 30 ? 'text-emerald-600' : 'text-amber-600'">
                                        {{ daysSinceLastAppraisal < 30 ? 'Recent appraisal' : 'Time for an update' }}
                                    </div>
                                </div>
                            </div>

                            <!-- Progress Button -->
                            <div class="mt-8 pt-6 border-t border-emerald-100 text-center">
                                <Link
                                    :href="route('teacher.appraisals.show', latestAppraisal.id)"
                                    class="inline-flex items-center text-sm font-semibold text-emerald-700 hover:text-emerald-800 transition"
                                >
                                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    View Full Previous Appraisal
                                </Link>
                            </div>
                        </div>
                    </div>

                    <!-- Why Update Card -->
                    <div v-if="!latestAppraisal" class="mt-6 bg-gradient-to-r from-emerald-50 to-teal-50 shadow-xl rounded-2xl border border-emerald-100 p-8">
                        <div class="text-center">
                            <div class="w-16 h-16 mx-auto bg-gradient-to-r from-emerald-100 to-teal-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">First Time Appraisal?</h3>
                            <p class="text-emerald-700 mb-6 max-w-md mx-auto">
                                Get your AI-powered teacher appraisal to unlock job opportunities and track your professional growth.
                            </p>
                            <div class="text-left max-w-lg mx-auto space-y-3">
                                <div class="flex items-start p-3 bg-white/50 rounded-lg">
                                    <svg class="w-5 h-5 text-emerald-500 mt-0.5 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-sm text-gray-700">Understand your teaching strengths and areas for improvement</span>
                                </div>
                                <div class="flex items-start p-3 bg-white/50 rounded-lg">
                                    <svg class="w-5 h-5 text-emerald-500 mt-0.5 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-sm text-gray-700">Get matched with relevant teaching opportunities</span>
                                </div>
                                <div class="flex items-start p-3 bg-white/50 rounded-lg">
                                    <svg class="w-5 h-5 text-emerald-500 mt-0.5 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-sm text-gray-700">Track your professional development over time</span>
                                </div>
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
import { ref, computed } from 'vue'

const processing = ref(false)

const props = defineProps({
    latestAppraisal: Object
})

const scoreColor = (score) => {
    if (score >= 90) return 'text-emerald-600'
    if (score >= 80) return 'text-emerald-500'
    if (score >= 70) return 'text-amber-500'
    if (score >= 60) return 'text-orange-500'
    return 'text-red-500'
}

const gradeBackground = (grade) => {
    const backgrounds = {
        'A+': 'bg-gradient-to-r from-emerald-500 to-teal-500 text-white',
        'A': 'bg-gradient-to-r from-emerald-500 to-teal-500 text-white',
        'B': 'bg-gradient-to-r from-amber-500 to-orange-500 text-white',
        'C': 'bg-gradient-to-r from-orange-500 to-red-500 text-white',
        'D': 'bg-gradient-to-r from-red-500 to-red-600 text-white',
        'F': 'bg-gradient-to-r from-red-600 to-red-700 text-white'
    }
    return backgrounds[grade] || 'bg-gray-100 text-gray-800'
}

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric'
    })
}

const formatFullDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    })
}

const daysSinceLastAppraisal = computed(() => {
    if (!props.latestAppraisal) return 'N/A'
    const lastDate = new Date(props.latestAppraisal.created_at)
    const today = new Date()
    const diffTime = Math.abs(today - lastDate)
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24))
    return diffDays
})

const startReappraisal = async () => {
    processing.value = true
    try {
        // Redirect to payment page for reappraisal
        router.visit(route('teacher.reappraisal.payments'))
    } catch (error) {
        console.error('Reappraisal error:', error)
    } finally {
        processing.value = false
    }
}
</script>
