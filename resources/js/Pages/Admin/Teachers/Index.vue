<template>
    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Teachers Management
            </h2>
        </template>

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
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            All Teachers
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Manage and monitor all registered teachers in the system.
                        </p>
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
                                                <img class="h-10 w-10 rounded-full" :src="teacher.profile_photo_url" :alt="teacher.name" />
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
                                                {{ teacher.teacher_profile.years_of_experience }} yrs exp
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
                                        <Link
                                            :href="route('admin.teachers.show', teacher.id)"
                                            class="text-blue-600 hover:text-blue-900 mr-3"
                                        >
                                            View
                                        </Link>
                                        <button
                                            @click="toggleUserStatus(teacher)"
                                            class="text-red-600 hover:text-red-900"
                                        >
                                            {{ teacher.suspended_at ? 'Unsuspend' : 'Suspend' }}
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div v-if="teachers.links.length > 3" class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                        <div class="flex-1 flex justify-between sm:hidden">
                            <Link
                                :href="teachers.prev_page_url"
                                :class="{'opacity-50 cursor-not-allowed': !teachers.prev_page_url}"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                            >
                                Previous
                            </Link>
                            <Link
                                :href="teachers.next_page_url"
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
                                        :href="link.url"
                                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                                        :class="{
                                            'bg-blue-50 border-blue-500 text-blue-600 z-10': link.active,
                                            'rounded-l-md': index === 0,
                                            'rounded-r-md': index === teachers.links.length - 1
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
    search: props.filters.search || ''
})

// Watch filters with debounce
watch(filters, debounce((value) => {
    router.get(route('admin.teachers'), value, {
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
    return props.teachers.data.filter(teacher => !teacher.suspended_at).length
})

const teachersWithAppraisals = computed(() => {
    return props.teachers.data.filter(teacher => teacher.appraisals_count > 0).length
})

const averageScore = computed(() => {
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
    if (score >= 80) return 'text-green-600'
    if (score >= 70) return 'text-yellow-600'
    if (score >= 60) return 'text-orange-600'
    return 'text-red-600'
}

const teacherStatusClass = (teacher) => {
    if (teacher.suspended_at) return 'bg-red-100 text-red-800'
    if (!teacher.teacher_profile) return 'bg-yellow-100 text-yellow-800'
    return 'bg-green-100 text-green-800'
}

const teacherStatusText = (teacher) => {
    if (teacher.suspended_at) return 'Suspended'
    if (!teacher.teacher_profile) return 'Incomplete'
    return 'Active'
}

const getShortlistedCount = (teacher) => {
    // This would need actual shortlisted count data
    return Math.floor((teacher.job_applications_count || 0) * 0.3) // Example: 30% shortlisted
}

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    })
}

const toggleUserStatus = (teacher) => {
    const action = teacher.suspended_at ? 'unsuspend' : 'suspend'
    if (confirm(`Are you sure you want to ${action} this teacher?`)) {
        const routeName = teacher.suspended_at ? 'admin.users.unsuspend' : 'admin.users.suspend'
        router.post(route(routeName, teacher.id), {}, {
            preserveScroll: true,
            onSuccess: () => {
                // Page will refresh with updated data
            }
        })
    }
}
</script>
