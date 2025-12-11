<template>
    <AppLayout title="Job Details">
        <div class="min-h-screen bg-gradient-to-b from-emerald-50 via-teal-50 to-white">
            <!-- Navigation -->
            <nav class="bg-gradient-to-r from-emerald-600 to-teal-600 shadow-lg">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <div class="flex items-center space-x-3">
                                <Link :href="route('teacher.jobs')" class="text-white hover:text-emerald-100 transition">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                </Link>
                                <div>
                                    <h1 class="text-xl font-bold text-white">Job Details</h1>
                                    <p class="text-xs text-emerald-100">View and apply for teaching positions</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <Link
                                :href="route('teacher.dashboard')"
                                class="text-sm font-medium text-white hover:text-emerald-100 transition"
                            >
                                Dashboard
                            </Link>
                            <Link
                                :href="route('teacher.applications')"
                                class="text-sm font-medium text-white hover:text-emerald-100 transition"
                            >
                                My Applications
                            </Link>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="py-8">
                <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                    <!-- Job Header Card -->
                    <div class="bg-white shadow-2xl rounded-2xl border border-emerald-100 overflow-hidden mb-6">
                        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-5 sm:px-8">
                            <div class="flex flex-col lg:flex-row lg:items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-start space-x-4">
                                        <!-- School Icon -->
                                        <div class="flex-shrink-0">
                                            <div class="w-16 h-16 rounded-xl bg-gradient-to-r from-emerald-100 to-teal-100 flex items-center justify-center">
                                                <svg class="w-8 h-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                            </div>
                                        </div>

                                        <!-- Job Title & School -->
                                        <div class="flex-1">
                                            <h1 class="text-3xl font-bold text-gray-900">{{ job.title }}</h1>
                                            <div class="flex items-center space-x-4 mt-2">
                                                <p class="text-xl text-emerald-700 font-semibold">
                                                    {{ job.school.school_profile.school_name }}
                                                </p>
                                                <span :class="employmentTypeBadgeClass(job.employment_type)"
                                                      class="px-3 py-1 rounded-full text-sm font-bold">
                                                    {{ formatEmploymentType(job.employment_type) }}
                                                </span>
                                            </div>
                                            <p class="text-gray-600 mt-2 flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                {{ job.school.school_profile.address }}, {{ job.state }}, {{ job.lga }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Salary & Application Info -->
                                <div class="mt-4 lg:mt-0 lg:ml-4">
                                    <div class="bg-white rounded-xl p-4 shadow-lg border border-emerald-200">
                                        <div class="text-center">
                                            <p class="text-sm font-medium text-emerald-600">Salary Range</p>
                                            <p class="text-2xl font-bold text-gray-900 mt-1">{{ job.salary_range }}</p>
                                            <div class="mt-3 flex items-center justify-center space-x-2">
                                                <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span class="text-sm font-semibold" :class="daysLeft <= 3 ? 'text-red-600' : 'text-emerald-600'">
                                                    {{ daysLeft }} day{{ daysLeft !== 1 ? 's' : '' }} left to apply
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Main Content -->
                        <div class="lg:col-span-2 space-y-8">
                            <!-- Job Description Card -->
                            <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 overflow-hidden">
                                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 sm:px-8">
                                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Job Description
                                    </h2>
                                </div>
                                <div class="px-6 py-6 sm:px-8">
                                    <div class="prose max-w-none text-gray-700 leading-relaxed whitespace-pre-line">
                                        {{ job.description }}
                                    </div>
                                </div>
                            </div>

                            <!-- Requirements Card -->
                            <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 overflow-hidden">
                                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 sm:px-8">
                                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                        Position Requirements
                                    </h2>
                                </div>
                                <div class="px-6 py-6 sm:px-8">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-6">
                                            <!-- Subject -->
                                            <div class="flex items-center p-4 bg-emerald-50 rounded-xl">
                                                <div class="p-3 rounded-lg bg-emerald-100 mr-4">
                                                    <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-emerald-600">Subject</p>
                                                    <p class="text-lg font-semibold text-gray-900">{{ formatSubjectName(job.subject) }}</p>
                                                </div>
                                            </div>

                                            <!-- Level -->
                                            <div class="flex items-center p-4 bg-emerald-50 rounded-xl">
                                                <div class="p-3 rounded-lg bg-emerald-100 mr-4">
                                                    <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-emerald-600">Level</p>
                                                    <p class="text-lg font-semibold text-gray-900">{{ formatLevelName(job.level) }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="space-y-6">
                                            <!-- Class Grade -->
                                            <div class="flex items-center p-4 bg-emerald-50 rounded-xl">
                                                <div class="p-3 rounded-lg bg-emerald-100 mr-4">
                                                    <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-emerald-600">Class/Grade</p>
                                                    <p class="text-lg font-semibold text-gray-900">{{ job.class_grade || 'Not specified' }}</p>
                                                </div>
                                            </div>

                                            <!-- Application Deadline -->
                                            <div class="flex items-center p-4 bg-emerald-50 rounded-xl">
                                                <div class="p-3 rounded-lg bg-emerald-100 mr-4">
                                                    <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-emerald-600">Application Deadline</p>
                                                    <p class="text-lg font-semibold" :class="daysLeft <= 3 ? 'text-red-600' : 'text-gray-900'">
                                                        {{ formatDate(job.application_deadline) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="space-y-8">
                            <!-- Application Action Card -->
                            <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 overflow-hidden">
                                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 sm:px-8">
                                    <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        Apply for Position
                                    </h3>
                                </div>

                                <div class="px-6 py-6 sm:px-8">
                                    <div v-if="hasApplied" class="bg-gradient-to-r from-amber-50 to-amber-100/50 border border-amber-200 rounded-xl p-5">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 p-2 rounded-lg bg-amber-100">
                                                <svg class="w-6 h-6 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <h3 class="text-base font-bold text-amber-800">Application Submitted</h3>
                                                <p class="mt-1 text-sm text-amber-700">You have already applied for this position.</p>
                                                <div class="mt-3">
                                                    <Link
                                                        :href="route('teacher.applications')"
                                                        class="inline-flex items-center text-sm font-semibold text-amber-700 hover:text-amber-800 transition"
                                                    >
                                                        View your applications
                                                        <svg class="ml-1 w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                        </svg>
                                                    </Link>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div v-else>
                                        <p class="text-emerald-700 mb-4">
                                            Submit your application for this teaching position. Your teacher profile will be shared with the school.
                                        </p>

                                        <form @submit.prevent="submitApplication">
                                            <div class="mb-5">
                                                <label for="cover_letter" class="block text-sm font-semibold text-emerald-700 mb-2">
                                                    <div class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                                        </svg>
                                                        Cover Letter (Optional)
                                                    </div>
                                                </label>
                                                <textarea
                                                    id="cover_letter"
                                                    v-model="form.cover_letter"
                                                    rows="4"
                                                    class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                                                    placeholder="Briefly explain why you're interested in this position..."
                                                ></textarea>
                                                <p class="text-xs text-gray-500 mt-1">Add a personalized note to the school (optional)</p>
                                            </div>

                                            <button
                                                type="submit"
                                                :disabled="processing"
                                                class="w-full flex justify-center items-center py-3.5 border border-transparent text-base font-bold rounded-xl shadow-lg text-white transition transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                                                :class="processing
                                                    ? 'bg-emerald-400'
                                                    : 'bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-4 focus:ring-emerald-300'"
                                            >
                                                <svg v-if="!processing" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                                {{ processing ? 'Submitting Application...' : 'Submit Application' }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- School Information Card -->
                            <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 overflow-hidden">
                                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 sm:px-8">
                                    <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        School Information
                                    </h3>
                                </div>
                                <div class="px-6 py-6 sm:px-8">
                                    <div class="space-y-4">
                                        <div class="flex items-center p-3 bg-emerald-50 rounded-lg">
                                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center mr-3">
                                                <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-xs font-medium text-emerald-600">School Type</p>
                                                <p class="text-sm font-semibold text-gray-900">{{ formatSchoolType(job.school.school_profile.school_type) }}</p>
                                            </div>
                                        </div>

                                        <div class="flex items-center p-3 bg-emerald-50 rounded-lg">
                                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center mr-3">
                                                <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-xs font-medium text-emerald-600">Location</p>
                                                <p class="text-sm font-semibold text-gray-900">{{ job.school.school_profile.state }}, {{ job.school.school_profile.lga }}</p>
                                            </div>
                                        </div>

                                        <div class="flex items-center p-3 bg-emerald-50 rounded-lg">
                                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center mr-3">
                                                <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-xs font-medium text-emerald-600">Ownership</p>
                                                <p class="text-sm font-semibold text-gray-900 capitalize">{{ job.school.school_profile.ownership }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Important Dates Card -->
                            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 shadow-xl rounded-2xl border border-emerald-100 overflow-hidden">
                                <div class="px-6 py-4 sm:px-8">
                                    <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Important Dates
                                    </h3>
                                </div>
                                <div class="px-6 py-6 sm:px-8 bg-white/50">
                                    <div class="space-y-3">
                                        <div class="flex justify-between items-center p-3 bg-white rounded-lg border border-emerald-100">
                                            <span class="text-sm font-medium text-emerald-700">Posted Date</span>
                                            <span class="text-sm font-semibold text-gray-900">{{ formatDate(job.created_at) }}</span>
                                        </div>
                                        <div class="flex justify-between items-center p-3 bg-white rounded-lg border border-emerald-100">
                                            <span class="text-sm font-medium text-emerald-700">Application Deadline</span>
                                            <span class="text-sm font-semibold text-gray-900">{{ formatDate(job.application_deadline) }}</span>
                                        </div>
                                        <div class="flex justify-between items-center p-3 rounded-lg"
                                             :class="daysLeft <= 3 ? 'bg-red-50 border border-red-100' : 'bg-emerald-50 border border-emerald-100'">
                                            <span class="text-sm font-medium" :class="daysLeft <= 3 ? 'text-red-700' : 'text-emerald-700'">
                                                Days Remaining
                                            </span>
                                            <span class="text-lg font-bold" :class="daysLeft <= 3 ? 'text-red-700' : 'text-emerald-700'">
                                                {{ daysLeft }}
                                            </span>
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
import { Link, router, useForm } from '@inertiajs/vue3'
import { ref, computed } from 'vue'

const props = defineProps({
    job: Object,
    hasApplied: Boolean
})

const processing = ref(false)

const form = useForm({
    cover_letter: ''
})

const daysLeft = computed(() => {
    const deadline = new Date(props.job.application_deadline)
    const today = new Date()
    const diffTime = deadline - today
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24))
    return Math.max(0, diffDays)
})

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    })
}

const formatSubjectName = (subject) => {
    return subject.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())
}

const formatLevelName = (level) => {
    return level.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())
}

const formatSchoolType = (type) => {
    return type.toUpperCase()
}

const formatEmploymentType = (type) => {
    return type.replace(/_/g, ' ').toUpperCase()
}

const employmentTypeBadgeClass = (type) => {
    const classes = {
        'full_time': 'bg-emerald-100 text-emerald-800',
        'part_time': 'bg-blue-100 text-blue-800',
        'contract': 'bg-amber-100 text-amber-800',
        'temporary': 'bg-purple-100 text-purple-800'
    }
    return classes[type] || 'bg-gray-100 text-gray-800'
}

const submitApplication = () => {
    processing.value = true
    form.post(route('teacher.jobs.apply', props.job.id), {
        onFinish: () => {
            processing.value = false
        }
    })
}
</script>
