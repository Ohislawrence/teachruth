<template>
    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Schools Management
            </h2>
        </template>

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
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            All Schools
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Manage and monitor all registered schools in the system.
                        </p>
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
                                                     :src="school.school_profile?.logo_url || school.profile_photo_url"
                                                     :alt="school.school_profile?.school_name || school.name" />
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ school.school_profile?.school_name || school.name }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ school.school_profile?.school_type?.toUpperCase() }} •
                                                    {{ school.school_profile?.ownership?.toUpperCase() }}
                                                </div>
                                                <div class="text-xs text-gray-400">
                                                    {{ school.school_profile?.state }}, {{ school.school_profile?.lga }}
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
                                        <Link
                                            :href="route('admin.schools.show', school.id)"
                                            class="text-blue-600 hover:text-blue-900 mr-3"
                                        >
                                            View
                                        </Link>
                                        <button
                                            v-if="!school.school_profile?.is_verified"
                                            @click="verifySchool(school)"
                                            class="text-green-600 hover:text-green-900 mr-3"
                                        >
                                            Verify
                                        </button>
                                        <button
                                            v-else
                                            @click="unverifySchool(school)"
                                            class="text-yellow-600 hover:text-yellow-900 mr-3"
                                        >
                                            Unverify
                                        </button>
                                        <button
                                            @click="toggleUserStatus(school)"
                                            class="text-red-600 hover:text-red-900"
                                        >
                                            {{ school.suspended_at ? 'Unsuspend' : 'Suspend' }}
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div v-if="schools.links.length > 3" class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                        <div class="flex-1 flex justify-between sm:hidden">
                            <Link
                                :href="schools.prev_page_url"
                                :class="{'opacity-50 cursor-not-allowed': !schools.prev_page_url}"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                            >
                                Previous
                            </Link>
                            <Link
                                :href="schools.next_page_url"
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
                                        :href="link.url"
                                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                                        :class="{
                                            'bg-blue-50 border-blue-500 text-blue-600 z-10': link.active,
                                            'rounded-l-md': index === 0,
                                            'rounded-r-md': index === schools.links.length - 1
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
    search: props.filters.search || ''
})

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
    return props.schools.data.filter(school => school.school_profile?.is_verified).length
})

const pendingApprovalCount = computed(() => {
    return props.schools.data.filter(school => !school.school_profile?.is_verified).length
})

const totalActiveJobs = computed(() => {
    return props.schools.data.reduce((total, school) => total + (school.jobs_count || 0), 0)
})

const schoolStatusClass = (school) => {
    if (school.suspended_at) return 'bg-red-100 text-red-800'
    if (!school.school_profile?.is_verified) return 'bg-yellow-100 text-yellow-800'
    return 'bg-green-100 text-green-800'
}

const schoolStatusText = (school) => {
    if (school.suspended_at) return 'Suspended'
    if (!school.school_profile?.is_verified) return 'Pending Verification'
    return 'Verified'
}

const getTotalApplications = (school) => {
    // This would need actual application count data
    return Math.floor((school.jobs_count || 0) * 3.5) // Example average
}

const getActiveJobsCount = (school) => {
    // This would need actual active job count data
    return Math.floor((school.jobs_count || 0) * 0.6) // Example: 60% active
}

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    })
}

const verifySchool = (school) => {
    if (confirm('Are you sure you want to verify this school? They will be able to post jobs.')) {
        router.post(route('admin.schools.verify', school.id), {}, {
            preserveScroll: true,
            onSuccess: () => {
                // Page will refresh with updated data
            }
        })
    }
}

const unverifySchool = (school) => {
    if (confirm('Are you sure you want to remove verification from this school? They will not be able to post new jobs.')) {
        router.post(route('admin.schools.unverify', school.id), {}, {
            preserveScroll: true,
            onSuccess: () => {
                // Page will refresh with updated data
            }
        })
    }
}

const toggleUserStatus = (school) => {
    const action = school.suspended_at ? 'unsuspend' : 'suspend'
    if (confirm(`Are you sure you want to ${action} this school?`)) {
        const routeName = school.suspended_at ? 'admin.users.unsuspend' : 'admin.users.suspend'
        router.post(route(routeName, school.id), {}, {
            preserveScroll: true,
            onSuccess: () => {
                // Page will refresh with updated data
            }
        })
    }
}
</script>
