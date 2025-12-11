<template>
    <div class="min-h-screen bg-gradient-to-b from-emerald-50 via-teal-50 to-white py-12">
        <div class="max-w-2xl mx-auto">
            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold">
                            1
                        </div>
                        <span class="ml-2 text-sm font-medium text-emerald-700">Account Created</span>
                    </div>
                    <div class="h-1 flex-1 mx-4 bg-emerald-600"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold">
                            2
                        </div>
                        <span class="ml-2 text-sm font-medium text-emerald-700">School Details</span>
                    </div>
                    <div class="h-1 flex-1 mx-4 bg-emerald-600"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold">
                            3
                        </div>
                        <span class="ml-2 text-sm font-medium text-emerald-700">Complete</span>
                    </div>
                </div>
                <p class="text-center text-emerald-600 text-sm">Step 3 of 3: Complete Registration</p>
            </div>

            <div class="bg-white shadow-2xl rounded-2xl border border-emerald-100 overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-8 text-center border-b border-emerald-100">
                    <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900">Registration Complete!</h1>
                    <p class="text-emerald-700 mt-2">Welcome to our platform</p>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Welcome Message -->
                    <div class="bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl p-6 border border-emerald-200">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 p-3 rounded-lg bg-emerald-100">
                                <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-emerald-800">Welcome to Your School Dashboard</h3>
                                <p class="mt-2 text-emerald-700">
                                    Your school account has been successfully created. You can now start posting teaching jobs and connecting with qualified teachers.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Next Steps -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">What You Can Do Next:</h3>

                        <div class="space-y-4">
                            <!-- Step 1 -->
                            <div class="flex items-start p-4 bg-emerald-50 rounded-xl border border-emerald-100">
                                <div class="flex-shrink-0 mt-1">
                                    <div class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold">
                                        1
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="font-semibold text-emerald-800">Complete Your Profile</h4>
                                    <p class="text-sm text-emerald-700 mt-1">
                                        Add your school logo, update contact information, and provide more details about your institution.
                                    </p>
                                </div>
                            </div>

                            <!-- Step 2 -->
                            <div class="flex items-start p-4 bg-emerald-50 rounded-xl border border-emerald-100">
                                <div class="flex-shrink-0 mt-1">
                                    <div class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold">
                                        2
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="font-semibold text-emerald-800">Post Your First Job</h4>
                                    <p class="text-sm text-emerald-700 mt-1">
                                        Create teaching positions for different subjects and grade levels to attract qualified teachers.
                                    </p>
                                </div>
                            </div>

                            <!-- Step 3 -->
                            <div class="flex items-start p-4 bg-emerald-50 rounded-xl border border-emerald-100">
                                <div class="flex-shrink-0 mt-1">
                                    <div class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold">
                                        3
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="font-semibold text-emerald-800">Review Applications</h4>
                                    <p class="text-sm text-emerald-700 mt-1">
                                        Review teacher applications, check their qualifications, and schedule interviews with the best candidates.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Verification Notice -->
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-5">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 p-2 rounded-lg bg-amber-100">
                                <svg class="w-6 h-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-base font-bold text-amber-800">Verification Status</h3>
                                <p class="mt-1 text-sm text-amber-700">
                                    Your account is currently <span class="font-semibold">unverified</span>. You can still post jobs and receive applications.
                                    To become a verified school and gain trust from teachers, please contact our admin team for verification.
                                </p>
                                <div class="mt-3">
                                    <p class="text-xs text-amber-600">
                                        Verified schools receive priority in search results and gain access to premium features.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="pt-6 border-t border-emerald-100">
                        <div class="flex flex-col sm:flex-row gap-4">
                            <button
                                @click="completeRegistration"
                                :disabled="processing"
                                class="flex-1 inline-flex items-center justify-center px-8 py-4 border border-transparent rounded-xl shadow-lg text-white font-bold text-lg transition transform hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-emerald-300"
                                :class="processing
                                    ? 'bg-emerald-400'
                                    : 'bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700'"
                            >
                                {{ processing ? 'Processing...' : 'Go to Dashboard' }}
                                <svg v-if="!processing" class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </button>

                            <Link
                                :href="route('school.register.step2')"
                                class="flex-1 inline-flex items-center justify-center px-8 py-4 border-2 border-emerald-300 text-base font-semibold rounded-xl text-emerald-700 bg-white hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-200 transition"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit Information
                            </Link>
                        </div>
                    </div>

                    <!-- Support Information -->
                    <div class="text-center pt-6">
                        <div class="inline-flex items-center text-sm text-gray-600 bg-gray-50 px-4 py-3 rounded-xl">
                            <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Need help? Contact support at
                            <a href="mailto:support@teachingplatform.com" class="font-semibold text-emerald-600 hover:text-emerald-700 ml-1">
                                support@teachingplatform.com
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, router, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const processing = ref(false)

const form = useForm({})

const completeRegistration = () => {
    processing.value = true
    form.post(route('school.register.complete'), {
        onFinish: () => {
            processing.value = false
        }
    })
}
</script>
