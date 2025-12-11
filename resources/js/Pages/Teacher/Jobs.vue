<template>
    <AppLayout title="Teaching Jobs">
        <div class="min-h-screen bg-gradient-to-b from-emerald-50 via-teal-50 to-white">
            <!-- Navigation -->
            <nav class="bg-gradient-to-r from-emerald-600 to-teal-600 shadow-lg">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-white/20 rounded-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h1 class="text-xl font-bold text-white">Teaching Jobs</h1>
                                    <p class="text-xs text-emerald-100">Find your next teaching opportunity</p>
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
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <!-- Header -->
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold text-gray-900">Available Teaching Positions</h2>
                        <p class="text-emerald-700 mt-2">Browse and apply to the best teaching opportunities</p>
                    </div>

                    <!-- Filters Card -->
                    <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 p-6 mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <!-- Search -->
                            <div>
                                <label for="search" class="block text-sm font-semibold text-emerald-700 mb-2">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                        Search Jobs
                                    </div>
                                </label>
                                <input
                                    type="text"
                                    id="search"
                                    v-model="filters.search"
                                    placeholder="Job title, school name..."
                                    class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                                />
                            </div>

                            <!-- Subject -->
                            <div>
                                <label for="subject" class="block text-sm font-semibold text-emerald-700 mb-2">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                        Subject
                                    </div>
                                </label>
                                <select
                                    id="subject"
                                    v-model="filters.subject"
                                    class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition bg-white"
                                >
                                    <option value="">All Subjects</option>
                                    <option v-for="subject in subjects" :key="subject" :value="subject" class="py-2">
                                        {{ formatSubjectName(subject) }}
                                    </option>
                                </select>
                            </div>

                            <!-- Level -->
                            <div>
                                <label for="level" class="block text-sm font-semibold text-emerald-700 mb-2">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        Grade Level
                                    </div>
                                </label>
                                <select
                                    id="level"
                                    v-model="filters.level"
                                    class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition bg-white"
                                >
                                    <option value="">All Levels</option>
                                    <option value="nursery">Nursery School</option>
                                    <option value="primary">Primary School</option>
                                    <option value="junior_secondary">Junior Secondary</option>
                                    <option value="senior_secondary">Senior Secondary</option>
                                </select>
                            </div>

                            <!-- State -->
                            <div>
                                <label for="state" class="block text-sm font-semibold text-emerald-700 mb-2">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Location
                                    </div>
                                </label>
                                <input
                                    type="text"
                                    id="state"
                                    v-model="filters.state"
                                    placeholder="State or city..."
                                    class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                                />
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
                                <span class="font-bold text-emerald-700 text-lg">{{ jobs.total }}</span>
                                <span class="text-gray-600 ml-1">job{{ jobs.total !== 1 ? 's' : '' }} found</span>
                            </div>
                        </div>
                    </div>

                    <!-- Jobs List -->
                    <div class="space-y-6">
                        <!-- Job Cards -->
                        <div v-for="job in jobs.data" :key="job.id"
                             class="bg-white shadow-xl rounded-2xl border border-emerald-100 overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                            <div class="p-6">
                                <div class="flex flex-col lg:flex-row lg:items-start justify-between">
                                    <!-- Job Info -->
                                    <div class="flex-1">
                                        <div class="flex items-start space-x-4">
                                            <!-- School Icon -->
                                            <div class="flex-shrink-0">
                                                <div class="w-14 h-14 rounded-xl bg-gradient-to-r from-emerald-100 to-teal-100 flex items-center justify-center">
                                                    <svg class="w-7 h-7 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                    </svg>
                                                </div>
                                            </div>

                                            <!-- Job Details -->
                                            <div class="flex-1 min-w-0">
                                                <div class="flex flex-wrap items-center gap-2 mb-2">
                                                    <h3 class="text-xl font-bold text-gray-900 truncate">
                                                        {{ job.title }}
                                                    </h3>
                                                    <span class="px-3 py-1 rounded-full text-xs font-bold"
                                                          :class="employmentTypeColor(job.employment_type)">
                                                        {{ formatEmploymentType(job.employment_type) }}
                                                    </span>
                                                </div>

                                                <p class="text-emerald-700 font-medium mb-3">
                                                    <span class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                        </svg>
                                                        {{ job.school.school_profile.school_name }}
                                                    </span>
                                                    <span class="text-sm text-gray-600 ml-5">
                                                        {{ job.state }}, {{ job.lga }}
                                                    </span>
                                                </p>

                                                <!-- Job Metadata -->
                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                                    <!-- Subject -->
                                                    <div class="flex items-center p-3 bg-emerald-50 rounded-xl">
                                                        <div class="p-2 rounded-lg bg-emerald-100 mr-3">
                                                            <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <p class="text-xs text-emerald-600">Subject</p>
                                                            <p class="text-sm font-semibold text-gray-900">{{ formatSubjectName(job.subject) }}</p>
                                                        </div>
                                                    </div>

                                                    <!-- Level -->
                                                    <div class="flex items-center p-3 bg-emerald-50 rounded-xl">
                                                        <div class="p-2 rounded-lg bg-emerald-100 mr-3">
                                                            <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <p class="text-xs text-emerald-600">Level</p>
                                                            <p class="text-sm font-semibold text-gray-900">{{ formatLevelName(job.level) }}</p>
                                                        </div>
                                                    </div>

                                                    <!-- Salary -->
                                                    <div class="flex items-center p-3 bg-emerald-50 rounded-xl">
                                                        <div class="p-2 rounded-lg bg-emerald-100 mr-3">
                                                            <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <p class="text-xs text-emerald-600">Salary Range</p>
                                                            <p class="text-sm font-bold text-emerald-700">{{ job.salary_range }}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Deadline -->
                                                <div class="mt-4 flex items-center text-sm">
                                                    <div class="flex items-center text-amber-600 bg-amber-50 px-3 py-1.5 rounded-lg">
                                                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        <span class="font-semibold">Apply before {{ formatDate(job.application_deadline) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Button -->
                                    <div class="mt-4 lg:mt-0 lg:ml-6">
                                        <Link
                                            :href="route('teacher.jobs.show', job.id)"
                                            class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-bold rounded-xl shadow-lg text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-4 focus:ring-emerald-300 transition transform hover:-translate-y-0.5"
                                        >
                                            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            View Details
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Empty State -->
                        <div v-if="jobs.data.length === 0" class="text-center py-16 bg-white shadow-xl rounded-2xl border border-emerald-100">
                            <div class="mx-auto w-24 h-24 bg-gradient-to-r from-emerald-100 to-teal-100 rounded-full flex items-center justify-center mb-6">
                                <svg class="w-12 h-12 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">No jobs matching your criteria</h3>
                            <p class="text-emerald-600 max-w-md mx-auto mb-6">
                                Try adjusting your search filters or check back soon for new opportunities.
                            </p>
                            <button
                                @click="resetFilters"
                                class="inline-flex items-center px-6 py-3 border-2 border-emerald-300 text-base font-semibold rounded-xl text-emerald-700 bg-white hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-200 transition"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Clear All Filters
                            </button>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div v-if="jobs.links.length > 3" class="mt-8 bg-white shadow-xl rounded-2xl border border-emerald-100 p-6">
                        <div class="flex flex-col sm:flex-row items-center justify-between">
                            <div class="mb-4 sm:mb-0">
                                <p class="text-sm text-gray-700">
                                    Showing
                                    <span class="font-bold text-emerald-700">{{ jobs.from }}</span>
                                    to
                                    <span class="font-bold text-emerald-700">{{ jobs.to }}</span>
                                    of
                                    <span class="font-bold text-emerald-700">{{ jobs.total }}</span>
                                    jobs
                                </p>
                            </div>
                            <nav class="flex space-x-1">
                                <Link
                                    v-for="(link, index) in jobs.links"
                                    :key="index"
                                    :href="link.url"
                                    class="min-w-[40px] h-10 flex items-center justify-center border border-emerald-200 text-sm font-medium rounded-lg transition"
                                    :class="{
                                        'bg-gradient-to-r from-emerald-600 to-teal-600 text-white border-emerald-600 shadow-lg': link.active,
                                        'text-emerald-700 hover:bg-emerald-50 hover:border-emerald-300': !link.active && link.url,
                                        'text-gray-400 cursor-not-allowed': !link.url,
                                        'rounded-l-lg': index === 0,
                                        'rounded-r-lg': index === jobs.links.length - 1
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
import { Link, router } from '@inertiajs/vue3'
import { ref, watch, computed } from 'vue'
import { debounce } from 'lodash'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
    jobs: Object,
    filters: Object
})

const filters = ref({
    search: props.filters.search || '',
    subject: props.filters.subject || '',
    level: props.filters.level || '',
    state: props.filters.state || ''
})

const subjects = computed(() => {
    return [
        'mathematics', 'english', 'science', 'social_studies', 'physics', 'chemistry',
        'biology', 'history', 'geography', 'computer_science', 'physical_education',
        'arts', 'music', 'french', 'yoruba', 'igbo', 'hausa', 'other'
    ]
})

// Watch filters with debounce
watch(filters, debounce((value) => {
    router.get(route('teacher.jobs'), value, {
        preserveState: true,
        replace: true
    })
}, 300), { deep: true })

const resetFilters = () => {
    filters.value = {
        search: '',
        subject: '',
        level: '',
        state: ''
    }
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

const formatLevelName = (level) => {
    return level.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())
}

const formatEmploymentType = (type) => {
    return type.replace(/_/g, ' ').toUpperCase()
}

const employmentTypeColor = (type) => {
    const colors = {
        'full_time': 'bg-emerald-100 text-emerald-800',
        'part_time': 'bg-blue-100 text-blue-800',
        'contract': 'bg-amber-100 text-amber-800',
        'temporary': 'bg-purple-100 text-purple-800'
    }
    return colors[type] || 'bg-gray-100 text-gray-800'
}
</script>
