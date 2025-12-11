<template>
  <AppLayout title="Job Applicants">
    <div class="min-h-screen bg-gradient-to-b from-emerald-50 via-teal-50 to-white">
      <!-- Navigation -->
      <nav class="bg-gradient-to-r from-emerald-600 to-teal-600 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between h-16">
            <div class="flex items-center">
              <div class="flex items-center space-x-3">
                <Link :href="route('school.jobs')" class="text-white hover:text-emerald-100 transition">
                  <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                  </svg>
                </Link>
                <div>
                  <h1 class="text-xl font-bold text-white">Job Applicants</h1>
                  <p class="text-xs text-emerald-100">Review and manage applications</p>
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
                :href="route('school.jobs')"
                class="text-sm font-medium text-white hover:text-emerald-100 transition"
              >
                Job Postings
              </Link>
            </div>
          </div>
        </div>
      </nav>

      <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <!-- Job Header -->
          <div class="bg-white shadow-2xl rounded-2xl border border-emerald-100 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-5 sm:px-8">
              <div class="flex flex-col lg:flex-row lg:items-center justify-between">
                <div class="flex-1">
                  <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ job.title }}</h1>
                  <div class="flex flex-wrap items-center gap-4 text-gray-600">
                    <div class="flex items-center">
                      <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                      </svg>
                      {{ job.state }}, {{ job.lga }}
                    </div>
                    <div class="flex items-center">
                      <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      {{ job.salary_range }}
                    </div>
                    <div class="flex items-center">
                      <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      Deadline: {{ formatDate(job.application_deadline) }}
                    </div>
                  </div>
                </div>
                <div class="mt-4 lg:mt-0 lg:ml-4">
                  <div class="flex flex-wrap gap-3">
                    <span class="px-3 py-1 rounded-full text-sm font-bold bg-blue-100 text-blue-800">
                      {{ job.subject.replace('_', ' ').toUpperCase() }}
                    </span>
                    <span class="px-3 py-1 rounded-full text-sm font-bold bg-purple-100 text-purple-800">
                      {{ job.level.replace('_', ' ').toUpperCase() }}
                    </span>
                    <span class="px-3 py-1 rounded-full text-sm font-bold bg-emerald-100 text-emerald-800">
                      {{ job.employment_type.replace('_', ' ').toUpperCase() }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Stats Cards -->
          <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 p-6">
              <div class="flex items-center">
                <div class="p-3 rounded-xl bg-emerald-100 mr-4">
                  <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                  </svg>
                </div>
                <div>
                  <p class="text-sm text-gray-600">Total Applicants</p>
                  <p class="text-2xl font-bold text-gray-900">{{ totalApplicants }}</p>
                </div>
              </div>
            </div>

            <div class="bg-white shadow-xl rounded-2xl border border-green-100 p-6">
              <div class="flex items-center">
                <div class="p-3 rounded-xl bg-green-100 mr-4">
                  <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <div>
                  <p class="text-sm text-gray-600">Shortlisted</p>
                  <p class="text-2xl font-bold text-green-700">{{ stats.shortlisted }}</p>
                </div>
              </div>
            </div>

            <div class="bg-white shadow-xl rounded-2xl border border-yellow-100 p-6">
              <div class="flex items-center">
                <div class="p-3 rounded-xl bg-yellow-100 mr-4">
                  <svg class="w-6 h-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <div>
                  <p class="text-sm text-gray-600">Pending</p>
                  <p class="text-2xl font-bold text-yellow-700">{{ stats.pending }}</p>
                </div>
              </div>
            </div>

            <div class="bg-white shadow-xl rounded-2xl border border-blue-100 p-6">
              <div class="flex items-center">
                <div class="p-3 rounded-xl bg-blue-100 mr-4">
                  <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                </div>
                <div>
                  <p class="text-sm text-gray-600">Reviewed</p>
                  <p class="text-2xl font-bold text-blue-700">{{ stats.reviewed }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Filters and Actions -->
          <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 p-6 mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
              <div class="flex-1">
                <div class="flex flex-wrap gap-4">
                  <div class="relative">
                    <input
                      type="text"
                      v-model="search"
                      placeholder="Search applicants..."
                      class="pl-10 pr-4 py-2.5 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition w-full lg:w-64"
                    />
                    <svg class="absolute left-3 top-3 w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                  </div>

                  <select
                    v-model="statusFilter"
                    class="px-4 py-2.5 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                  >
                    <option value="">All Status</option>
                    <option value="pending">Pending Review</option>
                    <option value="reviewed">Reviewed</option>
                    <option value="shortlisted">Shortlisted</option>
                    <option value="rejected">Rejected</option>
                  </select>

                  <select
                    v-model="sortBy"
                    class="px-4 py-2.5 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                  >
                    <option value="newest">Newest First</option>
                    <option value="oldest">Oldest First</option>
                    <option value="score">Highest Score</option>
                    <option value="experience">Most Experience</option>
                  </select>
                </div>
              </div>

              <div class="flex items-center space-x-3">
                <button
                  @click="exportApplicants"
                  class="inline-flex items-center px-4 py-2.5 border border-emerald-300 text-sm font-semibold rounded-xl text-emerald-700 bg-white hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-200 transition"
                >
                  <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                  </svg>
                  Export
                </button>
                <button
                  @click="bulkShortlist"
                  class="inline-flex items-center px-4 py-2.5 border border-transparent text-sm font-semibold rounded-xl text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-300 transition"
                >
                  <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  Bulk Shortlist
                </button>
              </div>
            </div>
          </div>

          <!-- Applicants List -->
          <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 overflow-hidden">
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-emerald-50 to-teal-50">
                  <tr>
                    <th class="px-6 py-3 text-left">
                      <div class="flex items-center">
                        <input
                          type="checkbox"
                          v-model="selectAll"
                          @change="toggleSelectAll"
                          class="h-4 w-4 text-emerald-600 rounded border-gray-300 focus:ring-emerald-500"
                        />
                      </div>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-emerald-700 uppercase tracking-wider">
                      Applicant
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-emerald-700 uppercase tracking-wider">
                      AI Appraisal
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-emerald-700 uppercase tracking-wider">
                      Experience
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-emerald-700 uppercase tracking-wider">
                      Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-emerald-700 uppercase tracking-wider">
                      Applied Date
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-emerald-700 uppercase tracking-wider">
                      Actions
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                  <tr
                    v-for="application in filteredApplications"
                    :key="application.id"
                    class="hover:bg-emerald-50 transition-colors"
                  >
                    <td class="px-6 py-4 whitespace-nowrap">
                      <input
                        type="checkbox"
                        :value="application.id"
                        v-model="selectedApplications"
                        class="h-4 w-4 text-emerald-600 rounded border-gray-300 focus:ring-emerald-500"
                      />
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10">
                          <div class="h-10 w-10 rounded-full bg-gradient-to-r from-emerald-100 to-teal-100 flex items-center justify-center">
                            <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                          </div>
                        </div>
                        <div class="ml-4">
                          <div class="text-sm font-semibold text-gray-900">
                            {{ application.teacher.name }}
                          </div>
                          <div class="text-sm text-gray-500">
                            {{ application.teacher.email }}
                          </div>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div v-if="application.teacher.appraisals?.length > 0">
                        <div class="flex items-center">
                          <div class="flex-shrink-0 w-16">
                            <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                              <div class="h-full bg-emerald-600 rounded-full"
                                   :style="{ width: application.teacher.appraisals[0].overall_score + '%' }"></div>
                            </div>
                          </div>
                          <div class="ml-3">
                            <div class="text-sm font-semibold text-gray-900">
                              {{ application.teacher.appraisals[0].overall_score }}%
                            </div>
                            <div class="text-xs text-gray-500">
                              {{ getGradeFromScore(application.teacher.appraisals[0].overall_score) }}
                            </div>
                          </div>
                        </div>
                      </div>
                      <div v-else class="text-sm text-gray-500 italic">
                        No appraisal
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">
                        {{ application.teacher.teacher_profile?.years_of_experience || '0' }} years
                      </div>
                      <div class="text-sm text-gray-500">
                        {{ application.teacher.teacher_profile?.qualification || 'Not specified' }}
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span :class="statusBadgeClass(application.status)"
                            class="px-3 py-1 rounded-full text-xs font-bold">
                        {{ formatStatus(application.status) }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                      {{ formatDate(application.created_at) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                      <div class="flex items-center space-x-2">
                        <Link
                          :href="route('school.applications.show', application.id)"
                          class="text-emerald-600 hover:text-emerald-900 transition"
                          title="View Details"
                        >
                          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                          </svg>
                        </Link>
                        <button
                          @click="updateStatus(application.id, 'shortlisted')"
                          v-if="application.status !== 'shortlisted'"
                          class="text-green-600 hover:text-green-900 transition"
                          title="Shortlist"
                        >
                          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                          </svg>
                        </button>
                        <button
                          @click="updateStatus(application.id, 'rejected')"
                          v-if="application.status !== 'rejected'"
                          class="text-red-600 hover:text-red-900 transition"
                          title="Reject"
                        >
                          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                          </svg>
                        </button>
                        <a
                          :href="'mailto:' + application.teacher.email"
                          class="text-blue-600 hover:text-blue-900 transition"
                          title="Email"
                        >
                          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                          </svg>
                        </a>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- No Results -->
            <div v-if="filteredApplications.length === 0" class="text-center py-12">
              <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
              </svg>
              <h3 class="mt-2 text-sm font-semibold text-gray-900">No applicants found</h3>
              <p class="mt-1 text-sm text-gray-500">
                {{ search || statusFilter ? 'Try adjusting your filters' : 'No one has applied for this position yet.' }}
              </p>
            </div>

            <!-- Pagination -->
<div v-if="applications.data.length > 0" class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 sm:px-8 border-t border-emerald-100">
  <div class="flex flex-col md:flex-row md:items-center md:justify-between">
    <div class="mb-4 md:mb-0">
      <p class="text-sm text-gray-700">
        Showing
        <span class="font-medium">{{ applications.from }}</span>
        to
        <span class="font-medium">{{ applications.to }}</span>
        of
        <span class="font-medium">{{ applications.total }}</span>
        results
      </p>
    </div>
    <div class="flex items-center space-x-2">
      <template v-if="applications.links">
        <!-- Previous Button -->
        <Link
          v-if="applications.current_page > 1"
          :href="applications.prev_page_url"
          class="inline-flex items-center px-3 py-2 border border-emerald-300 text-sm font-medium rounded-lg text-emerald-700 bg-white hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-200 transition"
        >
          Previous
        </Link>

        <!-- Page Numbers -->
        <template v-for="(link, index) in applications.links" :key="index">
          <Link
            v-if="link.url && !link.active && link.label !== '...'"
            :href="link.url"
            class="inline-flex items-center px-3 py-2 border border-emerald-300 text-sm font-medium rounded-lg text-emerald-700 bg-white hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-200 transition"
          >
            {{ link.label }}
          </Link>
          <span
            v-else-if="link.active"
            class="inline-flex items-center px-3 py-2 border border-emerald-500 text-sm font-medium rounded-lg text-white bg-emerald-600"
          >
            {{ link.label }}
          </span>
          <span
            v-else-if="link.label === '...'"
            class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700"
          >
            {{ link.label }}
          </span>
        </template>

        <!-- Next Button -->
        <Link
          v-if="applications.current_page < applications.last_page"
          :href="applications.next_page_url"
          class="inline-flex items-center px-3 py-2 border border-emerald-300 text-sm font-medium rounded-lg text-emerald-700 bg-white hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-200 transition"
        >
          Next
        </Link>
      </template>
    </div>
  </div>
</div>
          </div>

          <!-- Quick Actions Card -->
          <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Send Bulk Email -->
            <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 overflow-hidden">
              <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 sm:px-8">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                  <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                  </svg>
                  Bulk Email
                </h3>
              </div>
              <div class="px-6 py-6 sm:px-8">
                <p class="text-sm text-gray-600 mb-4">
                  Send email to selected applicants
                </p>
                <div class="space-y-3">
                  <textarea
                    v-model="bulkEmailContent"
                    rows="3"
                    class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                    placeholder="Type your message here..."
                  ></textarea>
                  <button
                    @click="sendBulkEmail"
                    :disabled="selectedApplications.length === 0 || sendingBulkEmail"
                    class="w-full py-2.5 px-4 border border-transparent text-sm font-semibold rounded-xl text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-300 transition disabled:opacity-50"
                  >
                    {{ sendingBulkEmail ? 'Sending...' : `Send to ${selectedApplications.length} selected` }}
                  </button>
                </div>
              </div>
            </div>

            <!-- Quick Status Update -->
            <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 overflow-hidden">
              <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 sm:px-8">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                  <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                  </svg>
                  Quick Status Update
                </h3>
              </div>
              <div class="px-6 py-6 sm:px-8">
                <p class="text-sm text-gray-600 mb-4">
                  Update status for selected applicants
                </p>
                <div class="flex flex-wrap gap-2">
                  <button
                    @click="bulkUpdateStatus('shortlisted')"
                    :disabled="selectedApplications.length === 0"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-300 transition disabled:opacity-50"
                  >
                    Shortlist Selected
                  </button>
                  <button
                    @click="bulkUpdateStatus('reviewed')"
                    :disabled="selectedApplications.length === 0"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 transition disabled:opacity-50"
                  >
                    Mark as Reviewed
                  </button>
                  <button
                    @click="bulkUpdateStatus('rejected')"
                    :disabled="selectedApplications.length === 0"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300 transition disabled:opacity-50"
                  >
                    Reject Selected
                  </button>
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
import { ref, computed, watch } from 'vue'
import { debounce } from 'lodash'

const props = defineProps({
  job: Object,
  applications: Object
})

// Reactive data
const search = ref('')
const statusFilter = ref('')
const sortBy = ref('newest')
const selectedApplications = ref([])
const selectAll = ref(false)
const bulkEmailContent = ref('')
const sendingBulkEmail = ref(false)

// Computed properties
const totalApplicants = computed(() => {
  return props.applications.total || props.applications.data.length
})

const stats = computed(() => {
  const stats = {
    pending: 0,
    reviewed: 0,
    shortlisted: 0,
    rejected: 0
  }

  props.applications.data.forEach(app => {
    if (stats[app.status] !== undefined) {
      stats[app.status]++
    }
  })

  return stats
})

const filteredApplications = computed(() => {
  let filtered = [...props.applications.data]

  // Apply search filter
  if (search.value) {
    const searchTerm = search.value.toLowerCase()
    filtered = filtered.filter(app =>
      app.teacher.name.toLowerCase().includes(searchTerm) ||
      app.teacher.email.toLowerCase().includes(searchTerm) ||
      (app.teacher.teacher_profile?.qualification?.toLowerCase().includes(searchTerm) || false)
    )
  }

  // Apply status filter
  if (statusFilter.value) {
    filtered = filtered.filter(app => app.status === statusFilter.value)
  }

  // Apply sorting
  switch (sortBy.value) {
    case 'oldest':
      filtered.sort((a, b) => new Date(a.created_at) - new Date(b.created_at))
      break
    case 'score':
      filtered.sort((a, b) => {
        const scoreA = a.teacher.appraisals?.[0]?.overall_score || 0
        const scoreB = b.teacher.appraisals?.[0]?.overall_score || 0
        return scoreB - scoreA
      })
      break
    case 'experience':
      filtered.sort((a, b) => {
        const expA = parseInt(a.teacher.teacher_profile?.years_of_experience) || 0
        const expB = parseInt(b.teacher.teacher_profile?.years_of_experience) || 0
        return expB - expA
      })
      break
    case 'newest':
    default:
      filtered.sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
  }

  return filtered
})

// Methods
const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
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

const getGradeFromScore = (score) => {
  if (score >= 90) return 'A+'
  if (score >= 80) return 'A'
  if (score >= 70) return 'B'
  if (score >= 60) return 'C'
  if (score >= 50) return 'D'
  return 'F'
}

const toggleSelectAll = () => {
  if (selectAll.value) {
    selectedApplications.value = filteredApplications.value.map(app => app.id)
  } else {
    selectedApplications.value = []
  }
}

// Watch for filtered applications changes
watch(filteredApplications, () => {
  const allSelected = filteredApplications.value.every(app =>
    selectedApplications.value.includes(app.id)
  )
  selectAll.value = allSelected
})

const updateStatus = (applicationId, status) => {
  if (confirm('Are you sure you want to update the application status?')) {
    router.post(route('school.applications.update-status', applicationId), {
      status: status
    }, {
      preserveScroll: true,
      onSuccess: () => {
        router.reload()
      }
    })
  }
}

const bulkUpdateStatus = (status) => {
  if (selectedApplications.value.length === 0) {
    alert('Please select at least one applicant')
    return
  }

  if (confirm(`Update status to ${formatStatus(status)} for ${selectedApplications.value.length} selected applicants?`)) {
    router.post(route('school.applications.bulk-update'), {
      application_ids: selectedApplications.value,
      status: status
    }, {
      preserveScroll: true,
      onSuccess: () => {
        selectedApplications.value = []
        selectAll.value = false
        router.reload()
      }
    })
  }
}

const bulkShortlist = () => {
  if (filteredApplications.value.length === 0) {
    alert('No applicants to shortlist')
    return
  }

  if (confirm(`Shortlist all ${filteredApplications.value.length} applicants?`)) {
    const allIds = filteredApplications.value.map(app => app.id)
    router.post(route('school.applications.bulk-update'), {
      application_ids: allIds,
      status: 'shortlisted'
    }, {
      preserveScroll: true,
      onSuccess: () => {
        router.reload()
      }
    })
  }
}

const sendBulkEmail = () => {
  if (selectedApplications.value.length === 0) {
    alert('Please select at least one applicant')
    return
  }

  if (!bulkEmailContent.value.trim()) {
    alert('Please enter email content')
    return
  }

  sendingBulkEmail.value = true
  router.post(route('school.applications.bulk-email'), {
    application_ids: selectedApplications.value,
    subject: `Update regarding your application for ${props.job.title}`,
    message: bulkEmailContent.value
  }, {
    preserveScroll: true,
    onSuccess: () => {
      bulkEmailContent.value = ''
      selectedApplications.value = []
      selectAll.value = false
      alert('Email sent successfully')
    },
    onFinish: () => {
      sendingBulkEmail.value = false
    }
  })
}

const exportApplicants = () => {
  router.post(route('school.applications.export', props.job.id), {
    search: search.value,
    status: statusFilter.value,
    sort: sortBy.value
  })
}
</script>
