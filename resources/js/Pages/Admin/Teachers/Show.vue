<template>
    <AppLayout>
        <template #header>
            <div class="flex items-center">
                <Link :href="route('admin.teachers')" class="text-gray-600 hover:text-gray-900 mr-4">
                    ← Back to Teachers
                </Link>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Teacher Profile: {{ teacher.name }}
                </h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Main Content -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Profile Information -->
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                                            Profile Information
                                        </h3>
                                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                            Personal details and account information.
                                        </p>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                          :class="teacherStatusClass(teacher)">
                                        {{ teacherStatusText(teacher) }}
                                    </span>
                                </div>
                            </div>
                            <div class="px-4 py-5 sm:p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="flex items-center space-x-4">
                                        <img class="h-16 w-16 rounded-full" :src="teacher.profile_photo_url" :alt="teacher.name" />
                                        <div>
                                            <h4 class="text-lg font-medium text-gray-900">{{ teacher.name }}</h4>
                                            <p class="text-sm text-gray-500">{{ teacher.email }}</p>
                                            <p class="text-xs text-gray-400">
                                                Joined {{ formatDate(teacher.created_at) }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <div v-if="teacher.teacher_profile">
                                            <div class="text-sm">
                                                <span class="font-medium text-gray-500">Phone:</span>
                                                <span class="ml-2 text-gray-900">{{ teacher.teacher_profile.phone || 'Not provided' }}</span>
                                            </div>
                                            <div class="text-sm">
                                                <span class="font-medium text-gray-500">Location:</span>
                                                <span class="ml-2 text-gray-900">
                                                    {{ teacher.teacher_profile.state }}, {{ teacher.teacher_profile.lga }}
                                                </span>
                                            </div>
                                            <div class="text-sm">
                                                <span class="font-medium text-gray-500">Profile:</span>
                                                <span class="ml-2" :class="teacher.teacher_profile.is_public ? 'text-green-600' : 'text-gray-600'">
                                                    {{ teacher.teacher_profile.is_public ? 'Public' : 'Private' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Professional Information -->
                                <div v-if="teacher.teacher_profile" class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h4 class="text-md font-medium text-gray-900 mb-3">Professional Background</h4>
                                        <dl class="space-y-2">
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Qualification</dt>
                                                <dd class="text-sm text-gray-900">{{ teacher.teacher_profile.qualification }}</dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Experience</dt>
                                                <dd class="text-sm text-gray-900">{{ teacher.teacher_profile.years_of_experience }} years</dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Specialization</dt>
                                                <dd class="text-sm text-gray-900">{{ teacher.teacher_profile.specialization }}</dd>
                                            </div>
                                        </dl>
                                    </div>
                                    <div>
                                        <h4 class="text-md font-medium text-gray-900 mb-3">Additional Information</h4>
                                        <div v-if="teacher.teacher_profile.bio" class="mb-3">
                                            <dt class="text-sm font-medium text-gray-500">Bio</dt>
                                            <dd class="text-sm text-gray-900 mt-1 whitespace-pre-line">{{ teacher.teacher_profile.bio }}</dd>
                                        </div>
                                        <div v-if="teacher.teacher_profile.linkedin_url" class="mb-2">
                                            <dt class="text-sm font-medium text-gray-500">LinkedIn</dt>
                                            <dd class="text-sm text-gray-900">
                                                <a :href="teacher.teacher_profile.linkedin_url" target="_blank" class="text-blue-600 hover:text-blue-500">
                                                    {{ teacher.teacher_profile.linkedin_url }}
                                                </a>
                                            </dd>
                                        </div>
                                        <div v-if="teacher.teacher_profile.resume_path">
                                            <dt class="text-sm font-medium text-gray-500">Resume</dt>
                                            <dd class="text-sm text-gray-900">
                                                <a :href="teacher.teacher_profile.resume_url" target="_blank" class="text-blue-600 hover:text-blue-500">
                                                    Download Resume
                                                </a>
                                            </dd>
                                        </div>
                                    </div>
                                </div>

                                <div v-else class="mt-6 text-center py-8 bg-yellow-50 rounded-lg">
                                    <p class="text-yellow-800">Teacher profile not completed yet.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Appraisals History -->
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Appraisal History
                                </h3>
                                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                    All teacher appraisals and performance scores.
                                </p>
                            </div>
                            <div class="px-4 py-5 sm:p-6">
                                <div v-if="teacher.appraisals && teacher.appraisals.length > 0" class="space-y-4">
                                    <div v-for="appraisal in teacher.appraisals" :key="appraisal.id"
                                         class="border border-gray-200 rounded-lg p-4">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h4 class="text-sm font-medium text-gray-900">
                                                    Appraisal #{{ appraisal.id }}
                                                    <span v-if="appraisal.is_latest" class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                        Latest
                                                    </span>
                                                </h4>
                                                <p class="text-sm text-gray-500 mt-1">
                                                    {{ formatDate(appraisal.created_at) }}
                                                </p>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-2xl font-bold" :class="scoreColor(appraisal.overall_score)">
                                                    {{ appraisal.overall_score }}%
                                                </div>
                                                <div class="text-sm font-medium" :class="gradeColor(appraisal.grade)">
                                                    {{ appraisal.grade }}
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Scores Breakdown -->
                                        <div class="mt-3 grid grid-cols-2 md:grid-cols-3 gap-2">
                                            <div v-for="(score, category) in appraisal.scores_breakdown" :key="category"
                                                 class="text-center">
                                                <div class="text-xs text-gray-500 capitalize">
                                                    {{ category.replace('_', ' ') }}
                                                </div>
                                                <div class="text-sm font-semibold" :class="scoreColor(score)">
                                                    {{ score }}%
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Quick Summary -->
                                        <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                                            <div>
                                                <span class="font-medium text-gray-700">Strengths:</span>
                                                <p class="text-gray-600 line-clamp-2">{{ appraisal.strengths }}</p>
                                            </div>
                                            <div>
                                                <span class="font-medium text-gray-700">Improvement Areas:</span>
                                                <p class="text-gray-600 line-clamp-2">{{ appraisal.improvement_areas }}</p>
                                            </div>
                                        </div>

                                        <div class="mt-3 flex justify-end space-x-2">
                                            <Link
                                                :href="route('admin.appraisals.show', appraisal.id)"
                                                class="text-sm text-blue-600 hover:text-blue-500"
                                            >
                                                View Full Report
                                            </Link>
                                            <a v-if="appraisal.appraisal_report_path"
                                               :href="appraisal.report_url"
                                               target="_blank"
                                               class="text-sm text-green-600 hover:text-green-500"
                                            >
                                                Download PDF
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div v-else class="text-center py-8 bg-gray-50 rounded-lg">
                                    <p class="text-gray-500">No appraisals yet.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Job Applications -->
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Job Applications
                                </h3>
                                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                    All job applications submitted by this teacher.
                                </p>
                            </div>
                            <div class="px-4 py-5 sm:p-6">
                                <div v-if="teacher.job_applications && teacher.job_applications.length > 0" class="space-y-4">
                                    <div v-for="application in teacher.job_applications" :key="application.id"
                                         class="border border-gray-200 rounded-lg p-4">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h4 class="text-sm font-medium text-gray-900">
                                                    {{ application.job.title }}
                                                </h4>
                                                <p class="text-sm text-gray-600">
                                                    {{ application.job.school.school_profile.school_name }}
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    Applied {{ formatDate(application.created_at) }}
                                                </p>
                                            </div>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                                  :class="applicationStatusClass(application.status)">
                                                {{ application.status.toUpperCase() }}
                                            </span>
                                        </div>

                                        <div v-if="application.cover_letter" class="mt-2">
                                            <p class="text-sm text-gray-700 line-clamp-2">{{ application.cover_letter }}</p>
                                        </div>

                                        <div v-if="application.school_feedback" class="mt-2 bg-blue-50 border border-blue-200 rounded-md p-2">
                                            <p class="text-xs text-blue-800">
                                                <strong>School Feedback:</strong> {{ application.school_feedback }}
                                            </p>
                                        </div>

                                        <div class="mt-3 flex justify-end space-x-2">
                                            <Link
                                                :href="route('admin.jobs.show', application.job.id)"
                                                class="text-sm text-blue-600 hover:text-blue-500"
                                            >
                                                View Job
                                            </Link>
                                            <Link
                                                :href="route('admin.applications')"
                                                class="text-sm text-green-600 hover:text-green-500"
                                            >
                                                Manage Applications
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                                <div v-else class="text-center py-8 bg-gray-50 rounded-lg">
                                    <p class="text-gray-500">No job applications yet.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Quick Stats -->
                        <div class="bg-white shadow rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Stats</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Total Appraisals</span>
                                    <span class="text-sm font-medium text-gray-900">{{ teacher.appraisals?.length || 0 }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Job Applications</span>
                                    <span class="text-sm font-medium text-gray-900">{{ teacher.job_applications?.length || 0 }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Payments Made</span>
                                    <span class="text-sm font-medium text-gray-900">{{ teacher.payments?.length || 0 }}</span>
                                </div>
                                <div v-if="teacher.latest_appraisal" class="flex justify-between">
                                    <span class="text-sm text-gray-600">Latest Score</span>
                                    <span class="text-sm font-medium" :class="scoreColor(teacher.latest_appraisal.overall_score)">
                                        {{ teacher.latest_appraisal.overall_score }}%
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Payment History -->
                        <div class="bg-white shadow rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Payment History</h3>
                            <div v-if="teacher.payments && teacher.payments.length > 0" class="space-y-3">
                                <div v-for="payment in teacher.payments.slice(0, 5)" :key="payment.id"
                                     class="flex justify-between items-center text-sm">
                                    <div>
                                        <div class="font-medium text-gray-900">₦{{ payment.amount?.toLocaleString() }}</div>
                                        <div class="text-gray-500">{{ formatDate(payment.created_at) }}</div>
                                    </div>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium"
                                          :class="paymentStatusClass(payment.status)">
                                        {{ payment.status }}
                                    </span>
                                </div>
                                <div v-if="teacher.payments.length > 5" class="text-center">
                                    <Link :href="route('admin.payments')" class="text-sm text-blue-600 hover:text-blue-500">
                                        View all payments
                                    </Link>
                                </div>
                            </div>
                            <div v-else class="text-center py-4">
                                <p class="text-gray-500 text-sm">No payment history</p>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="bg-white shadow rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Actions</h3>
                            <div class="space-y-3">
                                <button
                                    @click="toggleUserStatus(teacher)"
                                    class="w-full flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                    :class="teacher.suspended_at ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700'"
                                >
                                    {{ teacher.suspended_at ? 'Unsuspend Account' : 'Suspend Account' }}
                                </button>
                                <Link
                                    :href="route('admin.appraisals')"
                                    class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                >
                                    View All Appraisals
                                </Link>
                                <Link
                                    :href="route('admin.applications')"
                                    class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                >
                                    View All Applications
                                </Link>
                            </div>
                        </div>

                        <!-- Account Information -->
                        <div class="bg-white shadow rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Account Information</h3>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Email Verified</span>
                                    <span v-if="teacher.email_verified_at" class="text-green-600 font-medium">Yes</span>
                                    <span v-else class="text-red-600 font-medium">No</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Profile Completed</span>
                                    <span v-if="teacher.teacher_profile" class="text-green-600 font-medium">Yes</span>
                                    <span v-else class="text-red-600 font-medium">No</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Last Login</span>
                                    <span class="text-gray-900">{{ teacher.last_login_at ? formatDate(teacher.last_login_at) : 'Never' }}</span>
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
    teacher: Object
})

const scoreColor = (score) => {
    if (score >= 80) return 'text-green-600'
    if (score >= 70) return 'text-yellow-600'
    if (score >= 60) return 'text-orange-600'
    return 'text-red-600'
}

const gradeColor = (grade) => {
    const colors = {
        'A+': 'text-green-600',
        'A': 'text-green-600',
        'B': 'text-yellow-600',
        'C': 'text-orange-600',
        'D': 'text-red-600',
        'F': 'text-red-600'
    }
    return colors[grade] || 'text-gray-600'
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

const applicationStatusClass = (status) => {
    const classes = {
        'pending': 'bg-yellow-100 text-yellow-800',
        'reviewed': 'bg-blue-100 text-blue-800',
        'shortlisted': 'bg-green-100 text-green-800',
        'rejected': 'bg-red-100 text-red-800'
    }
    return classes[status] || 'bg-gray-100 text-gray-800'
}

const paymentStatusClass = (status) => {
    const classes = {
        'successful': 'bg-green-100 text-green-800',
        'pending': 'bg-yellow-100 text-yellow-800',
        'failed': 'bg-red-100 text-red-800'
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

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
