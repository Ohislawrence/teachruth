<template>
    <AppLayout title="My Applications">
        <div class="min-h-screen bg-gradient-to-b from-emerald-50 via-teal-50 to-white">
            <!-- Navigation -->
            <nav class="bg-gradient-to-r from-emerald-600 to-teal-600 shadow-lg">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-white/20 rounded-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <div>
                                    <h1 class="text-xl font-bold text-white">My Applications</h1>
                                    <p class="text-xs text-emerald-100">Track your job applications</p>
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
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <!-- Header -->
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold text-gray-900">Job Application Tracker</h2>
                        <p class="text-emerald-700 mt-2">Monitor the status of your teaching job applications</p>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
                        <!-- Total Applications -->
                        <div class="bg-gradient-to-br from-white to-emerald-50 shadow-xl rounded-2xl border border-emerald-100 transform transition-transform hover:-translate-y-1">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="p-3 rounded-xl bg-emerald-100 mr-4">
                                        <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-emerald-600">Total Applications</dt>
                                        <dd class="mt-1 text-3xl font-bold text-gray-900">{{ stats.total }}</dd>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending -->
                        <div class="bg-gradient-to-br from-white to-amber-50 shadow-xl rounded-2xl border border-amber-100 transform transition-transform hover:-translate-y-1">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="p-3 rounded-xl bg-amber-100 mr-4">
                                        <svg class="w-6 h-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-amber-600">Pending Review</dt>
                                        <dd class="mt-1 text-3xl font-bold text-amber-700">{{ stats.pending }}</dd>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Shortlisted -->
                        <div class="bg-gradient-to-br from-white to-emerald-50 shadow-xl rounded-2xl border border-emerald-100 transform transition-transform hover:-translate-y-1">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="p-3 rounded-xl bg-emerald-100 mr-4">
                                        <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-emerald-600">Shortlisted</dt>
                                        <dd class="mt-1 text-3xl font-bold text-emerald-700">{{ stats.shortlisted }}</dd>
                                        <p v-if="stats.shortlisted > 0" class="text-xs text-emerald-500 mt-1">🎉 Great progress!</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Rejected -->
                        <div class="bg-gradient-to-br from-white to-red-50 shadow-xl rounded-2xl border border-red-100 transform transition-transform hover:-translate-y-1">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="p-3 rounded-xl bg-red-100 mr-4">
                                        <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-red-600">Not Selected</dt>
                                        <dd class="mt-1 text-3xl font-bold text-red-700">{{ stats.rejected }}</dd>
                                        <p v-if="stats.rejected > 0" class="text-xs text-red-500 mt-1">Keep applying!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Applications List -->
                    <div class="space-y-6">
                        <!-- Application Cards -->
                        <div v-for="application in applications.data" :key="application.id"
                             class="bg-white shadow-xl rounded-2xl border border-emerald-100 overflow-hidden hover:shadow-2xl transition-all duration-300">
                            <div class="p-6">
                                <div class="flex flex-col lg:flex-row lg:items-start justify-between">
                                    <!-- Application Info -->
                                    <div class="flex-1">
                                        <div class="flex items-start space-x-4">
                                            <!-- Status Badge -->
                                            <div class="flex-shrink-0">
                                                <div class="relative">
                                                    <div :class="statusIconClass(application.status)" class="w-16 h-16 rounded-xl flex items-center justify-center">
                                                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path v-if="application.status === 'pending'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            <path v-if="application.status === 'reviewed'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path v-if="application.status === 'shortlisted'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                            <path v-if="application.status === 'rejected'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </div>
                                                    <span :class="statusBadgeClass(application.status)" class="absolute -top-2 -right-2 px-2.5 py-0.5 rounded-full text-xs font-bold">
                                                        {{ application.status.toUpperCase() }}
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Job Details -->
                                            <div class="flex-1 min-w-0">
                                                <div class="flex flex-wrap items-center justify-between mb-2">
                                                    <h3 class="text-xl font-bold text-gray-900 truncate">
                                                        {{ application.job.title }}
                                                    </h3>
                                                    <span class="text-sm font-bold text-emerald-700">
                                                        {{ application.job.salary_range }}
                                                    </span>
                                                </div>

                                                <p class="text-emerald-700 font-medium mb-4">
                                                    <span class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                        </svg>
                                                        {{ application.job.school.school_profile.school_name }}
                                                    </span>
                                                    <span class="text-sm text-gray-600 ml-5">
                                                        {{ application.job.state }}, {{ application.job.lga }}
                                                    </span>
                                                </p>

                                                <!-- Application Metadata -->
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                                    <!-- Applied Date -->
                                                    <div class="flex items-center p-3 bg-emerald-50 rounded-xl">
                                                        <div class="p-2 rounded-lg bg-emerald-100 mr-3">
                                                            <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <p class="text-xs text-emerald-600">Applied Date</p>
                                                            <p class="text-sm font-semibold text-gray-900">{{ formatDate(application.created_at) }}</p>
                                                        </div>
                                                    </div>

                                                    <!-- Subject -->
                                                    <div class="flex items-center p-3 bg-emerald-50 rounded-xl">
                                                        <div class="p-2 rounded-lg bg-emerald-100 mr-3">
                                                            <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <p class="text-xs text-emerald-600">Subject</p>
                                                            <p class="text-sm font-semibold text-gray-900">{{ formatSubjectName(application.job.subject) }}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- School Feedback -->
                                                <div v-if="application.school_feedback" class="mt-4">
                                                    <div class="bg-gradient-to-r from-blue-50 to-blue-100/50 border border-blue-200 rounded-xl p-4">
                                                        <div class="flex items-start">
                                                            <div class="flex-shrink-0 p-2 rounded-lg bg-blue-100 mr-3">
                                                                <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                                                </svg>
                                                            </div>
                                                            <div>
                                                                <p class="text-sm font-semibold text-blue-800 mb-1">School Feedback</p>
                                                                <p class="text-sm text-blue-700">{{ application.school_feedback }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Status Message -->
                                                <div class="mt-4">
                                                    <p class="text-sm" :class="statusMessageClass(application.status)">
                                                        {{ statusMessage(application.status) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Button -->
                                    <div class="mt-4 lg:mt-0 lg:ml-6 flex items-center">
                                        <Link
                                            :href="route('teacher.jobs.show', application.job.id)"
                                            class="inline-flex items-center justify-center px-5 py-2.5 border border-transparent text-sm font-bold rounded-xl shadow text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-4 focus:ring-emerald-300 transition"
                                        >
                                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            View Job
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Empty State -->
                        <div v-if="applications.data.length === 0" class="text-center py-16 bg-white shadow-xl rounded-2xl border border-emerald-100">
                            <div class="mx-auto w-24 h-24 bg-gradient-to-r from-emerald-100 to-teal-100 rounded-full flex items-center justify-center mb-6">
                                <svg class="w-12 h-12 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">No applications submitted yet</h3>
                            <p class="text-emerald-600 max-w-md mx-auto mb-6">
                                Start applying to teaching jobs to track your application status here.
                            </p>
                            <div class="mt-6">
                                <Link
                                    :href="route('teacher.jobs')"
                                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-bold rounded-xl shadow-lg text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-4 focus:ring-emerald-300 transition transform hover:-translate-y-0.5"
                                >
                                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    Browse Available Jobs
                                </Link>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div v-if="applications.links.length > 3" class="mt-8 bg-white shadow-xl rounded-2xl border border-emerald-100 p-6">
                        <div class="flex flex-col sm:flex-row items-center justify-between">
                            <div class="mb-4 sm:mb-0">
                                <p class="text-sm text-gray-700">
                                    Showing
                                    <span class="font-bold text-emerald-700">{{ applications.from }}</span>
                                    to
                                    <span class="font-bold text-emerald-700">{{ applications.to }}</span>
                                    of
                                    <span class="font-bold text-emerald-700">{{ applications.total }}</span>
                                    applications
                                </p>
                            </div>
                            <nav class="flex space-x-1">
                                <Link
                                    v-for="(link, index) in applications.links"
                                    :key="index"
                                    :href="link.url"
                                    class="min-w-[40px] h-10 flex items-center justify-center border border-emerald-200 text-sm font-medium rounded-lg transition"
                                    :class="{
                                        'bg-gradient-to-r from-emerald-600 to-teal-600 text-white border-emerald-600 shadow-lg': link.active,
                                        'text-emerald-700 hover:bg-emerald-50 hover:border-emerald-300': !link.active && link.url,
                                        'text-gray-400 cursor-not-allowed': !link.url,
                                        'rounded-l-lg': index === 0,
                                        'rounded-r-lg': index === applications.links.length - 1
                                    }"
                                    v-html="link.label"
                                ></Link>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    applications: Object,
    stats: Object
})

const statusIconClass = (status) => {
    const classes = {
        'pending': 'bg-amber-100 text-amber-600',
        'reviewed': 'bg-blue-100 text-blue-600',
        'shortlisted': 'bg-emerald-100 text-emerald-600',
        'rejected': 'bg-red-100 text-red-600'
    }
    return classes[status] || 'bg-gray-100 text-gray-600'
}

const statusBadgeClass = (status) => {
    const classes = {
        'pending': 'bg-amber-100 text-amber-800',
        'reviewed': 'bg-blue-100 text-blue-800',
        'shortlisted': 'bg-emerald-100 text-emerald-800',
        'rejected': 'bg-red-100 text-red-800'
    }
    return classes[status] || 'bg-gray-100 text-gray-800'
}

const statusMessageClass = (status) => {
    const classes = {
        'pending': 'text-amber-600 bg-amber-50 px-3 py-2 rounded-lg',
        'reviewed': 'text-blue-600 bg-blue-50 px-3 py-2 rounded-lg',
        'shortlisted': 'text-emerald-600 bg-emerald-50 px-3 py-2 rounded-lg',
        'rejected': 'text-red-600 bg-red-50 px-3 py-2 rounded-lg'
    }
    return classes[status] || 'text-gray-600 bg-gray-50 px-3 py-2 rounded-lg'
}

const statusMessage = (status) => {
    const messages = {
        'pending': '⏳ Your application is under review by the school.',
        'reviewed': '👁️ Your application has been reviewed by the school.',
        'shortlisted': '✅ Congratulations! You have been shortlisted for this position.',
        'rejected': '❌ Unfortunately, you were not selected for this position.'
    }
    return messages[status] || 'Application status: ' + status
}

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    })
}

const formatSubjectName = (subject) => {
    return subject.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())
}
</script>
