<template>
    <AppLayout>
        <template #header>
            <div class="flex items-center">
                <Link :href="route('admin.jobs')" class="text-gray-600 hover:text-gray-900 mr-4">
                    ← Back to Jobs
                </Link>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Job Details
                </h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <!-- Job Header -->
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <div class="flex justify-between items-start">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">{{ job.title }}</h1>
                                <p class="mt-1 text-lg text-gray-600">{{ job.school.school_profile.school_name }}</p>
                                <p class="text-sm text-gray-500">{{ job.school.school_profile.address }}, {{ job.state }}, {{ job.lga }}</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"
                                      :class="jobStatusClass(job)">
                                    {{ jobStatusText(job) }}
                                </span>
                                <p class="mt-2 text-lg font-semibold text-gray-900">{{ job.salary_range }}</p>
                                <button
                                    @click="toggleJobStatus(job)"
                                    class="mt-2 inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                    :class="job.is_active ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700'"
                                >
                                    {{ job.is_active ? 'Deactivate Job' : 'Activate Job' }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Job Details -->
                    <div class="px-4 py-5 sm:p-6">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Main Content -->
                            <div class="lg:col-span-2">
                                <!-- Job Description -->
                                <div class="mb-8">
                                    <h2 class="text-lg font-medium text-gray-900 mb-4">Job Description</h2>
                                    <div class="prose max-w-none text-gray-700 whitespace-pre-line">
                                        {{ job.description }}
                                    </div>
                                </div>

                                <!-- Requirements -->
                                <div class="mb-8">
                                    <h2 class="text-lg font-medium text-gray-900 mb-4">Job Requirements</h2>
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Subject</dt>
                                                <dd class="mt-1 text-sm text-gray-900 capitalize">
                                                    {{ job.subject.replace('_', ' ') }}
                                                </dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Level</dt>
                                                <dd class="mt-1 text-sm text-gray-900 capitalize">
                                                    {{ job.level.replace('_', ' ') }}
                                                </dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Class/Grade</dt>
                                                <dd class="mt-1 text-sm text-gray-900">
                                                    {{ job.class_grade || 'Not specified' }}
                                                </dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Employment Type</dt>
                                                <dd class="mt-1 text-sm text-gray-900 capitalize">
                                                    {{ job.employment_type.replace('_', ' ') }}
                                                </dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Application Deadline</dt>
                                                <dd class="mt-1 text-sm text-gray-900">
                                                    {{ formatDate(job.application_deadline) }}
                                                </dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Days Left</dt>
                                                <dd class="mt-1 text-sm font-medium" :class="daysLeft <= 3 ? 'text-red-600' : 'text-green-600'">
                                                    {{ daysLeft }} day{{ daysLeft !== 1 ? 's' : '' }}
                                                </dd>
                                            </div>
                                        </dl>
                                    </div>
                                </div>

                                <!-- Applications Section -->
                                <div>
                                    <h2 class="text-lg font-medium text-gray-900 mb-4">Applications ({{ job.applications.length }})</h2>
                                    <div v-if="job.applications.length > 0" class="space-y-4">
                                        <div v-for="application in job.applications" :key="application.id"
                                             class="border border-gray-200 rounded-lg p-4">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <h4 class="text-sm font-medium text-gray-900">{{ application.teacher.name }}</h4>
                                                    <p class="text-sm text-gray-600">{{ application.teacher.email }}</p>
                                                    <p class="text-xs text-gray-500">
                                                        Applied {{ formatDate(application.created_at) }}
                                                    </p>
                                                    <div v-if="application.teacher.teacher_profile" class="mt-1 text-xs text-gray-600">
                                                        {{ application.teacher.teacher_profile.qualification }} •
                                                        {{ application.teacher.teacher_profile.years_of_experience }} years experience
                                                    </div>
                                                    <div v-if="application.cover_letter" class="mt-2">
                                                        <p class="text-sm text-gray-700 line-clamp-2">{{ application.cover_letter }}</p>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                                          :class="applicationStatusClass(application.status)">
                                                        {{ application.status.toUpperCase() }}
                                                    </span>
                                                    <div v-if="application.school_feedback" class="mt-1 text-xs text-gray-500 max-w-xs">
                                                        {{ application.school_feedback }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else class="text-center py-8 bg-gray-50 rounded-lg">
                                        <p class="text-gray-500">No applications yet.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Sidebar -->
                            <div class="space-y-6">
                                <!-- School Information -->
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">School Information</h3>
                                    <div class="space-y-3">
                                        <div class="flex items-center">
                                            <svg class="h-5 w-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                            <span class="text-sm text-gray-700">{{ job.school.school_profile.school_type.toUpperCase() }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="h-5 w-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <span class="text-sm text-gray-700">{{ job.school.school_profile.state }}, {{ job.school.school_profile.lga }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="h-5 w-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                            <span class="text-sm text-gray-700 capitalize">{{ job.school.school_profile.ownership }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="h-5 w-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                            <span class="text-sm text-gray-700">{{ job.school.email }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="h-5 w-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                            <span class="text-sm text-gray-700">{{ job.school.school_profile.phone }}</span>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <Link
                                            :href="route('admin.schools.show', job.school.id)"
                                            class="text-sm font-medium text-blue-600 hover:text-blue-500"
                                        >
                                            View School Profile →
                                        </Link>
                                    </div>
                                </div>

                                <!-- Important Dates -->
                                <div class="bg-blue-50 rounded-lg p-6">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Important Dates</h3>
                                    <div class="space-y-2">
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Posted:</span>
                                            <span class="text-sm font-medium text-gray-900">{{ formatDate(job.created_at) }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Deadline:</span>
                                            <span class="text-sm font-medium text-gray-900">{{ formatDate(job.application_deadline) }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Days Left:</span>
                                            <span class="text-sm font-medium" :class="daysLeft <= 3 ? 'text-red-600' : 'text-green-600'">
                                                {{ daysLeft }} day{{ daysLeft !== 1 ? 's' : '' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Quick Actions -->
                                <div class="bg-white border border-gray-200 rounded-lg p-6">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                                    <div class="space-y-3">
                                        <Link
                                            :href="route('admin.applications', { job: job.id })"
                                            class="w-full flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                        >
                                            View All Applications
                                        </Link>
                                        <button
                                            @click="toggleJobStatus(job)"
                                            class="w-full flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                            :class="job.is_active ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700'"
                                        >
                                            {{ job.is_active ? 'Deactivate Job' : 'Activate Job' }}
                                        </button>
                                    </div>
                                </div>
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
    job: Object
})

const daysLeft = computed(() => {
    const deadline = new Date(props.job.application_deadline)
    const today = new Date()
    const diffTime = deadline - today
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24))
    return Math.max(0, diffDays)
})

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

const applicationStatusClass = (status) => {
    const classes = {
        'pending': 'bg-yellow-100 text-yellow-800',
        'reviewed': 'bg-blue-100 text-blue-800',
        'shortlisted': 'bg-green-100 text-green-800',
        'rejected': 'bg-red-100 text-red-800'
    }
    return classes[status] || 'bg-gray-100 text-gray-800'
}

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
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

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
