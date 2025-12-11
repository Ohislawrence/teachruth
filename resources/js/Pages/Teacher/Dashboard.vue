<template>
    <AppLayout title="Dashboard">
        <div class="min-h-screen bg-gradient-to-br from-emerald-50 via-teal-50 to-white">
            <!-- Navigation -->
            <nav class="bg-gradient-to-r from-emerald-600 to-teal-600 shadow-lg">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-white/20 rounded-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h1 class="text-xl font-bold text-white">Teacher Dashboard</h1>
                                    <p class="text-xs text-emerald-100">Welcome back, {{ teacher.user?.name }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <Link
                                :href="route('teacher.appraisals')"
                                class="text-sm font-medium text-white hover:text-emerald-100 transition"
                            >
                                My Appraisals
                            </Link>
                            <Link
                                :href="route('teacher.profile')"
                                class="text-sm font-medium text-white hover:text-emerald-100 transition"
                            >
                                Profile
                            </Link>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Stats Section -->
            <div class="py-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-3 mb-8">
                        <!-- Total Appraisals -->
                        <div class="bg-gradient-to-br from-white to-emerald-50 shadow-lg rounded-2xl border border-emerald-100 transform transition-transform hover:-translate-y-1">
                            <div class="px-5 py-6 sm:p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 p-3 rounded-xl bg-emerald-100">
                                        <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <dt class="text-sm font-medium text-emerald-600 truncate">
                                            Total Appraisals
                                        </dt>
                                        <dd class="mt-1 text-3xl font-bold text-gray-900">
                                            {{ stats.appraisals_count }}
                                        </dd>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Jobs Applied -->
                        <div class="bg-gradient-to-br from-white to-emerald-50 shadow-lg rounded-2xl border border-emerald-100 transform transition-transform hover:-translate-y-1">
                            <div class="px-5 py-6 sm:p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 p-3 rounded-xl bg-emerald-100">
                                        <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <dt class="text-sm font-medium text-emerald-600 truncate">
                                            Jobs Applied
                                        </dt>
                                        <dd class="mt-1 text-3xl font-bold text-gray-900">
                                            {{ stats.jobs_applied_count }}
                                        </dd>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Shortlisted -->
                        <div class="bg-gradient-to-br from-white to-emerald-50 shadow-lg rounded-2xl border border-emerald-100 transform transition-transform hover:-translate-y-1">
                            <div class="px-5 py-6 sm:p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 p-3 rounded-xl bg-emerald-100">
                                        <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <dt class="text-sm font-medium text-emerald-600 truncate">
                                            Shortlisted
                                        </dt>
                                        <dd class="mt-1 text-3xl font-bold text-gray-900">
                                            {{ stats.shortlisted_count }}
                                        </dd>
                                        <p class="text-xs text-emerald-500 mt-1">
                                            {{ stats.shortlisted_count > 0 ? '🎉 Great job!' : 'Keep applying!' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Latest Appraisal Card -->
                        <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 overflow-hidden">
                            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-5 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-bold text-gray-900 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                        Latest Appraisal
                                    </h3>
                                    <span v-if="teacher.latest_appraisal" class="text-xs font-medium px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800">
                                        {{ teacher.latest_appraisal.created_at }}
                                    </span>
                                </div>
                            </div>

                            <div class="px-5 py-6 sm:p-6">
                                <div v-if="teacher.latest_appraisal" class="space-y-6">
                                    <!-- Score Display -->
                                    <div class="bg-gradient-to-r from-emerald-50 to-emerald-100/50 rounded-xl p-5">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm font-medium text-emerald-700">Overall Score</p>
                                                <p class="text-xs text-emerald-600">Based on 5 competencies</p>
                                            </div>
                                            <div class="text-center">
                                                <div class="relative inline-flex items-center justify-center">
                                                    <svg class="w-20 h-20 transform -rotate-90">
                                                        <circle
                                                            cx="40"
                                                            cy="40"
                                                            r="36"
                                                            stroke="currentColor"
                                                            stroke-width="8"
                                                            fill="transparent"
                                                            class="text-emerald-200"
                                                        />
                                                        <circle
                                                            cx="40"
                                                            cy="40"
                                                            r="36"
                                                            stroke="currentColor"
                                                            stroke-width="8"
                                                            fill="transparent"
                                                            stroke-dasharray="226.2"
                                                            :stroke-dashoffset="226.2 - (226.2 * teacher.latest_appraisal.overall_score / 100)"
                                                            stroke-linecap="round"
                                                            class="text-emerald-600"
                                                        />
                                                    </svg>
                                                    <span class="absolute text-2xl font-bold text-gray-900">
                                                        {{ teacher.latest_appraisal.overall_score }}%
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Grade Badge -->
                                        <div class="mt-4 flex items-center justify-between">
                                            <span class="text-sm font-medium text-emerald-700">Performance Grade</span>
                                            <span class="text-lg font-bold px-3 py-1 rounded-lg" :class="gradeColor(teacher.latest_appraisal.grade)">
                                                {{ teacher.latest_appraisal.grade }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Strengths -->
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-900 mb-3 flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Key Strengths
                                        </h4>
                                        <div class="bg-emerald-50 rounded-lg p-4">
                                            <p class="text-sm text-gray-700 leading-relaxed">{{ teacher.latest_appraisal.strengths }}</p>
                                        </div>
                                    </div>

                                    <!-- Action Button -->
                                    <div class="pt-4">
                                        <Link
                                            :href="route('teacher.appraisals')"
                                            class="w-full inline-flex items-center justify-center px-4 py-3 border border-transparent text-sm font-bold rounded-lg shadow-lg text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-4 focus:ring-emerald-300 transition transform hover:-translate-y-0.5"
                                        >
                                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            View Full Appraisal Report
                                        </Link>
                                    </div>
                                </div>
                                <div v-else class="text-center py-8">
                                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-emerald-100 mb-4">
                                        <svg class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-medium text-gray-900 mb-2">No Appraisal Yet</h4>
                                    <p class="text-emerald-600 mb-4">Get your AI-powered teacher appraisal to unlock job opportunities</p>
                                    <Link
                                        :href="route('teacher.reappraise')"
                                        class="inline-flex items-center px-5 py-3 border border-transparent text-sm font-bold rounded-lg shadow-lg text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-4 focus:ring-emerald-300 transition transform hover:-translate-y-0.5"
                                    >
                                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                        Get Your First Appraisal
                                    </Link>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Jobs Card -->
                        <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 overflow-hidden">
                            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-5 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-bold text-gray-900 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        Recent Job Opportunities
                                    </h3>
                                    <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800">
                                        {{ recentJobs.length }} available
                                    </span>
                                </div>
                            </div>

                            <div class="divide-y divide-emerald-100">
                                <div v-if="recentJobs.length > 0">
                                    <ul class="divide-y divide-emerald-50">
                                        <li v-for="job in recentJobs" :key="job.id" class="px-5 py-4 hover:bg-emerald-50 transition">
                                            <div class="flex items-center justify-between">
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center space-x-3">
                                                        <div class="flex-shrink-0 p-2 rounded-lg bg-emerald-100">
                                                            <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <h4 class="text-sm font-bold text-gray-900 truncate">{{ job.title }}</h4>
                                                            <p class="text-sm text-emerald-700 font-medium mt-1">
                                                                {{ job.school.school_profile.school_name }}
                                                            </p>
                                                            <div class="flex items-center space-x-3 mt-1">
                                                                <span class="inline-flex items-center text-xs text-gray-500">
                                                                    <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                    </svg>
                                                                    {{ job.state }}, {{ job.lga }}
                                                                </span>
                                                                <span v-if="job.salary_range" class="inline-flex items-center text-xs text-emerald-600">
                                                                    <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>
                                                                    ₦{{ job.salary_range }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ml-4 flex-shrink-0">
                                                    <Link
                                                        :href="route('teacher.jobs.show', job.id)"
                                                        class="inline-flex items-center px-3.5 py-1.5 border border-transparent text-xs font-bold rounded-lg shadow-sm text-white bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 focus:outline-none focus:ring-2 focus:ring-emerald-300 transition"
                                                    >
                                                        View
                                                    </Link>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="px-5 py-4 bg-gradient-to-r from-emerald-50/50 to-teal-50/50">
                                        <Link
                                            :href="route('teacher.jobs')"
                                            class="inline-flex items-center text-sm font-bold text-emerald-700 hover:text-emerald-800 transition"
                                        >
                                            View all job opportunities
                                            <svg class="ml-2 w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </Link>
                                    </div>
                                </div>
                                <div v-else class="px-5 py-8 text-center">
                                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-emerald-100 mb-4">
                                        <svg class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-medium text-gray-900 mb-2">No Recent Jobs</h4>
                                    <p class="text-emerald-600">New opportunities coming soon!</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <Link
                            :href="route('teacher.reappraise')"
                            class="bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 rounded-xl p-4 shadow-lg text-white transition transform hover:-translate-y-1"
                        >
                            <div class="flex items-center">
                                <div class="p-2 rounded-lg bg-white/20 mr-3">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold">New Appraisal</h4>
                                    <p class="text-sm opacity-90">Update your assessment</p>
                                </div>
                            </div>
                        </Link>

                        <Link
                            :href="route('teacher.profile')"
                            class="bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 rounded-xl p-4 shadow-lg text-white transition transform hover:-translate-y-1"
                        >
                            <div class="flex items-center">
                                <div class="p-2 rounded-lg bg-white/20 mr-3">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold">Edit Profile</h4>
                                    <p class="text-sm opacity-90">Update your information</p>
                                </div>
                            </div>
                        </Link>

                        <Link
                            :href="route('teacher.jobs')"
                            class="bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 rounded-xl p-4 shadow-lg text-white transition transform hover:-translate-y-1"
                        >
                            <div class="flex items-center">
                                <div class="p-2 rounded-lg bg-white/20 mr-3">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold">Browse Jobs</h4>
                                    <p class="text-sm opacity-90">Find opportunities</p>
                                </div>
                            </div>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'

defineProps({
    teacher: Object,
    stats: Object,
    recentJobs: Array
})

const gradeColor = (grade) => {
    const colors = {
        'A+': 'text-emerald-700 bg-emerald-100',
        'A': 'text-emerald-700 bg-emerald-100',
        'B': 'text-amber-700 bg-amber-100',
        'C': 'text-orange-700 bg-orange-100',
        'D': 'text-red-700 bg-red-100',
        'F': 'text-red-700 bg-red-100'
    }
    return colors[grade] || 'text-gray-700 bg-gray-100'
}
</script>
