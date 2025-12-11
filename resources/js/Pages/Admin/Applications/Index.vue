<template>
    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Applications Management
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Stats -->
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-5 mb-6">
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Total</dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ stats.total }}</dd>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Pending</dt>
                            <dd class="mt-1 text-3xl font-semibold text-yellow-600">{{ stats.pending }}</dd>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Reviewed</dt>
                            <dd class="mt-1 text-3xl font-semibold text-blue-600">{{ stats.reviewed }}</dd>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Shortlisted</dt>
                            <dd class="mt-1 text-3xl font-semibold text-green-600">{{ stats.shortlisted }}</dd>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Rejected</dt>
                            <dd class="mt-1 text-3xl font-semibold text-red-600">{{ stats.rejected }}</dd>
                        </div>
                    </div>
                </div>

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
                                placeholder="Teacher or job title..."
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
                                <option value="pending">Pending</option>
                                <option value="reviewed">Reviewed</option>
                                <option value="shortlisted">Shortlisted</option>
                                <option value="rejected">Rejected</option>
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

                <!-- Applications List -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            All Applications
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Manage and monitor all job applications in the system.
                        </p>
                    </div>

                    <ul class="divide-y divide-gray-200">
                        <li v-for="application in applications.data" :key="application.id" class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="text-lg font-medium text-gray-900">
                                                {{ application.teacher.name }}
                                            </h3>
                                            <p class="text-sm text-gray-600 mt-1">
                                                Applied for: {{ application.job.title }}
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                {{ application.job.school.school_profile.school_name }} •
                                                {{ formatDate(application.created_at) }}
                                            </p>
                                        </div>
                                        <div class="ml-2 flex-shrink-0 flex">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                                  :class="applicationStatusClass(application.status)">
                                                {{ application.status.toUpperCase() }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Teacher Information -->
                                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900 mb-2">Teacher Profile</h4>
                                            <div class="text-sm text-gray-600 space-y-1">
                                                <div v-if="application.teacher.teacher_profile">
                                                    <span class="font-medium">Qualification:</span> {{ application.teacher.teacher_profile.qualification }}
                                                </div>
                                                <div v-if="application.teacher.teacher_profile">
                                                    <span class="font-medium">Experience:</span> {{ application.teacher.teacher_profile.years_of_experience }} years
                                                </div>
                                                <div v-if="application.teacher.teacher_profile">
                                                    <span class="font-medium">Specialization:</span> {{ application.teacher.teacher_profile.specialization }}
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900 mb-2">Application Details</h4>
                                            <div class="text-sm text-gray-600 space-y-1">
                                                <div>
                                                    <span class="font-medium">Job:</span> {{ application.job.title }}
                                                </div>
                                                <div>
                                                    <span class="font-medium">Subject:</span> {{ application.job.subject.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase()) }}
                                                </div>
                                                <div>
                                                    <span class="font-medium">Level:</span> {{ application.job.level.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase()) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Cover Letter -->
                                    <div v-if="application.cover_letter" class="mt-4">
                                        <h4 class="text-sm font-medium text-gray-900 mb-2">Cover Letter</h4>
                                        <p class="text-sm text-gray-600 line-clamp-2">
                                            {{ application.cover_letter }}
                                        </p>
                                    </div>

                                    <!-- School Feedback -->
                                    <div v-if="application.school_feedback" class="mt-3 bg-blue-50 border border-blue-200 rounded-md p-3">
                                        <p class="text-sm text-blue-800">
                                            <strong>School Feedback:</strong> {{ application.school_feedback }}
                                        </p>
                                    </div>
                                </div>

                                <div class="ml-4 flex-shrink-0 flex flex-col space-y-2">
                                    <Link
                                        :href="route('admin.teachers.show', application.teacher.id)"
                                        class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                    >
                                        View Teacher
                                    </Link>
                                    <Link
                                        :href="route('admin.jobs.show', application.job.id)"
                                        class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                    >
                                        View Job
                                    </Link>
                                    <button
                                        @click="openStatusModal(application)"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                    >
                                        Update Status
                                    </button>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <!-- Pagination -->
                    <div v-if="applications.links.length > 3" class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                        <div class="flex-1 flex justify-between sm:hidden">
                            <Link
                                :href="applications.prev_page_url"
                                :class="{'opacity-50 cursor-not-allowed': !applications.prev_page_url}"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                            >
                                Previous
                            </Link>
                            <Link
                                :href="applications.next_page_url"
                                :class="{'opacity-50 cursor-not-allowed': !applications.next_page_url}"
                                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                            >
                                Next
                            </Link>
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Showing
                                    <span class="font-medium">{{ applications.from }}</span>
                                    to
                                    <span class="font-medium">{{ applications.to }}</span>
                                    of
                                    <span class="font-medium">{{ applications.total }}</span>
                                    applications
                                </p>
                            </div>
                            <div>
                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                    <Link
                                        v-for="(link, index) in applications.links"
                                        :key="index"
                                        :href="link.url"
                                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                                        :class="{
                                            'bg-blue-50 border-blue-500 text-blue-600 z-10': link.active,
                                            'rounded-l-md': index === 0,
                                            'rounded-r-md': index === applications.links.length - 1
                                        }"
                                        v-html="link.label"
                                    ></Link>
                                </nav>
                            </div>
                        </div>
                    </div>

                    <!-- Empty State -->
                    <div v-if="applications.data.length === 0" class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No applications found</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            No applications match your current filters.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Update Modal -->
        <div v-if="showStatusModal" class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50">
            <div class="fixed inset-0 transform transition-all">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full sm:mx-auto">
                <div class="px-6 py-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Update Application Status</h3>

                    <form @submit.prevent="updateApplicationStatus">
                        <div class="space-y-4">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select
                                    id="status"
                                    v-model="statusForm.status"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                >
                                    <option value="pending">Pending</option>
                                    <option value="reviewed">Reviewed</option>
                                    <option value="shortlisted">Shortlisted</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>

                            <div>
                                <label for="school_feedback" class="block text-sm font-medium text-gray-700">Feedback (Optional)</label>
                                <textarea
                                    id="school_feedback"
                                    v-model="statusForm.school_feedback"
                                    rows="3"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    placeholder="Add feedback for the teacher..."
                                ></textarea>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <button
                                type="button"
                                @click="closeStatusModal"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                :disabled="statusForm.processing"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
                            >
                                {{ statusForm.processing ? 'Updating...' : 'Update Status' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, router, useForm } from '@inertiajs/vue3'
import { ref, watch } from 'vue'
import { debounce } from 'lodash'

const props = defineProps({
    applications: Object,
    stats: Object,
    filters: Object
})

const filters = ref({
    search: props.filters.search || '',
    status: props.filters.status || ''
})

const showStatusModal = ref(false)
const selectedApplication = ref(null)

const statusForm = useForm({
    status: '',
    school_feedback: ''
})

// Watch filters with debounce
watch(filters, debounce((value) => {
    router.get(route('admin.applications'), value, {
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
        month: 'short',
        day: 'numeric'
    })
}

const openStatusModal = (application) => {
    selectedApplication.value = application
    statusForm.status = application.status
    statusForm.school_feedback = application.school_feedback || ''
    showStatusModal.value = true
}

const closeStatusModal = () => {
    showStatusModal.value = false
    selectedApplication.value = null
    statusForm.reset()
}

const updateApplicationStatus = () => {
    if (selectedApplication.value) {
        statusForm.post(route('admin.applications.update-status', selectedApplication.value.id), {
            preserveScroll: true,
            onSuccess: () => {
                closeStatusModal()
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
