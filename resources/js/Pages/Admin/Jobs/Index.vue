<template>
    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Jobs Management
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Filters -->
                <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Search -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                            <input
                                type="text"
                                id="search"
                                v-model="filters.search"
                                placeholder="Job title, school name..."
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            />
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select
                                id="status"
                                v-model="filters.status"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            >
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="expired">Expired</option>
                            </select>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-end space-x-2">
                            <button
                                @click="resetFilters"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            >
                                Reset
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Jobs List -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            All Job Postings
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Manage and monitor all job postings in the system.
                        </p>
                    </div>

                    <ul class="divide-y divide-gray-200">
                        <li v-for="job in jobs.data" :key="job.id" class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="text-lg font-medium text-gray-900">
                                                {{ job.title }}
                                            </h3>
                                            <p class="text-sm text-gray-600 mt-1">
                                                {{ job.school.school_profile.school_name }} •
                                                {{ job.state }}, {{ job.lga }}
                                            </p>
                                        </div>
                                        <div class="ml-2 flex-shrink-0 flex space-x-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                                  :class="jobStatusClass(job)">
                                                {{ jobStatusText(job) }}
                                            </span>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ job.applications_count }} applications
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mt-2 sm:flex sm:justify-between">
                                        <div class="sm:flex space-y-2 sm:space-y-0 sm:space-x-6">
                                            <div class="flex items-center text-sm text-gray-500">
                                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ job.subject.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase()) }}
                                            </div>
                                            <div class="flex items-center text-sm text-gray-500">
                                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                </svg>
                                                {{ job.level.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase()) }}
                                            </div>
                                            <div class="flex items-center text-sm text-gray-500">
                                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                                </svg>
                                                {{ job.salary_range }}
                                            </div>
                                        </div>
                                        <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span>
                                                Deadline: {{ formatDate(job.application_deadline) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="ml-4 flex-shrink-0 flex flex-col space-y-2">
                                    <Link
                                        :href="route('admin.jobs.show', job.id)"
                                        class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                    >
                                        View Details
                                    </Link>
                                    <button
                                        @click="toggleJobStatus(job)"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                        :class="job.is_active ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700'"
                                    >
                                        {{ job.is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <!-- Pagination -->
                    <div v-if="jobs.links.length > 3" class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                        <div class="flex-1 flex justify-between sm:hidden">
                            <Link
                                :href="jobs.prev_page_url"
                                :class="{'opacity-50 cursor-not-allowed': !jobs.prev_page_url}"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                            >
                                Previous
                            </Link>
                            <Link
                                :href="jobs.next_page_url"
                                :class="{'opacity-50 cursor-not-allowed': !jobs.next_page_url}"
                                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                            >
                                Next
                            </Link>
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Showing
                                    <span class="font-medium">{{ jobs.from }}</span>
                                    to
                                    <span class="font-medium">{{ jobs.to }}</span>
                                    of
                                    <span class="font-medium">{{ jobs.total }}</span>
                                    jobs
                                </p>
                            </div>
                            <div>
                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                    <Link
                                        v-for="(link, index) in jobs.links"
                                        :key="index"
                                        :href="link.url"
                                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                                        :class="{
                                            'bg-blue-50 border-blue-500 text-blue-600 z-10': link.active,
                                            'rounded-l-md': index === 0,
                                            'rounded-r-md': index === jobs.links.length - 1
                                        }"
                                        v-html="link.label"
                                    ></Link>
                                </nav>
                            </div>
                        </div>
                    </div>

                    <!-- Empty State -->
                    <div v-if="jobs.data.length === 0" class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No jobs found</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            No job postings match your current filters.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { ref, watch } from 'vue'
import { debounce } from 'lodash'

const props = defineProps({
    jobs: Object,
    filters: Object
})

const filters = ref({
    search: props.filters.search || '',
    status: props.filters.status || ''
})

// Watch filters with debounce
watch(filters, debounce((value) => {
    router.get(route('admin.jobs'), value, {
        preserveState: true,
        replace: true
    })
}, 300), { deep: true })

const resetFilters = () => {
    filters.value = {
        search: '',
        status: ''
    }
}

const jobStatusClass = (job) => {
    if (!job.is_active) return 'bg-red-100 text-red-800'
    if (new Date(job.application_deadline) < new Date()) return 'bg-yellow-100 text-yellow-800'
    return 'bg-green-100 text-green-800'
}

const jobStatusText = (job) => {
    if (!job.is_active) return 'Inactive'
    if (new Date(job.application_deadline) < new Date()) return 'Expired'
    return 'Active'
}

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    })
}

const toggleJobStatus = (job) => {
    if (confirm(`Are you sure you want to ${job.is_active ? 'deactivate' : 'activate'} this job?`)) {
        router.post(route('admin.jobs.toggle-status', job.id), {}, {
            preserveScroll: true,
            onSuccess: () => {
                // The page will refresh with updated data
            }
        })
    }
}
</script>
