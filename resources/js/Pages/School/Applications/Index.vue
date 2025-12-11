<template>
    <AppLayout title="Job Applications">
        <div class="min-h-screen bg-gradient-to-b from-emerald-50 via-teal-50 to-white">
            <!-- Navigation -->
            <nav class="bg-gradient-to-r from-emerald-600 to-teal-600 shadow-lg">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <div class="flex items-center space-x-3">
                                <Link :href="route('school.dashboard')" class="text-white hover:text-emerald-100 transition">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                </Link>
                                <div>
                                    <h1 class="text-xl font-bold text-white">Job Applications</h1>
                                    <p class="text-xs text-emerald-100">Review teacher applications</p>
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
                                <h2 class="text-3xl font-bold text-gray-900">Teacher Applications</h2>
                                <p class="text-emerald-700 mt-2">Review and manage applications for your job postings</p>
                            </div>
                            <div class="mt-4 sm:mt-0">
                                <Link
                                    :href="route('school.jobs')"
                                    class="inline-flex items-center px-5 py-3 border border-transparent text-sm font-bold rounded-xl shadow-lg text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-4 focus:ring-emerald-300 transition transform hover:-translate-y-0.5"
                                >
                                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    View My Jobs
                                </Link>
                            </div>
                        </div>
                    </div>

                    <!-- Filters Card -->
                    <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 p-6 mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <!-- Status Filter -->
                            <div>
                                <label for="status" class="block text-sm font-semibold text-emerald-700 mb-2">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                        Status
                                    </div>
                                </label>
                                <select
                                    id="status"
                                    v-model="filters.status"
                                    @change="filterApplications"
                                    class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition bg-white"
                                >
                                    <option value="">All Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="reviewed">Reviewed</option>
                                    <option value="shortlisted">Shortlisted</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>

                            <!-- Job Filter -->
                            <div>
                                <label for="job" class="block text-sm font-semibold text-emerald-700 mb-2">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        Job Position
                                    </div>
                                </label>
                                <select
                                    id="job"
                                    v-model="filters.job_id"
                                    @change="filterApplications"
                                    class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition bg-white"
                                >
                                    <option value="">All Jobs</option>
                                    <option v-for="job in jobs || []" :key="job.id" :value="job.id">
                                        {{ job.title }}
                                    </option>
                                </select>
                            </div>

                            <!-- Search -->
                            <div>
                                <label for="search" class="block text-sm font-semibold text-emerald-700 mb-2">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                        Search Teacher
                                    </div>
                                </label>
                                <input
                                    type="text"
                                    id="search"
                                    v-model="filters.search"
                                    @input="debouncedFilter"
                                    placeholder="Teacher name, subject..."
                                    class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                                />
                            </div>

                            <!-- Date Filter -->
                            <div>
                                <label for="date" class="block text-sm font-semibold text-emerald-700 mb-2">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Sort By
                                    </div>
                                </label>
                                <select
                                    id="date"
                                    v-model="filters.sort"
                                    @change="filterApplications"
                                    class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition bg-white"
                                >
                                    <option value="newest">Newest First</option>
                                    <option value="oldest">Oldest First</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-between pt-6 border-t border-emerald-100">
                            <button
                                @click="resetFilters"
                                class="inline-flex items-center px-4 py-2.5 border-2 border-emerald-300 text-sm font-semibold rounded-xl text-emerald-700 bg-white hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-200 transition"
                            >
                                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Reset Filters
                            </button>
                            <div class="text-sm">
                                <span class="font-bold text-emerald-700 text-lg">{{ applications.total }}</span>
                                <span class="text-gray-600 ml-1">application{{ applications.total !== 1 ? 's' : '' }} found</span>
                            </div>
                        </div>
                    </div>

                    <!-- Applications List -->
                    <div class="space-y-6">
                        <!-- Application Cards -->
                        <div v-for="application in applications.data" :key="application.id"
                             class="bg-white shadow-xl rounded-2xl border border-emerald-100 overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                            <div class="p-6">
                                <div class="flex flex-col lg:flex-row lg:items-start justify-between">
                                    <!-- Teacher Info -->
                                    <div class="flex-1">
                                        <div class="flex items-start space-x-4">
                                            <!-- Teacher Avatar -->
                                            <div class="flex-shrink-0">
                                                <div class="w-14 h-14 rounded-xl bg-gradient-to-r from-emerald-100 to-teal-100 flex items-center justify-center">
                                                    <svg class="w-7 h-7 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                </div>
                                            </div>

                                            <!-- Application Details -->
                                            <div class="flex-1 min-w-0">
                                                <div class="flex flex-wrap items-center gap-2 mb-2">
                                                    <h3 class="text-xl font-bold text-gray-900">
                                                        {{ application.teacher.name }}
                                                    </h3>
                                                    <span class="px-3 py-1 rounded-full text-xs font-bold"
                                                          :class="statusColor(application.status)">
                                                        {{ formatStatus(application.status) }}
                                                    </span>
                                                    <span class="text-sm text-gray-500">
                                                        Applied {{ formatDate(application.created_at) }}
                                                    </span>
                                                </div>

                                                <p class="text-emerald-700 font-medium mb-3">
                                                    <span class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                        </svg>
                                                        {{ application.job.title }}
                                                    </span>
                                                    <span class="text-sm text-gray-600 ml-5">
                                                        {{ application.job.subject | formatSubject }} • {{ application.job.level | formatLevel }}
                                                    </span>
                                                </p>

                                                <!-- Teacher Metadata -->
                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                                    <!-- Qualification -->
                                                    <div class="flex items-center p-3 bg-emerald-50 rounded-xl">
                                                        <div class="p-2 rounded-lg bg-emerald-100 mr-3">
                                                            <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <p class="text-xs text-emerald-600">Qualification</p>
                                                            <p class="text-sm font-semibold text-gray-900">{{ application.teacher.teacher_profile?.qualification || 'Not specified' }}</p>
                                                        </div>
                                                    </div>

                                                    <!-- Experience -->
                                                    <div class="flex items-center p-3 bg-emerald-50 rounded-xl">
                                                        <div class="p-2 rounded-lg bg-emerald-100 mr-3">
                                                            <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <p class="text-xs text-emerald-600">Experience</p>
                                                            <p class="text-sm font-semibold text-gray-900">{{ application.teacher.teacher_profile?.years_of_experience || '0' }} years</p>
                                                        </div>
                                                    </div>

                                                    <!-- Appraisal Score -->
                                                    <div class="flex items-center p-3 bg-emerald-50 rounded-xl">
                                                        <div class="p-2 rounded-lg bg-emerald-100 mr-3">
                                                            <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <p class="text-xs text-emerald-600">Appraisal Score</p>
                                                            <p class="text-sm font-bold text-emerald-700">
                                                                {{ application.teacher.appraisals?.[0]?.score || 'N/A' }}/100
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Cover Letter Preview -->
                                                <div v-if="application.cover_letter" class="mt-4">
                                                    <p class="text-sm text-gray-600 mb-1 font-semibold">Cover Letter:</p>
                                                    <p class="text-sm text-gray-700 line-clamp-2">{{ application.cover_letter }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="mt-4 lg:mt-0 lg:ml-6 space-y-3">
                                        <Link
                                            :href="route('school.applications.show', application.id)"
                                            class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-bold rounded-xl shadow-lg text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-4 focus:ring-emerald-300 transition transform hover:-translate-y-0.5 w-full"
                                        >
                                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            View Details
                                        </Link>

                                        <div class="flex space-x-2">
                                            <button
                                                @click="updateStatus(application.id, 'shortlisted')"
                                                v-if="application.status !== 'shortlisted'"
                                                class="flex-1 inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-semibold rounded-xl text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-300 transition"
                                            >
                                                <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Shortlist
                                            </button>
                                            <button
                                                @click="updateStatus(application.id, 'rejected')"
                                                v-if="application.status !== 'rejected'"
                                                class="flex-1 inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-semibold rounded-xl text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300 transition"
                                            >
                                                <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Reject
                                            </button>
                                        </div>
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
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">No applications found</h3>
                            <p class="text-emerald-600 max-w-md mx-auto mb-6">
                                {{ filtersApplied ? 'Try adjusting your filters or check back later for new applications.' : 'Start by posting teaching jobs to receive applications from qualified teachers.' }}
                            </p>
                            <Link
                                :href="route('school.jobs.create')"
                                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-bold rounded-xl shadow-lg text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-4 focus:ring-emerald-300 transition transform hover:-translate-y-0.5"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Post a Job
                            </Link>
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
import { Link, router } from '@inertiajs/vue3'
import { ref, watch, computed } from 'vue'
import { debounce } from 'lodash'

const props = defineProps({
    applications: Object,
    jobs: {
        type: Array,
        default: () => []
    },
    filters: {
        type: Object,
        default: () => ({})
    }
})

const filters = ref({
    status: props.filters.status || '',
    job_id: props.filters.job_id || '',
    search: props.filters.search || '',
    sort: props.filters.sort || 'newest'
})

const filtersApplied = computed(() => {
    return filters.value.status || filters.value.job_id || filters.value.search || filters.value.sort !== 'newest'
})

// Watch filters with debounce
watch(filters, debounce((value) => {
    router.get(route('school.applications'), value, {
        preserveState: true,
        replace: true
    })
}, 300), { deep: true })

const resetFilters = () => {
    filters.value = {
        status: '',
        job_id: '',
        search: '',
        sort: 'newest'
    }
}

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric'
    })
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
                // Refresh the page to show updated status
                router.reload({ only: ['applications'] })
            }
        })
    }
}
</script>
