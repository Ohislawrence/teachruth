<template>
    <AppLayout title="My Profile">
        <div class="min-h-screen bg-gradient-to-b from-emerald-50 via-teal-50 to-white">
            <!-- Navigation -->
            <nav class="bg-gradient-to-r from-emerald-600 to-teal-600 shadow-lg">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <div class="flex items-center space-x-3">
                                <Link :href="route('teacher.dashboard')" class="text-white hover:text-emerald-100 transition">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                </Link>
                                <div>
                                    <h1 class="text-xl font-bold text-white">My Profile</h1>
                                    <p class="text-xs text-emerald-100">Manage your teaching profile</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <Link
                                :href="route('teacher.appraisals')"
                                class="text-sm font-medium text-white hover:text-emerald-100 transition"
                            >
                                Appraisals
                            </Link>
                            <Link
                                :href="route('teacher.jobs')"
                                class="text-sm font-medium text-white hover:text-emerald-100 transition"
                            >
                                Browse Jobs
                            </Link>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="py-8">
                <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                    <!-- Profile Header -->
                    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl shadow-2xl p-6 mb-8">
                        <div class="flex items-center space-x-4">
                            <div class="w-20 h-20 rounded-full bg-white/20 flex items-center justify-center">
                                <svg class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-white">{{ teacher.name }}</h2>
                                <p class="text-emerald-100">{{ teacher.teacher_profile?.qualification || 'Teacher' }}</p>
                                <div class="flex items-center space-x-4 mt-2">
                                    <span v-if="teacher.teacher_profile?.years_of_experience"
                                          class="text-sm bg-white/20 px-3 py-1 rounded-full text-white">
                                        {{ teacher.teacher_profile.years_of_experience }} years experience
                                    </span>
                                    <span v-if="teacher.teacher_profile?.specialization"
                                          class="text-sm bg-white/20 px-3 py-1 rounded-full text-white">
                                        {{ teacher.teacher_profile.specialization }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Form -->
                    <div class="bg-white shadow-2xl rounded-2xl border border-emerald-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-5 sm:px-8">
                            <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Profile Information
                            </h3>
                            <p class="mt-1 text-sm text-emerald-700">
                                Update your personal and professional details
                            </p>
                        </div>

                        <form @submit.prevent="submitForm">
                            <div class="px-6 py-8 sm:p-8">
                                <div class="space-y-8">
                                    <!-- Personal Information Section -->
                                    <div>
                                        <div class="mb-6">
                                            <h4 class="text-lg font-bold text-gray-900 flex items-center">
                                                <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                Personal Information
                                            </h4>
                                            <p class="text-sm text-emerald-600">Your personal contact details</p>
                                        </div>

                                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                            <!-- Full Name -->
                                            <div class="sm:col-span-2">
                                                <label for="name" class="block text-sm font-semibold text-emerald-700 mb-2">
                                                    <div class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                        Full Name
                                                    </div>
                                                </label>
                                                <input
                                                    id="name"
                                                    v-model="form.name"
                                                    type="text"
                                                    class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                                                    :class="errors.name ? 'border-red-300 focus:border-red-500 focus:ring-red-200' : ''"
                                                />
                                                <p v-if="errors.name" class="mt-2 text-sm text-red-600 flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                                    </svg>
                                                    {{ errors.name }}
                                                </p>
                                            </div>

                                            <!-- Phone Number -->
                                            <div>
                                                <label for="phone" class="block text-sm font-semibold text-emerald-700 mb-2">
                                                    <div class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                        </svg>
                                                        Phone Number
                                                    </div>
                                                </label>
                                                <input
                                                    id="phone"
                                                    v-model="form.phone"
                                                    type="tel"
                                                    class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                                                />
                                            </div>

                                            <!-- Email Address -->
                                            <div>
                                                <label for="email" class="block text-sm font-semibold text-emerald-700 mb-2">
                                                    <div class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                        </svg>
                                                        Email Address
                                                    </div>
                                                </label>
                                                <input
                                                    id="email"
                                                    :value="teacher.email"
                                                    type="email"
                                                    disabled
                                                    class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl bg-emerald-50 text-gray-600"
                                                />
                                                <p class="text-xs text-emerald-600 mt-1">Email cannot be changed</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Professional Information Section -->
                                    <div>
                                        <div class="mb-6">
                                            <h4 class="text-lg font-bold text-gray-900 flex items-center">
                                                <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                Professional Information
                                            </h4>
                                            <p class="text-sm text-emerald-600">Your teaching credentials and experience</p>
                                        </div>

                                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                            <!-- Highest Qualification -->
                                            <div class="sm:col-span-2">
                                                <label for="qualification" class="block text-sm font-semibold text-emerald-700 mb-2">
                                                    <div class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                                        </svg>
                                                        Highest Qualification
                                                    </div>
                                                </label>
                                                <input
                                                    id="qualification"
                                                    v-model="form.qualification"
                                                    type="text"
                                                    required
                                                    placeholder="e.g., B.Ed, M.Ed, PGDE"
                                                    class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                                                    :class="errors.qualification ? 'border-red-300 focus:border-red-500 focus:ring-red-200' : ''"
                                                />
                                                <p v-if="errors.qualification" class="mt-2 text-sm text-red-600">{{ errors.qualification }}</p>
                                            </div>

                                            <!-- Years of Experience -->
                                            <div>
                                                <label for="years_of_experience" class="block text-sm font-semibold text-emerald-700 mb-2">
                                                    <div class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        Years of Experience
                                                    </div>
                                                </label>
                                                <input
                                                    id="years_of_experience"
                                                    v-model="form.years_of_experience"
                                                    type="number"
                                                    min="0"
                                                    max="50"
                                                    required
                                                    class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                                                />
                                                <p class="text-xs text-emerald-600 mt-1">Number of years teaching experience</p>
                                            </div>

                                            <!-- Specialization -->
                                            <div>
                                                <label for="specialization" class="block text-sm font-semibold text-emerald-700 mb-2">
                                                    <div class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                        </svg>
                                                        Specialization
                                                    </div>
                                                </label>
                                                <input
                                                    id="specialization"
                                                    v-model="form.specialization"
                                                    type="text"
                                                    required
                                                    placeholder="e.g., Mathematics, Science, English"
                                                    class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                                                />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Location Information -->
                                    <div>
                                        <div class="mb-6">
                                            <h4 class="text-lg font-bold text-gray-900 flex items-center">
                                                <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                Location Information
                                            </h4>
                                            <p class="text-sm text-emerald-600">Your preferred teaching location</p>
                                        </div>

                                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                            <!-- State -->
                                            <div>
                                                <label for="state" class="block text-sm font-semibold text-emerald-700 mb-2">
                                                    State
                                                </label>
                                                <input
                                                    id="state"
                                                    v-model="form.state"
                                                    type="text"
                                                    required
                                                    placeholder="e.g., Lagos, Abuja"
                                                    class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                                                />
                                            </div>

                                            <!-- LGA -->
                                            <div>
                                                <label for="lga" class="block text-sm font-semibold text-emerald-700 mb-2">
                                                    Local Government Area
                                                </label>
                                                <input
                                                    id="lga"
                                                    v-model="form.lga"
                                                    type="text"
                                                    required
                                                    placeholder="e.g., Ikeja, Municipal"
                                                    class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                                                />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bio Section -->
                                    <div>
                                        <div class="mb-6">
                                            <h4 class="text-lg font-bold text-gray-900 flex items-center">
                                                <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                                </svg>
                                                Professional Bio
                                            </h4>
                                            <p class="text-sm text-emerald-600">Tell schools about your teaching philosophy</p>
                                        </div>

                                        <div>
                                            <label for="bio" class="block text-sm font-semibold text-emerald-700 mb-2">
                                                Bio
                                            </label>
                                            <textarea
                                                id="bio"
                                                v-model="form.bio"
                                                rows="4"
                                                class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition resize-none"
                                                placeholder="Share your teaching philosophy, experience, and what makes you a great teacher..."
                                            ></textarea>
                                            <p class="text-xs text-emerald-600 mt-1">
                                                This will be visible to schools when you apply for jobs
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Privacy Settings -->
                                    <div class="bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl p-6 border border-emerald-100">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <div class="flex items-center">
                                                    <input
                                                        id="is_public"
                                                        v-model="form.is_public"
                                                        type="checkbox"
                                                        class="h-5 w-5 text-emerald-600 border-emerald-300 rounded focus:ring-emerald-500"
                                                    />
                                                    <label for="is_public" class="ml-3 text-sm font-semibold text-gray-900">
                                                        Make my profile visible to schools
                                                    </label>
                                                </div>
                                                <p class="text-sm text-emerald-600 mt-2">
                                                    When enabled, schools can view your profile and contact you for teaching opportunities.
                                                    When disabled, your profile is only visible when you apply for jobs.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="px-6 py-6 bg-gradient-to-r from-emerald-50 to-teal-50 border-t border-emerald-100 sm:px-8">
                                <div class="flex justify-between">
                                    <Link
                                        :href="route('teacher.dashboard')"
                                        class="inline-flex items-center px-5 py-3 border-2 border-emerald-300 text-sm font-semibold rounded-xl text-emerald-700 bg-white hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-200 transition"
                                    >
                                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                        </svg>
                                        Cancel
                                    </Link>
                                    <button
                                        type="submit"
                                        :disabled="processing || !form.isDirty"
                                        class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-bold rounded-xl shadow-lg text-white transition transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                                        :class="processing
                                            ? 'bg-emerald-400'
                                            : 'bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-4 focus:ring-emerald-300'"
                                    >
                                        <svg v-if="!processing" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        {{ processing ? 'Saving Changes...' : 'Save Changes' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Profile Tips -->
                    <div class="mt-8 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-2xl border border-emerald-100 p-6">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-emerald-600 mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="ml-4">
                                <h4 class="text-lg font-bold text-gray-900 mb-2">Profile Tips</h4>
                                <ul class="space-y-2 text-sm text-emerald-700">
                                    <li class="flex items-start">
                                        <svg class="w-4 h-4 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>Complete profiles are 3x more likely to get shortlisted</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-4 h-4 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>Include specific teaching achievements in your bio</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-4 h-4 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>Keep your location updated for relevant job matches</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'

const processing = ref(false)

const props = defineProps({
    teacher: Object,
    errors: Object
})

const form = useForm({
    name: props.teacher.name || '',
    phone: props.teacher.teacher_profile?.phone || '',
    bio: props.teacher.teacher_profile?.bio || '',
    qualification: props.teacher.teacher_profile?.qualification || '',
    years_of_experience: props.teacher.teacher_profile?.years_of_experience || 0,
    specialization: props.teacher.teacher_profile?.specialization || '',
    state: props.teacher.teacher_profile?.state || '',
    lga: props.teacher.teacher_profile?.lga || '',
    is_public: props.teacher.teacher_profile?.is_public ?? true,
})

const submitForm = () => {
    processing.value = true
    form.put('/teacher/profile', {
        onFinish: () => {
            processing.value = false
        }
    })
}
</script>
