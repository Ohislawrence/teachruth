<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

// Animation state
const loaded = ref(false);
onMounted(() => {
    setTimeout(() => {
        loaded.value = true;
    }, 100);
});
</script>

<template>
    <Head title="Join Teachergauge - Register as Teacher or School" />

    <div class="min-h-screen bg-gradient-to-br from-emerald-50 via-teal-50/30 to-white">
        <!-- Background decorative elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-1/4 -left-1/4 w-96 h-96 bg-gradient-to-br from-emerald-200/20 to-teal-300/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-1/4 -right-1/4 w-96 h-96 bg-gradient-to-tr from-teal-200/20 to-emerald-300/10 rounded-full blur-3xl"></div>
        </div>

        <!-- Back to Home link -->
        <div class="absolute top-6 left-6 z-10">
            <Link
                :href="route('welcome')"
                class="inline-flex items-center text-sm font-medium text-emerald-700 hover:text-emerald-800 group transition-colors"
            >
                <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Home
            </Link>
        </div>

        <div class="relative min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="w-full max-w-4xl">
                <!-- Logo and Title -->
                <div class="text-center mb-12" :class="{ 'animate-fade-in-up': loaded }">
                    <div class="flex justify-center mb-6">
                        <div class="relative">

                            <div class="absolute -top-2 -right-2 w-5 h-5 bg-gradient-to-r from-emerald-400 to-teal-500 rounded-full animate-pulse"></div>
                        </div>
                    </div>

                    <h1 class="text-4xl font-bold bg-gradient-to-r from-emerald-700 to-teal-800 bg-clip-text text-transparent">
                        Join Teachergauge
                    </h1>
                    <p class="mt-4 text-xl text-gray-600 max-w-2xl mx-auto">
                        Transform teaching with AI-powered appraisals. Choose how you want to join our community.
                    </p>
                </div>

                <!-- Registration Options -->
                <div class="grid md:grid-cols-2 gap-8" :class="{ 'animate-fade-in-up': loaded }">
                    <!-- Teacher Registration Card -->
                    <div class="group relative">
                        <div class="absolute -inset-1 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-3xl blur opacity-30 group-hover:opacity-50 transition duration-500"></div>
                        <div class="relative bg-white rounded-2xl shadow-xl border border-emerald-100/50 overflow-hidden">
                            <!-- Card Header -->
                            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-8 py-6 border-b border-emerald-100">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="flex items-center space-x-3">
                                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="text-2xl font-bold text-gray-900">For Teachers</h3>
                                                <p class="text-sm text-emerald-600 font-medium">Educator & Tutor Registration</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hidden sm:block">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-emerald-100 text-emerald-800">
                                            Popular
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="p-8">
                                <div class="mb-8">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Why Join as a Teacher?</h4>
                                    <ul class="space-y-3">
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-emerald-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span class="text-gray-600">AI-powered teaching appraisals & insights</span>
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-emerald-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span class="text-gray-600">Access exclusive teaching job opportunities</span>
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-emerald-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span class="text-gray-600">Track professional growth with data analytics</span>
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-emerald-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span class="text-gray-600">Build a verified professional profile</span>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Stats -->
                                <div class="bg-emerald-50 rounded-xl p-4 mb-8">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="text-center">
                                            <div class="text-2xl font-bold text-emerald-700">500+</div>
                                            <div class="text-xs text-emerald-600">Active Teachers</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-2xl font-bold text-emerald-700">4.8</div>
                                            <div class="text-xs text-emerald-600">Avg. Rating</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Teacher Registration Button -->
                                <Link
                                    :href="route('teacher.register.step1')"
                                    class="group relative w-full flex items-center justify-center px-8 py-4 text-base font-bold rounded-xl text-white shadow-lg shadow-emerald-300/50 hover:shadow-xl hover:shadow-emerald-400/50 transition-all duration-300 transform hover:-translate-y-1"
                                >
                                    <div class="absolute inset-0 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-xl"></div>
                                    <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-teal-700 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    <span class="relative flex items-center">
                                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                        </svg>
                                        Register as Teacher
                                    </span>
                                </Link>

                                <p class="text-center text-sm text-gray-500 mt-4">
                                    Join 500+ educators already transforming their careers
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- School Registration Card -->
                    <div class="group relative">
                        <div class="absolute -inset-1 bg-gradient-to-r from-teal-600 to-emerald-700 rounded-3xl blur opacity-30 group-hover:opacity-50 transition duration-500"></div>
                        <div class="relative bg-white rounded-2xl shadow-xl border border-emerald-100/50 overflow-hidden">
                            <!-- Card Header -->
                            <div class="bg-gradient-to-r from-teal-50 to-emerald-50 px-8 py-6 border-b border-emerald-100">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-teal-600 to-emerald-700 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-bold text-gray-900">For Schools</h3>
                                        <p class="text-sm text-teal-600 font-medium">Educational Institution Registration</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="p-8">
                                <div class="mb-8">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Why Join as a School?</h4>
                                    <ul class="space-y-3">
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-teal-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span class="text-gray-600">AI-powered teacher evaluation & hiring</span>
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-teal-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span class="text-gray-600">Access verified, pre-screened teaching talent</span>
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-teal-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span class="text-gray-600">Data-driven insights for staffing decisions</span>
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-teal-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span class="text-gray-600">Streamlined recruitment and appraisal process</span>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Stats -->
                                <div class="bg-teal-50 rounded-xl p-4 mb-8">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="text-center">
                                            <div class="text-2xl font-bold text-teal-700">120+</div>
                                            <div class="text-xs text-teal-600">Partner Schools</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-2xl font-bold text-teal-700">95%</div>
                                            <div class="text-xs text-teal-600">Satisfaction Rate</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- School Registration Button -->
                                <Link
                                    :href="route('school.register.step1')"
                                    class="group relative w-full flex items-center justify-center px-8 py-4 text-base font-bold rounded-xl text-white shadow-lg shadow-teal-300/50 hover:shadow-xl hover:shadow-teal-400/50 transition-all duration-300 transform hover:-translate-y-1"
                                >
                                    <div class="absolute inset-0 bg-gradient-to-r from-teal-600 to-emerald-700 rounded-xl"></div>
                                    <div class="absolute inset-0 bg-gradient-to-r from-teal-700 to-emerald-800 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    <span class="relative flex items-center">
                                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        Register as School
                                    </span>
                                </Link>

                                <p class="text-center text-sm text-gray-500 mt-4">
                                    Join 120+ schools already finding exceptional teachers
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Already have an account -->
                <div class="mt-12 text-center" :class="{ 'animate-fade-in-up': loaded }">
                    <p class="text-gray-600">
                        Already have an account?
                        <Link :href="route('login')" class="font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">
                            Sign in here
                        </Link>
                    </p>
                    <p class="mt-4 text-sm text-gray-500">
                        By registering, you agree to our
                        <Link :href="route('terms.show')" class="text-emerald-600 hover:text-emerald-700 font-medium">Terms</Link>
                        and
                        <Link :href="route('policy.show')" class="text-emerald-600 hover:text-emerald-700 font-medium">Privacy Policy</Link>
                    </p>
                </div>

                <!-- Testimonials Section -->
                <div class="mt-16 grid md:grid-cols-2 gap-8" :class="{ 'animate-fade-in-up': loaded }">
                    <!-- Teacher Testimonial -->
                    <div class="bg-gradient-to-br from-emerald-50 to-white rounded-2xl p-6 border border-emerald-100">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-r from-emerald-400 to-teal-500"></div>
                            <div class="ml-4">
                                <h4 class="font-semibold text-gray-900">Sarah Johnson</h4>
                                <p class="text-sm text-gray-600">High School Math Teacher</p>
                            </div>
                        </div>
                        <p class="text-gray-700 italic">
                            "Teachergauge's AI insights helped me identify areas for improvement I never noticed. My appraisal score increased by 25% in just 3 months!"
                        </p>
                        <div class="flex mt-3">
                            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                    </div>

                    <!-- School Testimonial -->
                    <div class="bg-gradient-to-br from-teal-50 to-white rounded-2xl p-6 border border-teal-100">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-r from-teal-500 to-emerald-600"></div>
                            <div class="ml-4">
                                <h4 class="font-semibold text-gray-900">Michael Rodriguez</h4>
                                <p class="text-sm text-gray-600">Principal, Green Valley High</p>
                            </div>
                        </div>
                        <p class="text-gray-700 italic">
                            "The AI-powered appraisals helped us identify the perfect candidates. We've reduced hiring time by 40% and teacher turnover by 60%."
                        </p>
                        <div class="flex mt-3">
                            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Copyright -->
                <p class="text-center text-sm text-gray-500 mt-12" :class="{ 'animate-fade-in-up': loaded }">
                    &copy; {{ new Date().getFullYear() }} Teachergauge. AI-powered teacher appraisal for modern education.
                </p>
            </div>
        </div>
    </div>
</template>

<style scoped>
@keyframes fade-in-up {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fade-in-up 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards;
}

/* Smooth hover transitions */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 300ms;
}
</style>
