<template>
    <AppLayout title="Job Applicants">
        <div class="min-h-screen bg-gradient-to-b from-emerald-50 via-teal-50 to-white">
            <!-- Navigation -->
            <nav class="bg-gradient-to-r from-emerald-600 to-teal-600 shadow-lg">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <div class="flex items-center space-x-3">
                                <Link :href="route('school.jobs')" class="text-white hover:text-emerald-100 transition">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                </Link>
                                <div>
                                    <h1 class="text-xl font-bold text-white">Job Applicants</h1>
                                    <p class="text-xs text-emerald-100">View applications for {{ job.title }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <Link
                                :href="route('school.dashboard')"
                                class="text-sm font-medium text-white hover:text-emerald-100 transition"
                            >
                                Dashboard
                            </Link>
                            <Link
                                :href="route('school.jobs')"
                                class="text-sm font-medium text-white hover:text-emerald-100 transition"
                            >
                                My Jobs
                            </Link>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="py-8">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <!-- Header -->
                    <div class="mb-8">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h2 class="text-3xl font-bold text-gray-900">Applicants for {{ job.title }}</h2>
                                <div class="flex items-center space-x-4 mt-2">
                                    <p class="text-emerald-700">
                                        <span class="font-semibold">{{ applications.total }}</span> application{{ applications.total !== 1 ? 's' : '' }} received
                                    </p>
                                    <span class="px-3 py-1 rounded-full text-xs font-bold"
                                          :class="job.is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'">
                                        {{ job.is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>
                            <div class="mt-4 sm:mt-0 space-x-3">
                                <Link
                                    :href="route('school.jobs.edit', job.id)"
                                    class="inline-flex items-center px-5 py-2.5 border-2 border-emerald-300 text-sm font-semibold rounded-xl text-emerald-700 bg-white hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-200 transition"
                                >
                                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit Job
                                </Link>
                                <Link
                                    :href="route('school.applications')"
                                    class="inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-bold rounded-xl shadow-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition transform hover:-translate-y-0.5"
                                >
                                    View All Applications
                                </Link>
                            </div>
                        </div>
                    </div>

                    <!-- Job Info Card -->
                    <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 p-6 mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <div class="flex items-center p-4 bg-emerald-50 rounded-xl">
                                <div class="p-3 rounded-lg bg-emerald-100 mr-4">
                                    <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-emerald-600">Subject</p>
                                    <p class="text-lg font-semibold text-gray-900">{{ formatSubjectName(job.subject) }}</p>
                                </div>
                            </div>

                            <div class="flex items-center p-4 bg-emerald-50 rounded-xl">
                                <div class="p-3 rounded-lg bg-emerald-100 mr-4">
                                    <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-emerald-600">Level</p>
                                    <p class="text-lg font-semibold text-gray-900">{{ formatLevelName(job.level) }}</p>
                                </div>
                            </div>

                            <div class="flex items-center p-4 bg-emerald-50 rounded-xl">
                                <div class="p-3 rounded-lg bg-emerald-100 mr-4">
                                    <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-emerald-600">Deadline</p>
                                    <p class="text-lg font-semibold text-gray-900">{{ formatDate(job.application_deadline) }}</p>
                                </div>
                            </div>

                            <div class="flex items-center p-4 bg-emerald-50 rounded-xl">
                                <div class="p-3 rounded-lg bg-emerald-100 mr-4">
                                    <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-emerald-600">Salary Range</p>
                                    <p class="text-lg font-bold text-emerald-700">{{ job.salary_range }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                        <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 p-6">
                            <div class="text-center">
                                <p class="text-sm font-medium text-emerald-600">Total Applicants</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ applications.total }}</p>
                            </div>
                        </div>

                        <div class="bg-white shadow-xl rounded-2xl border border-yellow-100 p-6">
                            <div class="text-center">
                                <p class="text-sm font-medium text-yellow-600">Pending Review</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ stats.pending }}</p>
                            </div>
                        </div>

                        <div class="bg-white shadow-xl rounded-2xl border border-green-100 p-6">
                            <div class="text-center">
                                <p class="text-sm font-medium text-green-600">Shortlisted</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ stats.shortlisted }}</p>
                            </div>
                        </div>

                        <div class="bg-white shadow-xl rounded-2xl border border-red-100 p-6">
                            <div class="text-center">
                                <p class="text-sm font-medium text-red-600">Rejected</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ stats.rejected }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Applications List -->
                    <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-emerald-100">
                                <thead class="bg-gradient-to-r from-emerald-50 to-teal-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-emerald-700 uppercase tracking-wider">
                                            Teacher
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-emerald-700 uppercase tracking-wider">
                                            Qualification & Experience
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-emerald-700 uppercase tracking-wider">
                                            Appraisal Score
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-emerald-700 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-emerald-700 uppercase tracking-wider">
                                            Applied On
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-emerald-700 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-emerald-100">
                                    <tr v-for="application in applications.data" :key="application.id" class="hover:bg-emerald-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-emerald-100 to-teal-100 flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-bold text-gray-900">{{ application.teacher.name }}</div>
                                                    <div class="text-sm text-emerald-600">{{ application.teacher.email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">{{ application.teacher.teacher_profile?.qualification || 'Not specified' }}</div>
                                            <div class="text-sm text-gray-500">{{ application.teacher.teacher_profile?.years_of_experience || '0' }} years experience</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-emerald-700">
                                                {{ application.teacher.appraisals?.[0]?.score || 'N/A' }}/100
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full"
                                                  :class="statusColor(application.status)">
                                                {{ formatStatus(application.status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ formatDate(application.created_at) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <Link
                                                    :href="route('school.applications.show', application.id)"
                                                    class="text-emerald-600 hover:text-emerald-900 p-2 rounded-lg hover:bg-emerald-100 transition"
                                                    title="View Details"
                                                >
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </Link>
                                                <button
                                                    @click="updateStatus(application.id, 'shortlisted')"
                                                    v-if="application.status !== 'shortlisted'"
                                                    class="text-green-600 hover:text-green-900 p-2 rounded-lg hover:bg-green-100 transition"
                                                    title="Shortlist"
                                                >
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </button>
                                                <button
                                                    @click="updateStatus(application.id, 'rejected')"
                                                    v-if="application.status !== 'rejected'"
                                                    class="text-red-600 hover:text-red-900 p-2 rounded-lg hover:bg-red-100 transition"
                                                    title="Reject"
                                                >
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Empty State -->
                        <div v-if="applications.data.length === 0" class="text-center py-16">
                            <div class="mx-auto w-24 h-24 bg-gradient-to-r from-emerald-100 to-teal-100 rounded-full flex items-center justify-center mb-6">
                                <svg class="w-12 h-12 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">No applicants yet</h3>
                            <p class="text-emerald-600 max-w-md mx-auto mb-6">
                                Share this job posting to attract qualified teachers. Applicants will appear here once they apply.
                            </p>
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
                                    applicants
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

                    <!-- Share Job Section -->
                    <div class="mt-8 bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-100 rounded-2xl p-6">
                        <div class="flex flex-col md:flex-row md:items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-emerald-800 mb-2">Share This Job</h3>
                                <p class="text-emerald-700">
                                    Share this job posting with qualified teachers to get more applications.
                                </p>
                            </div>
                            <div class="mt-4 md:mt-0">
                                <button
                                    @click="copyJobLink"
                                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-bold rounded-xl shadow-lg text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-4 focus:ring-emerald-300 transition transform hover:-translate-y-0.5"
                                >
                                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                    Copy Job Link
                                </button>
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
import { computed } from 'vue'

const props = defineProps({
    job: Object,
    applications: Object
})

const stats = computed(() => {
    const pending = props.applications.data.filter(app => app.status === 'pending').length
    const shortlisted = props.applications.data.filter(app => app.status === 'shortlisted').length
    const rejected = props.applications.data.filter(app => app.status === 'rejected').length

    return {
        pending,
        shortlisted,
        rejected
    }
})

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric'
    })
}

const formatSubjectName = (subject) => {
    return subject.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())
}

const formatLevelName = (level) => {
    return level.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())
}

const formatStatus = (status) => {
    const statusMap = {
        'pending': 'Pending Review',
        'reviewed': 'Reviewed',
        'shortlisted': 'Shortlisted',
        'rejected': 'Rejected'
    }
    return statusMap[status] || status
}

const statusColor = (status) => {
    const colors = {
        'pending': 'bg-yellow-100 text-yellow-800',
        'reviewed': 'bg-blue-100 text-blue-800',
        'shortlisted': 'bg-green-100 text-green-800',
        'rejected': 'bg-red-100 text-red-800'
    }
    return colors[status] || 'bg-gray-100 text-gray-800'
}

const updateStatus = (applicationId, status) => {
    if (confirm('Are you sure you want to update the application status?')) {
        router.post(route('school.applications.update-status', applicationId), {
            status: status
        }, {
            preserveScroll: true,
            onSuccess: () => {
                router.reload({ only: ['applications'] })
            }
        })
    }
}

const copyJobLink = () => {
    const jobLink = route('teacher.jobs.show', props.job.id)
    navigator.clipboard.writeText(jobLink)
    alert('Job link copied to clipboard! Share this with teachers.')
}
</script>
