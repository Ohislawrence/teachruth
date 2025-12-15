<template>
    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Teachers Management
            </h2>
        </template>

        <!-- Success Message -->
        <div v-if="$page.props.flash.success" class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-50 border-l-4 border-green-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ $page.props.flash.success }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Error Message -->
        <div v-if="$page.props.flash.error" class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-50 border-l-4 border-red-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">{{ $page.props.flash.error }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Stats -->
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-4 mb-6">
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Teachers</dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ teachers.total }}</dd>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Active Profiles</dt>
                            <dd class="mt-1 text-3xl font-semibold text-green-600">{{ activeTeachersCount }}</dd>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">With Appraisals</dt>
                            <dd class="mt-1 text-3xl font-semibold text-blue-600">{{ teachersWithAppraisals }}</dd>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Avg. Score</dt>
                            <dd class="mt-1 text-3xl font-semibold text-purple-600">{{ averageScore }}%</dd>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Search -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                            <input
                                type="text"
                                id="search"
                                v-model="filters.search"
                                placeholder="Name, email, qualification..."
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            />
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

                <!-- Teachers List -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    All Teachers
                                </h3>
                                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                    Manage and monitor all registered teachers in the system.
                                </p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500">
                                    Total: {{ teachers.total }} teachers
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Teacher
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Profile
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Appraisals
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Applications
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="teacher in teachers.data" :key="teacher.id" class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full" :src="teacher.profile_photo_url || '/default-avatar.png'" :alt="teacher.name" />
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ teacher.name }}</div>
                                                <div class="text-sm text-gray-500">{{ teacher.email }}</div>
                                                <div class="text-xs text-gray-400">
                                                    Joined {{ formatDate(teacher.created_at) }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div v-if="teacher.teacher_profile" class="text-sm text-gray-900 space-y-1">
                                            <div class="font-medium">{{ teacher.teacher_profile.qualification }}</div>
                                            <div>{{ teacher.teacher_profile.specialization }}</div>
                                            <div class="text-xs text-gray-500">
                                                {{ teacher.teacher_profile.years_of_experience || 0 }} yrs exp
                                            </div>
                                        </div>
                                        <div v-else class="text-sm text-gray-500 italic">
                                            Profile incomplete
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ teacher.appraisals_count || 0 }} total
                                        </div>
                                        <div v-if="teacher.latest_appraisal" class="text-xs" :class="scoreColor(teacher.latest_appraisal.overall_score)">
                                            Latest: {{ teacher.latest_appraisal.overall_score }}%
                                        </div>
                                        <div v-else class="text-xs text-gray-500">
                                            No appraisals
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ teacher.job_applications_count || 0 }} applications
                                        <div v-if="teacher.job_applications_count > 0" class="text-xs text-gray-500">
                                            {{ getShortlistedCount(teacher) }} shortlisted
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                              :class="teacherStatusClass(teacher)">
                                            {{ teacherStatusText(teacher) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-3">
                                            <Link
                                                :href="safeRoute('admin.teachers.show', teacher.id)"
                                                class="text-blue-600 hover:text-blue-900"
                                            >
                                                View
                                            </Link>
                                            <button
                                                @click="toggleUserStatus(teacher)"
                                                :class="teacher.suspended_at ? 'text-green-600 hover:text-green-900' : 'text-yellow-600 hover:text-yellow-900'"
                                            >
                                                {{ teacher.suspended_at ? 'Unsuspend' : 'Suspend' }}
                                            </button>
                                            <button
                                                @click="confirmDeleteTeacher(teacher)"
                                                class="text-red-600 hover:text-red-900"
                                            >
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div v-if="teachers.links.length > 3" class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                        <div class="flex-1 flex justify-between sm:hidden">
                            <Link
                                :href="teachers.prev_page_url || '#'"
                                :class="{'opacity-50 cursor-not-allowed': !teachers.prev_page_url}"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                            >
                                Previous
                            </Link>
                            <Link
                                :href="teachers.next_page_url || '#'"
                                :class="{'opacity-50 cursor-not-allowed': !teachers.next_page_url}"
                                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                            >
                                Next
                            </Link>
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Showing
                                    <span class="font-medium">{{ teachers.from }}</span>
                                    to
                                    <span class="font-medium">{{ teachers.to }}</span>
                                    of
                                    <span class="font-medium">{{ teachers.total }}</span>
                                    teachers
                                </p>
                            </div>
                            <div>
                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                    <Link
                                        v-for="(link, index) in teachers.links"
                                        :key="index"
                                        :href="link.url || '#'"
                                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                                        :class="{
                                            'bg-blue-50 border-blue-500 text-blue-600 z-10': link.active,
                                            'rounded-l-md': index === 0,
                                            'rounded-r-md': index === teachers.links.length - 1,
                                            'opacity-50 cursor-not-allowed': !link.url
                                        }"
                                        v-html="link.label"
                                    ></Link>
                                </nav>
                            </div>
                        </div>
                    </div>

                    <!-- Empty State -->
                    <div v-if="teachers.data.length === 0" class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No teachers found</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            No teachers match your current search criteria.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div v-if="showDeleteModal" class="fixed inset-0 overflow-y-auto z-50">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Delete Teacher
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Are you sure you want to delete <strong>{{ teacherToDelete?.name }}</strong>? This action cannot be undone.
                                    </p>
                                    <div class="mt-4 p-3 bg-red-50 rounded-md">
                                        <p class="text-sm text-red-700">
                                            <strong>Warning:</strong> This will permanently delete:
                                        </p>
                                        <ul class="mt-1 text-sm text-red-600 list-disc list-inside">
                                            <li>Teacher profile</li>
                                            <li>All appraisals</li>
                                            <li>All job applications</li>
                                            <li>All payment records</li>
                                            <li>User account</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button
                            type="button"
                            @click="deleteTeacher"
                            :disabled="isDeleting"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span v-if="isDeleting">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Deleting...
                            </span>
                            <span v-else>
                                Delete
                            </span>
                        </button>
                        <button
                            type="button"
                            @click="showDeleteModal = false"
                            :disabled="isDeleting"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { ref, computed, watch } from 'vue'
import { debounce } from 'lodash'

const props = defineProps({
    teachers: Object,
    filters: Object
})

const filters = ref({
    search: props.filters?.search || ''
})

// Delete modal state
const showDeleteModal = ref(false)
const teacherToDelete = ref(null)
const isDeleting = ref(false)

// Watch filters with debounce
watch(filters, debounce((value) => {
    router.get(route('admin.teachers.index'), value, {
        preserveState: true,
        replace: true
    })
}, 300), { deep: true })

const resetFilters = () => {
    filters.value = {
        search: ''
    }
}

const activeTeachersCount = computed(() => {
    if (!props.teachers?.data) return 0
    return props.teachers.data.filter(teacher => !teacher.suspended_at).length
})

const teachersWithAppraisals = computed(() => {
    if (!props.teachers?.data) return 0
    return props.teachers.data.filter(teacher => teacher.appraisals_count > 0).length
})

const averageScore = computed(() => {
    if (!props.teachers?.data) return 0

    const teachersWithScores = props.teachers.data.filter(teacher =>
        teacher.latest_appraisal && teacher.latest_appraisal.overall_score
    )
    if (teachersWithScores.length === 0) return 0

    const total = teachersWithScores.reduce((sum, teacher) =>
        sum + parseFloat(teacher.latest_appraisal.overall_score), 0
    )
    return Math.round(total / teachersWithScores.length)
})

const scoreColor = (score) => {
    if (!score && score !== 0) return 'text-gray-500'
    if (score >= 80) return 'text-green-600'
    if (score >= 70) return 'text-yellow-600'
    if (score >= 60) return 'text-orange-600'
    return 'text-red-600'
}

const teacherStatusClass = (teacher) => {
    if (!teacher) return 'bg-gray-100 text-gray-800'
    if (teacher.suspended_at) return 'bg-red-100 text-red-800'
    if (!teacher.teacher_profile) return 'bg-yellow-100 text-yellow-800'
    return 'bg-green-100 text-green-800'
}

const teacherStatusText = (teacher) => {
    if (!teacher) return 'Unknown'
    if (teacher.suspended_at) return 'Suspended'
    if (!teacher.teacher_profile) return 'Incomplete'
    return 'Active'
}

const getShortlistedCount = (teacher) => {
    if (!teacher?.job_applications_count) return 0
    return Math.floor((teacher.job_applications_count || 0) * 0.3)
}

const formatDate = (dateString) => {
    if (!dateString) return 'Unknown date'
    try {
        return new Date(dateString).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        })
    } catch (error) {
        console.error('Date formatting error:', error)
        return 'Invalid date'
    }
}

// Safe route helper to prevent null.toString() errors
const safeRoute = (name, params = {}) => {
    try {
        if (route().has(name)) {
            return route(name, params)
        }
        console.warn(`Route ${name} not found`)
        return '#'
    } catch (error) {
        console.error('Route error:', error)
        return '#'
    }
}

const toggleUserStatus = (teacher) => {
    if (!teacher?.id) {
        console.error('Teacher ID is missing:', teacher)
        alert('Cannot update status: Invalid teacher data')
        return
    }

    const action = teacher.suspended_at ? 'unsuspend' : 'suspend'
    const routeName = teacher.suspended_at ? 'admin.users.unsuspend' : 'admin.users.suspend'

    // Check if route exists
    if (!route().has(routeName)) {
        console.error(`Route ${routeName} not found`)
        alert('Action not available')
        return
    }

    if (confirm(`Are you sure you want to ${action} ${teacher.name}?`)) {
        router.post(route(routeName, teacher.id), {}, {
            preserveScroll: true,
            onSuccess: () => {
                // Page will refresh with updated data
            },
            onError: (errors) => {
                alert('Failed to update user status')
            }
        })
    }
}

const confirmDeleteTeacher = (teacher) => {
    if (!teacher?.id) {
        console.error('Cannot delete: Teacher ID is missing', teacher)
        alert('Cannot delete: Invalid teacher data')
        return
    }

    teacherToDelete.value = teacher
    showDeleteModal.value = true
}

const deleteTeacher = () => {
    if (!teacherToDelete.value?.id) {
        console.error('No teacher selected for deletion')
        showDeleteModal.value = false
        return
    }

    // Check if route exists
    if (!route().has('admin.teachers.destroy')) {
        console.error('Route admin.teachers.destroy not found')
        alert('Delete action not available')
        showDeleteModal.value = false
        return
    }

    isDeleting.value = true

    router.delete(route('admin.teachers.destroy', teacherToDelete.value.id), {
        preserveScroll: false,
        onSuccess: () => {
            showDeleteModal.value = false
            teacherToDelete.value = null
            isDeleting.value = false
        },
        onError: (errors) => {
            console.error('Delete error:', errors)
            alert('Failed to delete teacher. Please try again.')
            isDeleting.value = false
        },
        onFinish: () => {
            isDeleting.value = false
        }
    })
}

// Debug function - remove in production
const debugRoutes = () => {
    console.log('=== ROUTE DEBUG ===')
    console.log('Current route:', route().current())

    const routesToCheck = [
        'admin.teachers.index',
        'admin.teachers.show',
        'admin.teachers.destroy',
        'admin.users.suspend',
        'admin.users.unsuspend'
    ]

    routesToCheck.forEach(routeName => {
        console.log(`${routeName}:`, route().has(routeName))
    })
}
</script>

<style scoped>
/* Optional: Add loading state styles */
button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.animate-spin {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}
</style>
