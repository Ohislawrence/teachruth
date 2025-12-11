<template>
<AppLayout title="Appraisals Management">
  <div class="min-h-screen bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <h1 class="text-xl font-semibold text-gray-900">Appraisals Management</h1>
          </div>
          <div class="flex items-center space-x-4">
            <Link :href="route('admin.appraisals.report')" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
              <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
              </svg>
              Reports
            </Link>
          </div>
        </div>
      </div>
    </nav>

    <div class="py-6">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Stats -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-4 mb-6">
          <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
              <dt class="text-sm font-medium text-gray-500 truncate">Total Appraisals</dt>
              <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ stats.total }}</dd>
            </div>
          </div>
          <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
              <dt class="text-sm font-medium text-gray-500 truncate">Average Score</dt>
              <dd class="mt-1 text-3xl font-semibold text-blue-600">{{ stats.average_score }}%</dd>
            </div>
          </div>
          <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
              <dt class="text-sm font-medium text-gray-500 truncate">This Month</dt>
              <dd class="mt-1 text-3xl font-semibold text-green-600">{{ stats.this_month }}</dd>
            </div>
          </div>
          <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
              <dt class="text-sm font-medium text-gray-500 truncate">Last Month</dt>
              <dd class="mt-1 text-3xl font-semibold text-orange-600">{{ stats.last_month }}</dd>
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
                placeholder="Teacher name or email..."
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
              />
            </div>

            <!-- Date From -->
            <div>
              <label for="date_from" class="block text-sm font-medium text-gray-700">From Date</label>
              <input
                type="date"
                id="date_from"
                v-model="filters.date_from"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
              />
            </div>

            <!-- Date To -->
            <div>
              <label for="date_to" class="block text-sm font-medium text-gray-700">To Date</label>
              <input
                type="date"
                id="date_to"
                v-model="filters.date_to"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
              />
            </div>

            <!-- Actions -->
            <div class="flex items-end space-x-2">
              <button
                @click="applyFilters"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
              >
                Apply Filters
              </button>
              <button
                @click="resetFilters"
                class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
              >
                Reset
              </button>
            </div>
          </div>
        </div>

        <!-- Appraisals List -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
          <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
              All Appraisals ({{ appraisals.total }})
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
              Comprehensive view of all teacher appraisals in the system.
            </p>
          </div>

          <ul class="divide-y divide-gray-200">
            <li v-for="appraisal in appraisals.data" :key="appraisal.id" class="px-4 py-4 sm:px-6 hover:bg-gray-50">
              <div class="flex items-center justify-between">
                <div class="flex-1">
                  <div class="flex items-center justify-between">
                    <div>
                      <h3 class="text-lg font-medium text-gray-900">
                        {{ appraisal.teacher?.name || 'Unknown Teacher' }}
                      </h3>
                      <p class="text-sm text-gray-600 mt-1">
                        {{ appraisal.teacher?.email || 'No email' }}
                      </p>
                      <p class="text-sm text-gray-500">
                        {{ formatDate(appraisal.created_at) }}
                        <span v-if="appraisal.is_latest" class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                          Latest
                        </span>
                      </p>
                    </div>
                    <div class="ml-2 flex-shrink-0 flex items-center space-x-4">
                      <div class="text-right">
                        <div class="text-2xl font-bold" :class="scoreColor(appraisal.overall_score)">
                          {{ appraisal.overall_score }}%
                        </div>
                        <div class="text-sm font-medium" :class="gradeColor(appraisal.grade)">
                          Grade: {{ appraisal.grade }}
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Competency Scores -->
                  <div class="mt-4">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Competency Performance</h4>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                      <div v-for="(competency, key) in appraisal.scores_breakdown" :key="key" class="text-center">
                        <div class="text-xs font-medium text-gray-500 mb-1 truncate">
                          {{ competency.name || formatCompetencyName(key) }}
                        </div>
                        <div class="text-lg font-semibold" :class="scoreColor(competency.score)">
                          {{ competency.score }}%
                        </div>
                        <div class="text-xs text-gray-500 mt-1">
                          Avg: {{ calculateIndicatorAverage(competency.indicators).toFixed(1) }}/4
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Quick Summary -->
                  <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                      <h4 class="text-sm font-medium text-gray-900 mb-2">Strengths</h4>
                      <div class="text-sm text-gray-600">
                        <template v-if="Array.isArray(parseStringToList(appraisal.strengths))">
                          <div v-for="(strength, index) in parseStringToList(appraisal.strengths).slice(0, 2)" :key="index" class="flex items-start mb-1">
                            <svg class="h-4 w-4 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>{{ strength }}</span>
                          </div>
                        </template>
                        <template v-else>
                          <div class="line-clamp-2">{{ appraisal.strengths }}</div>
                        </template>
                      </div>
                    </div>
                    <div>
                      <h4 class="text-sm font-medium text-gray-900 mb-2">Improvement Areas</h4>
                      <div class="text-sm text-gray-600">
                        <template v-if="Array.isArray(parseStringToList(appraisal.improvement_areas))">
                          <div v-for="(area, index) in parseStringToList(appraisal.improvement_areas).slice(0, 2)" :key="index" class="flex items-start mb-1">
                            <svg class="h-4 w-4 text-amber-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <span>{{ area }}</span>
                          </div>
                        </template>
                        <template v-else>
                          <div class="line-clamp-2">{{ appraisal.improvement_areas }}</div>
                        </template>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="ml-4 flex-shrink-0 flex flex-col space-y-2">
                  <Link
                    :href="route('admin.appraisals.show', appraisal.id)"
                    class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                  >
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    View Details
                  </Link>
                  <a
                    v-if="appraisal.appraisal_report_path"
                    :href="appraisal.report_url"
                    target="_blank"
                    class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                  >
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Download PDF
                  </a>
                  <button
                    v-else
                    @click="generateReport(appraisal)"
                    class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                  >
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Generate PDF
                  </button>
                </div>
              </div>
            </li>
          </ul>

          <!-- Pagination -->
          <div v-if="appraisals.links.length > 3" class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            <div class="flex-1 flex justify-between sm:hidden">
              <Link
                :href="appraisals.prev_page_url"
                :class="{'opacity-50 cursor-not-allowed': !appraisals.prev_page_url}"
                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
              >
                Previous
              </Link>
              <Link
                :href="appraisals.next_page_url"
                :class="{'opacity-50 cursor-not-allowed': !appraisals.next_page_url}"
                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
              >
                Next
              </Link>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
              <div>
                <p class="text-sm text-gray-700">
                  Showing
                  <span class="font-medium">{{ appraisals.from }}</span>
                  to
                  <span class="font-medium">{{ appraisals.to }}</span>
                  of
                  <span class="font-medium">{{ appraisals.total }}</span>
                  appraisals
                </p>
              </div>
              <div>
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                  <Link
                    v-for="(link, index) in appraisals.links"
                    :key="index"
                    :href="link.url"
                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                    :class="{
                      'bg-blue-50 border-blue-500 text-blue-600 z-10': link.active,
                      'rounded-l-md': index === 0,
                      'rounded-r-md': index === appraisals.links.length - 1
                    }"
                    v-html="link.label"
                  ></Link>
                </nav>
              </div>
            </div>
          </div>

          <!-- Empty State -->
          <div v-if="appraisals.data.length === 0" class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No appraisals found</h3>
            <p class="mt-1 text-sm text-gray-500">
              {{ filters.search || filters.date_from || filters.date_to ? 'No appraisals match your current filters.' : 'There are no appraisals in the system yet.' }}
            </p>
            <div v-if="filters.search || filters.date_from || filters.date_to" class="mt-4">
              <button
                @click="resetFilters"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
              >
                Clear Filters
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</AppLayout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import { debounce } from 'lodash'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  appraisals: Object,
  stats: Object,
  filters: Object
})

const filters = ref({
  search: props.filters.search || '',
  date_from: props.filters.date_from || '',
  date_to: props.filters.date_to || ''
})

// Apply filters manually
const applyFilters = () => {
  router.get(route('admin.appraisals'), filters.value, {
    preserveState: true,
    replace: true
  })
}

// Reset filters
const resetFilters = () => {
  filters.value = {
    search: '',
    date_from: '',
    date_to: ''
  }
  router.get(route('admin.appraisals'), {}, {
    preserveState: true,
    replace: true
  })
}

const scoreColor = (score) => {
  if (score >= 90) return 'text-green-600'
  if (score >= 80) return 'text-blue-600'
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

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

const formatCompetencyName = (key) => {
  const names = {
    'competency_1': 'Innovative Teaching',
    'competency_2': 'Assessment & Reporting',
    'competency_3': 'Self Development',
    'competency_4': 'Colleague Development',
    'competency_5': 'School Leadership'
  }
  return names[key] || key.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())
}

const calculateIndicatorAverage = (indicators) => {
  if (!indicators || typeof indicators !== 'object') return 0
  const values = Object.values(indicators)
  if (values.length === 0) return 0
  const sum = values.reduce((total, score) => total + parseFloat(score), 0)
  return sum / values.length
}

const parseStringToList = (text) => {
  if (!text) return []

  // Handle both array and string formats
  if (Array.isArray(text)) return text

  // Try to parse string into array
  const strText = text.toString()
  const separators = ['. ', '; ', '| ', '• ', '- ']
  for (const sep of separators) {
    if (strText.includes(sep)) {
      return strText.split(sep).map(item => item.trim()).filter(item => item)
    }
  }

  // If no separators found, wrap as single item array
  return [strText]
}

const generateReport = (appraisal) => {
  // Call API to generate PDF report
  fetch(route('admin.appraisals.generate-report', appraisal.id), {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      'Content-Type': 'application/json'
    }
  })
  .then(response => response.json())
  .then(data => {
    if (data.success && data.report_url) {
      window.open(data.report_url, '_blank')
    } else {
      alert('Failed to generate report: ' + (data.message || 'Unknown error'))
    }
  })
  .catch(error => {
    console.error('Report generation error:', error)
    alert('Failed to generate report. Please try again.')
  })
}
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.truncate {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
</style>
