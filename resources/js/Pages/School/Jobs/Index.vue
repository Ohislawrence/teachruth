<template>
    <AppLayout title="My Job Postings">
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
                                    <h1 class="text-xl font-bold text-white">My Job Postings</h1>
                                    <p class="text-xs text-emerald-100">Manage your teaching positions</p>
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
                                :href="route('school.applications')"
                                class="text-sm font-medium text-white hover:text-emerald-100 transition"
                            >
                                Applications
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
                                <h2 class="text-3xl font-bold text-gray-900">Teaching Positions</h2>
                                <p class="text-emerald-700 mt-2">Create and manage job openings at your school</p>
                            </div>
                            <div class="mt-4 sm:mt-0">
                                <Link
                                    :href="route('school.jobs.create')"
                                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-bold rounded-xl shadow-lg text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-4 focus:ring-emerald-300 transition transform hover:-translate-y-0.5"
                                >
                                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Post New Job
                                </Link>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                        <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-xl bg-emerald-100 mr-4">
                                    <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-emerald-600">Total Jobs</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ stats.total_jobs }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-xl bg-green-100 mr-4">
                                    <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-emerald-600">Active Jobs</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ stats.active_jobs }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-xl bg-blue-100 mr-4">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-emerald-600">Applications</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ stats.total_applications }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-xl bg-yellow-100 mr-4">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-emerald-600">Pending Review</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ stats.pending_applications }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Jobs Table -->
                    <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-emerald-100">
                                <thead class="bg-gradient-to-r from-emerald-50 to-teal-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-emerald-700 uppercase tracking-wider">
                                            Position
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-emerald-700 uppercase tracking-wider">
                                            Subject & Level
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-emerald-700 uppercase tracking-wider">
                                            Applications
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-emerald-700 uppercase tracking-wider">
                                            Deadline
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-emerald-700 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-emerald-700 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-emerald-100">
                                    <tr v-for="job in jobs.data" :key="job.id" class="hover:bg-emerald-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div>
                                                <div class="text-sm font-bold text-gray-900">{{ job.title }}</div>
                                                <div class="text-sm text-emerald-600">
                                                    {{ formatEmploymentType(job.employment_type) }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ formatSubjectName(job.subject) }}</div>
                                            <div class="text-sm text-gray-500">{{ formatLevelName(job.level) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center mr-3">
                                                    <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-bold text-gray-900">{{ job.applications_count }}</div>
                                                    <div class="text-xs text-emerald-600">
                                                        <Link :href="route('school.jobs.applicants', job.id)" class="hover:text-emerald-700">
                                                            View applicants
                                                        </Link>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ formatDate(job.application_deadline) }}</div>
                                            <div class="text-xs" :class="getDaysLeft(job.application_deadline) <= 3 ? 'text-red-600' : 'text-amber-600'">
                                                {{ getDaysLeft(job.application_deadline) }} days left
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full"
                                                  :class="job.is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'">
                                                {{ job.is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <Link
                                                    :href="route('school.jobs.edit', job.id)"
                                                    class="text-emerald-600 hover:text-emerald-900 p-2 rounded-lg hover:bg-emerald-100 transition"
                                                    title="Edit"
                                                >
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </Link>
                                                <button
                                                    @click="toggleStatus(job)"
                                                    class="text-blue-600 hover:text-blue-900 p-2 rounded-lg hover:bg-blue-100 transition"
                                                    :title="job.is_active ? 'Deactivate' : 'Activate'"
                                                >
                                                    <svg v-if="job.is_active" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                    </svg>
                                                    <svg v-else class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </button>
                                                <button
                                                    @click="deleteJob(job)"
                                                    class="text-red-600 hover:text-red-900 p-2 rounded-lg hover:bg-red-100 transition"
                                                    title="Delete"
                                                >
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Empty State -->
                        <div v-if="jobs.data.length === 0" class="text-center py-16">
                            <div class="mx-auto w-24 h-24 bg-gradient-to-r from-emerald-100 to-teal-100 rounded-full flex items-center justify-center mb-6">
                                <svg class="w-12 h-12 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">No job postings yet</h3>
                            <p class="text-emerald-600 max-w-md mx-auto mb-6">
                                Start by creating your first teaching position to attract qualified teachers.
                            </p>
                            <Link
                                :href="route('school.jobs.create')"
                                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-bold rounded-xl shadow-lg text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-4 focus:ring-emerald-300 transition transform hover:-translate-y-0.5"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Post Your First Job
                            </Link>
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
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
    jobs: Object,
    stats: Object
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

const formatEmploymentType = (type) => {
    return type.replace(/_/g, ' ').toUpperCase()
}

const getDaysLeft = (deadline) => {
    const deadlineDate = new Date(deadline)
    const today = new Date()
    const diffTime = deadlineDate - today
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24))
    return Math.max(0, diffDays)
}

const toggleStatus = (job) => {
    if (confirm(`Are you sure you want to ${job.is_active ? 'deactivate' : 'activate'} this job posting?`)) {
        router.patch(route('school.jobs.update', job.id), {
            is_active: !job.is_active
        }, {
            preserveScroll: true,
            onSuccess: () => {
                router.reload({ only: ['jobs'] })
            }
        })
    }
}

const deleteJob = (job) => {
    if (confirm('Are you sure you want to delete this job posting? This action cannot be undone.')) {
        if (job.applications_count > 0) {
            alert('Cannot delete job with existing applications. Please deactivate it instead.')
            return
        }

        router.delete(route('school.jobs.delete', job.id), {
            preserveScroll: true,
            onSuccess: () => {
                router.reload({ only: ['jobs'] })
            }
        })
    }
}
</script>
