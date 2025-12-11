<template>
    <AppLayout title="Application Details">
        <div class="min-h-screen bg-gradient-to-b from-emerald-50 via-teal-50 to-white">
            <!-- Navigation -->
            <nav class="bg-gradient-to-r from-emerald-600 to-teal-600 shadow-lg">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <div class="flex items-center space-x-3">
                                <Link :href="route('school.applications')" class="text-white hover:text-emerald-100 transition">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                </Link>
                                <div>
                                    <h1 class="text-xl font-bold text-white">Application Details</h1>
                                    <p class="text-xs text-emerald-100">Review teacher application</p>
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
                                All Applications
                            </Link>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="py-8">
                <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                    <!-- Application Header -->
                    <div class="bg-white shadow-2xl rounded-2xl border border-emerald-100 overflow-hidden mb-6">
                        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-5 sm:px-8">
                            <div class="flex flex-col lg:flex-row lg:items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-start space-x-4">
                                        <!-- Teacher Avatar -->
                                        <div class="flex-shrink-0">
                                            <div class="w-16 h-16 rounded-xl bg-gradient-to-r from-emerald-100 to-teal-100 flex items-center justify-center">
                                                <svg class="w-8 h-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                        </div>

                                        <!-- Teacher & Job Info -->
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-4 mb-2">
                                                <h1 class="text-3xl font-bold text-gray-900">{{ application.teacher.name }}</h1>
                                                <span :class="statusBadgeClass(application.status)"
                                                      class="px-3 py-1 rounded-full text-sm font-bold">
                                                    {{ formatStatus(application.status) }}
                                                </span>
                                            </div>

                                            <div class="space-y-2">
                                                <p class="text-xl text-emerald-700 font-semibold">
                                                    Applied for: {{ application.job.title }}
                                                </p>
                                                <div class="flex items-center text-gray-600">
                                                    <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    {{ application.job.state }}, {{ application.job.lga }}
                                                </div>
                                                <div class="text-gray-600">
                                                    Applied on {{ formatDate(application.created_at) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="mt-4 lg:mt-0 lg:ml-4 space-y-3">
                                    <div class="flex space-x-3">
                                        <button
                                            @click="updateStatus('shortlisted')"
                                            v-if="application.status !== 'shortlisted'"
                                            class="inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-bold rounded-xl shadow-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-300 transition"
                                        >
                                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Shortlist
                                        </button>
                                        <button
                                            @click="updateStatus('rejected')"
                                            v-if="application.status !== 'rejected'"
                                            class="inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-bold rounded-xl shadow-lg text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 transition"
                                        >
                                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Reject
                                        </button>
                                    </div>
                                    <Link
                                        :href="route('school.jobs.applicants', application.job.id)"
                                        class="inline-flex items-center justify-center w-full px-4 py-2.5 border border-emerald-300 text-sm font-semibold rounded-xl text-emerald-700 bg-white hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-200 transition"
                                    >
                                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        View All Applicants
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Main Content -->
                        <div class="lg:col-span-2 space-y-8">
                            <!-- Teacher Profile Card -->
                            <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 overflow-hidden">
                                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 sm:px-8">
                                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Teacher Profile
                                    </h2>
                                </div>
                                <div class="px-6 py-6 sm:px-8">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Contact Information -->
                                        <div class="space-y-4">
                                            <div class="flex items-center p-4 bg-emerald-50 rounded-xl">
                                                <div class="p-3 rounded-lg bg-emerald-100 mr-4">
                                                    <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-emerald-600">Phone</p>
                                                    <p class="text-lg font-semibold text-gray-900">{{ application.teacher.teacher_profile?.phone || 'Not provided' }}</p>
                                                </div>
                                            </div>

                                            <div class="flex items-center p-4 bg-emerald-50 rounded-xl">
                                                <div class="p-3 rounded-lg bg-emerald-100 mr-4">
                                                    <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-emerald-600">Location</p>
                                                    <p class="text-lg font-semibold text-gray-900">
                                                        {{ application.teacher.teacher_profile?.state || 'Not specified' }},
                                                        {{ application.teacher.teacher_profile?.lga || '' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Professional Information -->
                                        <div class="space-y-4">
                                            <div class="flex items-center p-4 bg-emerald-50 rounded-xl">
                                                <div class="p-3 rounded-lg bg-emerald-100 mr-4">
                                                    <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-emerald-600">Qualification</p>
                                                    <p class="text-lg font-semibold text-gray-900">{{ application.teacher.teacher_profile?.qualification || 'Not specified' }}</p>
                                                </div>
                                            </div>

                                            <div class="flex items-center p-4 bg-emerald-50 rounded-xl">
                                                <div class="p-3 rounded-lg bg-emerald-100 mr-4">
                                                    <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-emerald-600">Experience</p>
                                                    <p class="text-lg font-semibold text-gray-900">
                                                        {{ application.teacher.teacher_profile?.years_of_experience || '0' }} years
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bio -->
                                    <div class="mt-6">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-3">About</h3>
                                        <div class="bg-gray-50 rounded-xl p-5">
                                            <p class="text-gray-700 whitespace-pre-line">
                                                {{ application.teacher.teacher_profile?.bio || 'No bio provided.' }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Resume -->
                                    <div class="mt-6" v-if="application.teacher.teacher_profile?.resume_url">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Resume</h3>
                                        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
                                            <div class="flex items-center">
                                                <svg class="w-8 h-8 text-blue-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                <div class="flex-1">
                                                    <p class="font-medium text-blue-800">Teacher's Resume</p>
                                                    <p class="text-sm text-blue-600">Click to download</p>
                                                </div>
                                                <a :href="application.teacher.teacher_profile.resume_url" target="_blank"
                                                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-semibold rounded-xl text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 transition">
                                                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                    </svg>
                                                    Download
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Appraisal Information -->
                            <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 overflow-hidden" v-if="application.teacher.appraisals?.length > 0">
                                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 sm:px-8">
                                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                        AI Appraisal Results
                                    </h2>
                                </div>
                                <div class="px-6 py-6 sm:px-8">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl p-5 border border-emerald-100">
                                            <div class="text-center">
                                                <p class="text-sm font-medium text-emerald-600">Overall Score</p>
                                                <div class="mt-2 flex items-center justify-center">
                                                    <span class="text-4xl font-bold text-emerald-700">
                                                        {{ application.teacher.appraisals[0].overall_score }}
                                                    </span>
                                                    <span class="text-xl text-emerald-600 ml-1">/100</span>
                                                </div>
                                                <div class="mt-3">
                                                    <span :class="getGradeBadgeClass(application.teacher.appraisals[0].overall_score)"
                                                        class="px-3 py-1 rounded-full text-sm font-bold">
                                                        {{ getGradeFromScore(application.teacher.appraisals[0].overall_score) }}
                                                    </span>
                                                </div>
                                                <div class="mt-4">
                                                    <div class="h-3 bg-emerald-200 rounded-full overflow-hidden">
                                                        <div class="h-full bg-emerald-600 rounded-full"
                                                            :style="{ width: application.teacher.appraisals[0].overall_score + '%' }"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="space-y-3">
                                            <div class="flex justify-between items-center p-3 bg-white rounded-lg border border-emerald-100">
                                                <span class="text-sm font-medium text-emerald-700">Appraisal Date</span>
                                                <span class="text-sm font-semibold text-gray-900">
                                                    {{ formatDate(application.teacher.appraisals[0].created_at) }}
                                                </span>
                                            </div>
                                            <div class="flex justify-between items-center p-3 bg-white rounded-lg border border-emerald-100">
                                                <span class="text-sm font-medium text-emerald-700">Status</span>
                                                <span v-if="application.teacher.appraisals[0].is_latest"
                                                    class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                                    Latest Appraisal
                                                </span>
                                                <span v-else class="px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-800">
                                                    Previous Appraisal
                                                </span>
                                            </div>
                                            <div class="flex justify-between items-center p-3 bg-white rounded-lg border border-emerald-100">
                                                <span class="text-sm font-medium text-emerald-700">Report</span>
                                                <a v-if="application.teacher.appraisals[0].appraisal_report_path"
                                                :href="application.teacher.appraisals[0].report_url"
                                                target="_blank"
                                                class="inline-flex items-center px-3 py-1 text-sm font-semibold rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 transition">
                                                    View Report
                                                </a>
                                                <span v-else class="text-sm text-gray-500">No report available</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Strengths -->
                                    <div class="mt-6">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Key Strengths</h3>
                                        <div class="flex flex-wrap gap-2">
                                            <span v-for="(strength, index) in getStrengthsArray(application.teacher.appraisals[0])"
                                                :key="index"
                                                class="px-3 py-1.5 bg-emerald-100 text-emerald-800 rounded-full text-sm font-medium">
                                                {{ strength }}
                                            </span>
                                            <span v-if="getStrengthsArray(application.teacher.appraisals[0]).length === 0"
                                                class="text-gray-500 italic">
                                                No strengths recorded
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Improvement Areas -->
                                    <div class="mt-6" v-if="getImprovementAreasArray(application.teacher.appraisals[0]).length > 0">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Areas for Improvement</h3>
                                        <div class="flex flex-wrap gap-2">
                                            <span v-for="(area, index) in getImprovementAreasArray(application.teacher.appraisals[0])"
                                                :key="index"
                                                class="px-3 py-1.5 bg-amber-100 text-amber-800 rounded-full text-sm font-medium">
                                                {{ area }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- View Full Appraisal Button -->
                                    <div class="mt-6 pt-6 border-t border-emerald-100">
                                        <Link v-if="application.teacher.appraisals[0].id"
                                            :href="route('school.teacher.appraisal', { teacher: application.teacher.id, appraisal: application.teacher.appraisals[0].id })"
                                            class="inline-flex items-center px-4 py-2.5 border border-transparent text-sm font-semibold rounded-xl text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-300 transition">
                                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            View Full Appraisal Details
                                        </Link>
                                    </div>
                                </div>
                            </div>
                            <!-- Cover Letter Card -->
                            <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 overflow-hidden">
                                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 sm:px-8">
                                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                        </svg>
                                        Cover Letter
                                    </h2>
                                </div>
                                <div class="px-6 py-6 sm:px-8">
                                    <div class="bg-gray-50 rounded-xl p-5 min-h-[200px]">
                                        <p class="text-gray-700 whitespace-pre-line">
                                            {{ application.cover_letter || 'No cover letter provided.' }}
                                        </p>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <!-- Sidebar -->
                        <div class="space-y-8">
                            <!-- Status Update Card -->
                            <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 overflow-hidden">
                                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 sm:px-8">
                                    <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Update Status
                                    </h3>
                                </div>

                                <div class="px-6 py-6 sm:px-8">
                                    <div class="space-y-4">
                                        <div v-for="statusOption in statusOptions" :key="statusOption.value">
                                            <button
                                                @click="updateStatus(statusOption.value)"
                                                :disabled="application.status === statusOption.value"
                                                class="w-full flex items-center justify-between p-4 rounded-xl border transition"
                                                :class="application.status === statusOption.value
                                                    ? statusOption.activeClass + ' cursor-default'
                                                    : statusOption.class + ' hover:opacity-90'"
                                            >
                                                <div class="flex items-center">
                                                    <div class="p-2 rounded-lg mr-3" :class="statusOption.iconBg">
                                                        <svg class="w-5 h-5" :class="statusOption.iconColor" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path :d="statusOption.icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                        </svg>
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="font-semibold" :class="statusOption.textColor">{{ statusOption.label }}</p>
                                                        <p class="text-sm opacity-80">{{ statusOption.description }}</p>
                                                    </div>
                                                </div>
                                                <svg v-if="application.status === statusOption.value" class="w-5 h-5" :class="statusOption.iconColor" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Feedback Form -->
                                    <div class="mt-6 pt-6 border-t border-emerald-100">
                                        <label for="feedback" class="block text-sm font-semibold text-emerald-700 mb-2">
                                            Add Feedback (Optional)
                                        </label>
                                        <textarea
                                            id="feedback"
                                            v-model="feedback"
                                            rows="3"
                                            class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                                            placeholder="Add notes or feedback for this applicant..."
                                        ></textarea>
                                        <button
                                            @click="saveFeedback"
                                            :disabled="savingFeedback"
                                            class="mt-3 w-full py-2.5 px-4 border border-transparent text-sm font-semibold rounded-xl text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-300 transition disabled:opacity-50"
                                        >
                                            {{ savingFeedback ? 'Saving...' : 'Save Feedback' }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Job Information Card -->
                            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 shadow-xl rounded-2xl border border-emerald-100 overflow-hidden">
                                <div class="px-6 py-4 sm:px-8">
                                    <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        Job Information
                                    </h3>
                                </div>
                                <div class="px-6 py-6 sm:px-8 bg-white/50">
                                    <div class="space-y-4">
                                        <div class="flex justify-between items-center p-3 bg-white rounded-lg border border-emerald-100">
                                            <span class="text-sm font-medium text-emerald-700">Position</span>
                                            <span class="text-sm font-semibold text-gray-900">{{ application.job.title }}</span>
                                        </div>
                                        <div class="flex justify-between items-center p-3 bg-white rounded-lg border border-emerald-100">
                                            <span class="text-sm font-medium text-emerald-700">Subject</span>
                                            <span class="text-sm font-semibold text-gray-900">{{ formatSubjectName(application.job.subject) }}</span>
                                        </div>
                                        <div class="flex justify-between items-center p-3 bg-white rounded-lg border border-emerald-100">
                                            <span class="text-sm font-medium text-emerald-700">Level</span>
                                            <span class="text-sm font-semibold text-gray-900">{{ formatLevelName(application.job.level) }}</span>
                                        </div>
                                        <div class="flex justify-between items-center p-3 bg-white rounded-lg border border-emerald-100">
                                            <span class="text-sm font-medium text-emerald-700">Type</span>
                                            <span class="text-sm font-semibold text-gray-900 capitalize">{{ application.job.employment_type.replace('_', ' ') }}</span>
                                        </div>
                                        <div class="flex justify-between items-center p-3 bg-white rounded-lg border border-emerald-100">
                                            <span class="text-sm font-medium text-emerald-700">Salary</span>
                                            <span class="text-sm font-bold text-emerald-700">{{ application.job.salary_range }}</span>
                                        </div>
                                        <div class="flex justify-between items-center p-3 bg-white rounded-lg border border-emerald-100">
                                            <span class="text-sm font-medium text-emerald-700">Deadline</span>
                                            <span class="text-sm font-semibold text-gray-900">{{ formatDate(application.job.application_deadline) }}</span>
                                        </div>
                                    </div>
                                    <div class="mt-6">
                                        <Link
                                            :href="route('school.jobs.edit', application.job.id)"
                                            class="inline-flex items-center justify-center w-full px-4 py-2.5 border border-emerald-300 text-sm font-semibold rounded-xl text-emerald-700 bg-white hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-200 transition"
                                        >
                                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit Job Posting
                                        </Link>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Teacher -->
                            <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 overflow-hidden">
                                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 sm:px-8">
                                    <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        Contact Teacher
                                    </h3>
                                </div>
                                <div class="px-6 py-6 sm:px-8">
                                    <div class="space-y-4">
                                        <div class="text-center">
                                            <p class="text-sm text-gray-600 mb-4">
                                                Contact the teacher for interview or further questions
                                            </p>
                                        </div>
                                        <div class="space-y-3">
                                            <a v-if="application.teacher.email"
                                               :href="'mailto:' + application.teacher.email"
                                               class="flex items-center justify-center px-4 py-3 border border-emerald-300 text-sm font-semibold rounded-xl text-emerald-700 bg-white hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-200 transition"
                                            >
                                                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                Send Email
                                            </a>
                                            <a v-if="application.teacher.teacher_profile?.phone"
                                               :href="'tel:' + application.teacher.teacher_profile.phone"
                                               class="flex items-center justify-center px-4 py-3 border border-emerald-300 text-sm font-semibold rounded-xl text-emerald-700 bg-white hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-200 transition"
                                            >
                                                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                                Call Teacher
                                            </a>
                                        </div>
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
import { ref } from 'vue'

const props = defineProps({
    application: Object
})

const feedback = ref(props.application.school_feedback || '')
const savingFeedback = ref(false)

const statusOptions = [
    {
        value: 'pending',
        label: 'Pending Review',
        description: 'Application is waiting for review',
        icon: 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
        class: 'border-yellow-200 bg-yellow-50',
        activeClass: 'border-yellow-300 bg-yellow-100',
        iconBg: 'bg-yellow-100',
        iconColor: 'text-yellow-600',
        textColor: 'text-yellow-800'
    },
    {
        value: 'reviewed',
        label: 'Reviewed',
        description: 'Application has been reviewed',
        icon: 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z',
        class: 'border-blue-200 bg-blue-50',
        activeClass: 'border-blue-300 bg-blue-100',
        iconBg: 'bg-blue-100',
        iconColor: 'text-blue-600',
        textColor: 'text-blue-800'
    },
    {
        value: 'shortlisted',
        label: 'Shortlisted',
        description: 'Candidate has been shortlisted',
        icon: 'M5 13l4 4L19 7',
        class: 'border-green-200 bg-green-50',
        activeClass: 'border-green-300 bg-green-100',
        iconBg: 'bg-green-100',
        iconColor: 'text-green-600',
        textColor: 'text-green-800'
    },
    {
        value: 'rejected',
        label: 'Rejected',
        description: 'Application has been rejected',
        icon: 'M6 18L18 6M6 6l12 12',
        class: 'border-red-200 bg-red-50',
        activeClass: 'border-red-300 bg-red-100',
        iconBg: 'bg-red-100',
        iconColor: 'text-red-600',
        textColor: 'text-red-800'
    }
]

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    })
}

const formatStatus = (status) => {
    const statusMap = {
        'pending': 'Pending Review',
        'reviewed': 'Reviewed',
        'shortlisted': 'Shortlisted',
        'rejected': 'Rejected'
    }
    return statusMap[status] || status
}

const statusBadgeClass = (status) => {
    const classes = {
        'pending': 'bg-yellow-100 text-yellow-800',
        'reviewed': 'bg-blue-100 text-blue-800',
        'shortlisted': 'bg-green-100 text-green-800',
        'rejected': 'bg-red-100 text-red-800'
    }
    return classes[status] || 'bg-gray-100 text-gray-800'
}

const formatSubjectName = (subject) => {
    return subject.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())
}

const formatLevelName = (level) => {
    return level.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())
}

const updateStatus = (status) => {
    if (confirm('Are you sure you want to update the application status?')) {
        router.post(route('school.applications.update-status', props.application.id), {
            status: status,
            feedback: feedback.value
        }, {
            preserveScroll: true,
            onSuccess: () => {
                router.reload()
            }
        })
    }
}

const saveFeedback = () => {
    savingFeedback.value = true
    router.post(route('school.applications.update-status', props.application.id), {
        status: props.application.status, // Keep same status
        feedback: feedback.value
    }, {
        preserveScroll: true,
        onFinish: () => {
            savingFeedback.value = false
        }
    })
}

const getStrengthsArray = (appraisal) => {
    if (!appraisal || !appraisal.strengths) return []

    if (Array.isArray(appraisal.strengths)) {
        return appraisal.strengths
    }

    // Try to parse string into array
    const text = appraisal.strengths.toString()
    const separators = ['. ', '; ', '| ', '• ', '- ']
    for (const sep of separators) {
        if (text.includes(sep)) {
            return text.split(sep).map(item => item.trim()).filter(item => item)
        }
    }

    // If no separators found, wrap as single item array
    return [text]
}

const getImprovementAreasArray = (appraisal) => {
    if (!appraisal || !appraisal.improvement_areas) return []

    if (Array.isArray(appraisal.improvement_areas)) {
        return appraisal.improvement_areas
    }

    // Try to parse string into array
    const text = appraisal.improvement_areas.toString()
    const separators = ['. ', '; ', '| ', '• ', '- ']
    for (const sep of separators) {
        if (text.includes(sep)) {
            return text.split(sep).map(item => item.trim()).filter(item => item)
        }
    }

    // If no separators found, wrap as single item array
    return [text]
}

const getGradeFromScore = (score) => {
    if (score >= 90) return 'A+'
    if (score >= 80) return 'A'
    if (score >= 70) return 'B'
    if (score >= 60) return 'C'
    if (score >= 50) return 'D'
    return 'F'
}

const getGradeBadgeClass = (score) => {
    if (score >= 90) return 'bg-green-100 text-green-800'
    if (score >= 80) return 'bg-blue-100 text-blue-800'
    if (score >= 70) return 'bg-yellow-100 text-yellow-800'
    if (score >= 60) return 'bg-orange-100 text-orange-800'
    if (score >= 50) return 'bg-red-100 text-red-800'
    return 'bg-gray-100 text-gray-800'
}
</script>
