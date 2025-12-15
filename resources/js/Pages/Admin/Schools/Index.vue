<template>
    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Schools Management
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
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Schools</dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ schools.total }}</dd>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Verified</dt>
                            <dd class="mt-1 text-3xl font-semibold text-green-600">{{ verifiedSchoolsCount }}</dd>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Pending Approval</dt>
                            <dd class="mt-1 text-3xl font-semibold text-yellow-600">{{ pendingApprovalCount }}</dd>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Active Jobs</dt>
                            <dd class="mt-1 text-3xl font-semibold text-blue-600">{{ totalActiveJobs }}</dd>
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
                                placeholder="School name, location..."
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

                <!-- Schools List -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    All Schools
                                </h3>
                                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                    Manage and monitor all registered schools in the system.
                                </p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500">
                                    Total: {{ schools.total }} schools
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        School
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Contact Information
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jobs & Applications
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
                                <tr v-for="school in schools.data" :key="school.id" class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full"
                                                     :src="school.school_profile?.logo_url || school.profile_photo_url || '/default-school.png'"
                                                     :alt="school.school_profile?.school_name || school.name" />
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ school.school_profile?.school_name || school.name }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ (school.school_profile?.school_type || '').toUpperCase() }} •
                                                    {{ (school.school_profile?.ownership || '').toUpperCase() }}
                                                </div>
                                                <div class="text-xs text-gray-400">
                                                    {{ school.school_profile?.state || '' }}, {{ school.school_profile?.lga || '' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ school.email }}</div>
                                        <div class="text-sm text-gray-500">{{ school.school_profile?.phone || 'No phone' }}</div>
                                        <div class="text-xs text-gray-400">
                                            Joined {{ formatDate(school.created_at) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ school.jobs_count || 0 }} jobs posted
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ getTotalApplications(school) }} total applications
                                        </div>
                                        <div v-if="school.jobs_count > 0" class="text-xs text-gray-400">
                                            {{ getActiveJobsCount(school) }} active jobs
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                              :class="schoolStatusClass(school)">
                                            {{ schoolStatusText(school) }}
                                        </span>
                                        <div v-if="school.suspended_at" class="text-xs text-red-600 mt-1">
                                            Suspended
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-3">
                                            <Link
                                                :href="safeRoute('admin.schools.show', school.id)"
                                                class="text-blue-600 hover:text-blue-900"
                                            >
                                                View
                                            </Link>
                                            <button
                                                v-if="!school.school_profile?.is_verified"
                                                @click="verifySchool(school)"
                                                class="text-green-600 hover:text-green-900"
                                            >
                                                Verify
                                            </button>
                                            <button
                                                v-else
                                                @click="unverifySchool(school)"
                                                class="text-yellow-600 hover:text-yellow-900"
                                            >
                                                Unverify
                                            </button>
                                            <button
                                                @click="toggleUserStatus(school)"
                                                :class="school.suspended_at ? 'text-green-600 hover:text-green-900' : 'text-yellow-600 hover:text-yellow-900'"
                                            >
                                                {{ school.suspended_at ? 'Unsuspend' : 'Suspend' }}
                                            </button>
                                            <button
                                                @click="confirmDeleteSchool(school)"
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
                    <div v-if="schools.links.length > 3" class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                        <div class="flex-1 flex justify-between sm:hidden">
                            <Link
                                :href="schools.prev_page_url || '#'"
                                :class="{'opacity-50 cursor-not-allowed': !schools.prev_page_url}"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                            >
                                Previous
                            </Link>
                            <Link
                                :href="schools.next_page_url || '#'"
                                :class="{'opacity-50 cursor-not-allowed': !schools.next_page_url}"
                                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                            >
                                Next
                            </Link>
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Showing
                                    <span class="font-medium">{{ schools.from }}</span>
                                    to
                                    <span class="font-medium">{{ schools.to }}</span>
                                    of
                                    <span class="font-medium">{{ schools.total }}</span>
                                    schools
                                </p>
                            </div>
                            <div>
                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                    <Link
                                        v-for="(link, index) in schools.links"
                                        :key="index"
                                        :href="link.url || '#'"
                                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                                        :class="{
                                            'bg-blue-50 border-blue-500 text-blue-600 z-10': link.active,
                                            'rounded-l-md': index === 0,
                                            'rounded-r-md': index === schools.links.length - 1,
                                            'opacity-50 cursor-not-allowed': !link.url
                                        }"
                                        v-html="link.label"
                                    ></Link>
                                </nav>
                            </div>
                        </div>
                    </div>

                    <!-- Empty State -->
                    <div v-if="schools.data.length === 0" class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No schools found</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            No schools match your current search criteria.
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
                                    Delete School
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Are you sure you want to delete <strong>{{ schoolToDelete?.school_profile?.school_name || schoolToDelete?.name }}</strong>? This action cannot be undone.
                                    </p>
                                    <div class="mt-4 p-3 bg-red-50 rounded-md">
                                        <p class="text-sm text-red-700">
                                            <strong>Warning:</strong> This will permanently delete:
                                        </p>
                                        <ul class="mt-1 text-sm text-red-600 list-disc list-inside">
                                            <li>School profile and all details</li>
                                            <li>All job postings</li>
                                            <li>All job applications for this school</li>
                                            <li>User account</li>
                                        </ul>
                                        <div v-if="schoolToDelete?.jobs_count > 0" class="mt-2 p-2 bg-red-100 border border-red-200 rounded">
                                            <p class="text-xs text-red-700 font-semibold">
                                                ⚠️ This school has {{ schoolToDelete.jobs_count }} active job postings with {{ getTotalApplications(schoolToDelete) }} applications!
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button
                            type="button"
                            @click="deleteSchool"
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
    schools: Object,
    filters: Object
})

const filters = ref({
    search: props.filters?.search || ''
})

// Delete modal state
const showDeleteModal = ref(false)
const schoolToDelete = ref(null)
const isDeleting = ref(false)

// Watch filters with debounce
watch(filters, debounce((value) => {
    router.get(route('admin.schools'), value, {
        preserveState: true,
        replace: true
    })
}, 300), { deep: true })

const resetFilters = () => {
    filters.value = {
        search: ''
    }
}

const verifiedSchoolsCount = computed(() => {
    if (!props.schools?.data) return 0
    return props.schools.data.filter(school => school.school_profile?.is_verified).length
})

const pendingApprovalCount = computed(() => {
    if (!props.schools?.data) return 0
    return props.schools.data.filter(school => !school.school_profile?.is_verified).length
})

const totalActiveJobs = computed(() => {
    if (!props.schools?.data) return 0
    return props.schools.data.reduce((total, school) => total + (school.jobs_count || 0), 0)
})

const schoolStatusClass = (school) => {
    if (!school) return 'bg-gray-100 text-gray-800'
    if (school.suspended_at) return 'bg-red-100 text-red-800'
    if (!school.school_profile?.is_verified) return 'bg-yellow-100 text-yellow-800'
    return 'bg-green-100 text-green-800'
}

const schoolStatusText = (school) => {
    if (!school) return 'Unknown'
    if (school.suspended_at) return 'Suspended'
    if (!school.school_profile?.is_verified) return 'Pending Verification'
    return 'Verified'
}

const getTotalApplications = (school) => {
    if (!school?.jobs_count) return 0
    return Math.floor((school.jobs_count || 0) * 3.5)
}

const getActiveJobsCount = (school) => {
    if (!school?.jobs_count) return 0
    return Math.floor((school.jobs_count || 0) * 0.6)
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

// Safe route helper
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

const verifySchool = (school) => {
    if (!school?.id) {
        console.error('School ID is missing:', school)
        alert('Cannot verify: Invalid school data')
        return
    }

    if (confirm('Are you sure you want to verify this school? They will be able to post jobs.')) {
        router.post(route('admin.schools.verify', school.id), {}, {
            preserveScroll: true,
            onSuccess: () => {
                // Page will refresh with updated data
            },
            onError: (errors) => {
                alert('Failed to verify school')
            }
        })
    }
}

const unverifySchool = (school) => {
    if (!school?.id) {
        console.error('School ID is missing:', school)
        alert('Cannot unverify: Invalid school data')
        return
    }

    if (confirm('Are you sure you want to remove verification from this school? They will not be able to post new jobs.')) {
        router.post(route('admin.schools.unverify', school.id), {}, {
            preserveScroll: true,
            onSuccess: () => {
                // Page will refresh with updated data
            },
            onError: (errors) => {
                alert('Failed to unverify school')
            }
        })
    }
}

const toggleUserStatus = (school) => {
    if (!school?.id) {
        console.error('School ID is missing:', school)
        alert('Cannot update status: Invalid school data')
        return
    }

    const action = school.suspended_at ? 'unsuspend' : 'suspend'
    const routeName = school.suspended_at ? 'admin.users.unsuspend' : 'admin.users.suspend'

    // Check if route exists
    if (!route().has(routeName)) {
        console.error(`Route ${routeName} not found`)
        alert('Action not available')
        return
    }

    if (confirm(`Are you sure you want to ${action} this school?`)) {
        router.post(route(routeName, school.id), {}, {
            preserveScroll: true,
            onSuccess: () => {
                // Page will refresh with updated data
            },
            onError: (errors) => {
                alert('Failed to update school status')
            }
        })
    }
}

const confirmDeleteSchool = (school) => {
    if (!school?.id) {
        console.error('Cannot delete: School ID is missing', school)
        alert('Cannot delete: Invalid school data')
        return
    }

    schoolToDelete.value = school
    showDeleteModal.value = true
}

const deleteSchool = () => {
    if (!schoolToDelete.value?.id) {
        console.error('No school selected for deletion')
        showDeleteModal.value = false
        return
    }

    // Check if route exists
    if (!route().has('admin.schools.destroy')) {
        console.error('Route admin.schools.destroy not found')
        alert('Delete action not available')
        showDeleteModal.value = false
        return
    }

    isDeleting.value = true

    router.delete(route('admin.schools.destroy', schoolToDelete.value.id), {
        preserveScroll: false,
        onSuccess: () => {
            showDeleteModal.value = false
            schoolToDelete.value = null
            isDeleting.value = false
        },
        onError: (errors) => {
            console.error('Delete error:', errors)
            alert('Failed to delete school. Please try again.')
            isDeleting.value = false
        },
        onFinish: () => {
            isDeleting.value = false
        }
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
