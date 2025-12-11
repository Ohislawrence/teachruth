<template>
    <AppLayout title="School Dashboard">
        <div class="min-h-screen bg-gradient-to-b from-emerald-50 via-teal-50 to-white">
            <!-- Navigation -->
            <nav class="bg-gradient-to-r from-emerald-600 to-teal-600 shadow-lg">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-white/20 rounded-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <div>
                                    <h1 class="text-xl font-bold text-white">School Dashboard</h1>
                                    <p class="text-xs text-emerald-100">Welcome back, {{ schoolProfile.school_name }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <Link
                                :href="route('school.profile')"
                                class="text-sm font-medium text-white hover:text-emerald-100 transition"
                            >
                                Profile
                            </Link>
                            <Link
                                :href="route('school.jobs')"
                                class="text-sm font-medium text-white hover:text-emerald-100 transition"
                            >
                                My Jobs
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
                    <!-- Welcome Banner -->
                    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 shadow-2xl rounded-2xl p-6 mb-8">
                        <div class="flex flex-col md:flex-row md:items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-16 h-16 rounded-xl bg-white/20 flex items-center justify-center mr-6">
                                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <div>
                                    <h1 class="text-2xl font-bold text-white">Welcome back, {{ schoolProfile.school_name }}!</h1>
                                    <p class="text-emerald-100 mt-2">
                                        {{ getGreeting() }} • {{ formatSchoolType(schoolProfile.school_type) }} School
                                        <span v-if="schoolProfile.is_verified" class="ml-2 px-2 py-1 bg-white/20 rounded-full text-xs font-bold">
                                            ✓ Verified
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="mt-4 md:mt-0">
                                <Link
                                    :href="route('school.jobs.create')"
                                    class="inline-flex items-center px-6 py-3 bg-white text-emerald-700 font-bold rounded-xl shadow-lg hover:bg-emerald-50 focus:outline-none focus:ring-4 focus:ring-white/30 transition transform hover:-translate-y-0.5"
                                >
                                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Post New Job
                                </Link>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Overview -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <!-- Total Jobs -->
                        <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 p-6 hover:shadow-2xl transition-all duration-300">
                            <div class="flex items-center">
                                <div class="p-3 rounded-xl bg-emerald-100 mr-4">
                                    <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-emerald-600">Total Jobs Posted</p>
                                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ stats.total_jobs }}</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-xs font-semibold px-2 py-1 rounded-full"
                                         :class="stats.active_jobs > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'">
                                        {{ stats.active_jobs }} active
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <Link
                                    :href="route('school.jobs')"
                                    class="text-sm font-medium text-emerald-600 hover:text-emerald-700 inline-flex items-center"
                                >
                                    View all jobs
                                    <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </Link>
                            </div>
                        </div>

                        <!-- Active Jobs -->
                        <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 p-6 hover:shadow-2xl transition-all duration-300">
                            <div class="flex items-center">
                                <div class="p-3 rounded-xl bg-green-100 mr-4">
                                    <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-emerald-600">Active Jobs</p>
                                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ stats.active_jobs }}</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <p class="text-sm text-gray-600">
                                    Jobs currently accepting applications
                                </p>
                            </div>
                        </div>

                        <!-- Total Applications -->
                        <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 p-6 hover:shadow-2xl transition-all duration-300">
                            <div class="flex items-center">
                                <div class="p-3 rounded-xl bg-blue-100 mr-4">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-emerald-600">Total Applications</p>
                                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ stats.total_applications }}</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-xs font-semibold px-2 py-1 rounded-full bg-yellow-100 text-yellow-800">
                                        {{ stats.pending_applications }} pending
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <Link
                                    :href="route('school.applications')"
                                    class="text-sm font-medium text-emerald-600 hover:text-emerald-700 inline-flex items-center"
                                >
                                    Review applications
                                    <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </Link>
                            </div>
                        </div>

                        <!-- Pending Applications -->
                        <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 p-6 hover:shadow-2xl transition-all duration-300">
                            <div class="flex items-center">
                                <div class="p-3 rounded-xl bg-yellow-100 mr-4">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-emerald-600">Pending Review</p>
                                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ stats.pending_applications }}</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <p class="text-sm text-gray-600">
                                    Applications awaiting your review
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Left Column -->
                        <div class="lg:col-span-2 space-y-8">
                            <!-- Recent Applications -->
                            <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 overflow-hidden">
                                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 sm:px-8">
                                    <div class="flex items-center justify-between">
                                        <h2 class="text-xl font-bold text-gray-900 flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            Recent Applications
                                        </h2>
                                        <Link
                                            :href="route('school.applications')"
                                            class="text-sm font-medium text-emerald-600 hover:text-emerald-700"
                                        >
                                            View all
                                        </Link>
                                    </div>
                                </div>
                                <div class="divide-y divide-emerald-100">
                                    <div v-for="application in recentApplications" :key="application.id"
                                         class="px-6 py-4 hover:bg-emerald-50 transition">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-emerald-100 to-teal-100 flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-bold text-gray-900">{{ application.teacher.name }}</div>
                                                    <div class="text-sm text-gray-500">
                                                        Applied for {{ application.job.title }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-4">
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full"
                                                      :class="statusColor(application.status)">
                                                    {{ formatStatus(application.status) }}
                                                </span>
                                                <span class="text-sm text-gray-500">
                                                    {{ formatRelativeTime(application.created_at) }}
                                                </span>
                                                <Link
                                                    :href="route('school.applications.show', application.id)"
                                                    class="text-emerald-600 hover:text-emerald-700"
                                                >
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                    </svg>
                                                </Link>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Empty State -->
                                    <div v-if="recentApplications.length === 0" class="px-6 py-8 text-center">
                                        <div class="mx-auto w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">No applications yet</h3>
                                        <p class="text-emerald-600 mb-4">Applications will appear here when teachers apply to your jobs</p>
                                        <Link
                                            :href="route('school.jobs.create')"
                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-bold rounded-xl text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-300 transition"
                                        >
                                            Post a Job
                                        </Link>
                                    </div>
                                </div>
                            </div>

                            <!-- Recent Jobs -->
                            <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 overflow-hidden">
                                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 sm:px-8">
                                    <div class="flex items-center justify-between">
                                        <h2 class="text-xl font-bold text-gray-900 flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            Recent Job Postings
                                        </h2>
                                        <Link
                                            :href="route('school.jobs')"
                                            class="text-sm font-medium text-emerald-600 hover:text-emerald-700"
                                        >
                                            View all
                                        </Link>
                                    </div>
                                </div>
                                <div class="divide-y divide-emerald-100">
                                    <div v-for="job in recentJobs" :key="job.id"
                                         class="px-6 py-4 hover:bg-emerald-50 transition">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <div class="flex items-center">
                                                    <h4 class="text-base font-bold text-gray-900">{{ job.title }}</h4>
                                                    <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full"
                                                          :class="job.is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'">
                                                        {{ job.is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </div>
                                                <div class="mt-1 flex items-center text-sm text-gray-500">
                                                    <span class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                        </svg>
                                                        {{ formatSubjectName(job.subject) }}
                                                    </span>
                                                    <span class="mx-2">•</span>
                                                    <span>{{ formatLevelName(job.level) }}</span>
                                                    <span class="mx-2">•</span>
                                                    <span>{{ formatDate(job.application_deadline) }}</span>
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-4">
                                                <div class="text-right">
                                                    <div class="text-sm font-bold text-emerald-700">{{ job.applications_count || 0 }} applicants</div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ getDaysLeft(job.application_deadline) }} days left
                                                    </div>
                                                </div>
                                                <Link
                                                    :href="route('school.jobs.edit', job.id)"
                                                    class="text-emerald-600 hover:text-emerald-700"
                                                >
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </Link>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Empty State -->
                                    <div v-if="recentJobs.length === 0" class="px-6 py-8 text-center">
                                        <div class="mx-auto w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">No job postings yet</h3>
                                        <p class="text-emerald-600 mb-4">Create your first job posting to start receiving applications</p>
                                        <Link
                                            :href="route('school.jobs.create')"
                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-bold rounded-xl text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-300 transition"
                                        >
                                            Create First Job
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-8">
                            <!-- Quick Actions -->
                            <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 overflow-hidden">
                                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 sm:px-8">
                                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                        Quick Actions
                                    </h2>
                                </div>
                                <div class="p-6 space-y-4">
                                    <Link
                                        :href="route('school.jobs.create')"
                                        class="flex items-center justify-between p-4 bg-emerald-50 hover:bg-emerald-100 rounded-xl border border-emerald-200 transition group"
                                    >
                                        <div class="flex items-center">
                                            <div class="p-2 rounded-lg bg-emerald-100 group-hover:bg-emerald-200 mr-3 transition">
                                                <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-emerald-800">Post New Job</p>
                                                <p class="text-sm text-emerald-600">Create a teaching position</p>
                                            </div>
                                        </div>
                                        <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </Link>

                                    <Link
                                        :href="route('school.applications')"
                                        class="flex items-center justify-between p-4 bg-blue-50 hover:bg-blue-100 rounded-xl border border-blue-200 transition group"
                                    >
                                        <div class="flex items-center">
                                            <div class="p-2 rounded-lg bg-blue-100 group-hover:bg-blue-200 mr-3 transition">
                                                <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-blue-800">Review Applications</p>
                                                <p class="text-sm text-blue-600">{{ stats.pending_applications }} pending review</p>
                                            </div>
                                        </div>
                                        <svg class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </Link>

                                    <Link
                                        :href="route('school.profile')"
                                        class="flex items-center justify-between p-4 bg-amber-50 hover:bg-amber-100 rounded-xl border border-amber-200 transition group"
                                    >
                                        <div class="flex items-center">
                                            <div class="p-2 rounded-lg bg-amber-100 group-hover:bg-amber-200 mr-3 transition">
                                                <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-amber-800">Update Profile</p>
                                                <p class="text-sm text-amber-600">Edit school information</p>
                                            </div>
                                        </div>
                                        <svg class="w-5 h-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </Link>

                                    <div v-if="stats.pending_applications > 0"
                                         class="flex items-center justify-between p-4 bg-red-50 hover:bg-red-100 rounded-xl border border-red-200 transition cursor-pointer"
                                         @click="reviewPendingApplications">
                                        <div class="flex items-center">
                                            <div class="p-2 rounded-lg bg-red-100 hover:bg-red-200 mr-3 transition">
                                                <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-red-800">Urgent Review Needed</p>
                                                <p class="text-sm text-red-600">{{ stats.pending_applications }} pending applications</p>
                                            </div>
                                        </div>
                                        <svg class="w-5 h-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- School Profile Summary -->
                            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 shadow-xl rounded-2xl border border-emerald-100 overflow-hidden">
                                <div class="px-6 py-4 sm:px-8">
                                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        School Profile
                                    </h2>
                                </div>
                                <div class="px-6 py-6 sm:px-8 bg-white/50">
                                    <div class="space-y-4">
                                        <div class="flex items-center p-3 bg-white rounded-lg border border-emerald-100">
                                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center mr-3">
                                                <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-xs font-medium text-emerald-600">Location</p>
                                                <p class="text-sm font-semibold text-gray-900">
                                                    {{ schoolProfile.state }}, {{ schoolProfile.lga }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="flex items-center p-3 bg-white rounded-lg border border-emerald-100">
                                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center mr-3">
                                                <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-xs font-medium text-emerald-600">School Type</p>
                                                <p class="text-sm font-semibold text-gray-900">{{ formatSchoolType(schoolProfile.school_type) }}</p>
                                            </div>
                                        </div>

                                        <div class="flex items-center p-3 bg-white rounded-lg border border-emerald-100">
                                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center mr-3">
                                                <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-xs font-medium text-emerald-600">Ownership</p>
                                                <p class="text-sm font-semibold text-gray-900 capitalize">{{ schoolProfile.ownership }}</p>
                                            </div>
                                        </div>

                                        <div class="flex items-center p-3 bg-white rounded-lg border border-emerald-100">
                                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center mr-3">
                                                <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-xs font-medium text-emerald-600">Verification Status</p>
                                                <p class="text-sm font-semibold"
                                                   :class="schoolProfile.is_verified ? 'text-green-600' : 'text-amber-600'">
                                                    {{ schoolProfile.is_verified ? 'Verified' : 'Not Verified' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-6">
                                        <Link
                                            :href="route('school.profile')"
                                            class="w-full inline-flex items-center justify-center px-4 py-2.5 border border-emerald-300 text-sm font-semibold rounded-xl text-emerald-700 bg-white hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-200 transition"
                                        >
                                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit Profile
                                        </Link>
                                    </div>
                                </div>
                            </div>

                            <!-- Tips & Support -->
                            <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 overflow-hidden">
                                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 sm:px-8">
                                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Tips & Support
                                    </h2>
                                </div>
                                <div class="p-6 space-y-4">
                                    <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-4">
                                        <h4 class="font-semibold text-emerald-800 mb-2">Improve Your Applications</h4>
                                        <p class="text-sm text-emerald-700">
                                            Clear job descriptions with salary ranges attract 3x more qualified teachers.
                                        </p>
                                    </div>
                                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
                                        <h4 class="font-semibold text-blue-800 mb-2">Quick Response</h4>
                                        <p class="text-sm text-blue-700">
                                            Respond to applications within 48 hours to keep teachers interested.
                                        </p>
                                    </div>
                                    <div class="bg-amber-50 border border-amber-100 rounded-xl p-4">
                                        <h4 class="font-semibold text-amber-800 mb-2">Need Help?</h4>
                                        <p class="text-sm text-amber-700">
                                            Contact support for assistance with job postings or teacher screening.
                                        </p>
                                        <a href="mailto:support@teachingplatform.com"
                                           class="inline-flex items-center text-sm font-medium text-amber-600 hover:text-amber-700 mt-2">
                                            support@teachingplatform.com
                                        </a>
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
    stats: Object,
    recentApplications: Array,
    recentJobs: Array,
    schoolProfile: Object
})

const getGreeting = () => {
    const hour = new Date().getHours()
    if (hour < 12) return 'Good morning'
    if (hour < 18) return 'Good afternoon'
    return 'Good evening'
}

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric'
    })
}

const formatRelativeTime = (dateString) => {
    const date = new Date(dateString)
    const now = new Date()
    const diffInSeconds = Math.floor((now - date) / 1000)

    if (diffInSeconds < 60) return 'Just now'
    if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)}m ago`
    if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)}h ago`
    if (diffInSeconds < 604800) return `${Math.floor(diffInSeconds / 86400)}d ago`
    return formatDate(dateString)
}

const formatSubjectName = (subject) => {
    return subject.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())
}

const formatLevelName = (level) => {
    return level.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())
}

const formatSchoolType = (type) => {
    const types = {
        'nursery': 'Nursery/Preschool',
        'primary': 'Primary School',
        'secondary': 'Secondary School',
        'mixed': 'Mixed (Primary & Secondary)'
    }
    return types[type] || type.charAt(0).toUpperCase() + type.slice(1)
}

const formatStatus = (status) => {
    const statusMap = {
        'pending': 'Pending',
        'reviewed': 'Reviewed',
        'shortlisted': 'Shortlisted',
        'rejected': 'Rejected'
    }
    return statusMap[status] || status
}

const statusColor = (status) => {
    const colors = {
        'pending': 'bg-yellow-100 text-yellow-800',
        'reviewed': 'bg-blue-100 text-blue-800',
        'shortlisted': 'bg-green-100 text-green-800',
        'rejected': 'bg-red-100 text-red-800'
    }
    return colors[status] || 'bg-gray-100 text-gray-800'
}

const getDaysLeft = (deadline) => {
    const deadlineDate = new Date(deadline)
    const today = new Date()
    const diffTime = deadlineDate - today
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24))
    return Math.max(0, diffDays)
}

const reviewPendingApplications = () => {
    if (props.stats.pending_applications > 0) {
        router.visit(route('school.applications'), {
            data: { status: 'pending' }
        })
    }
}
</script>
