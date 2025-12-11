<template>
    <AppLayout>
  <div class="min-h-screen bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <h1 class="text-xl font-semibold text-gray-900">Appraisal Reports</h1>
          </div>
          <div class="flex items-center space-x-4">
            <Link :href="route('admin.dashboard')" class="text-gray-600 hover:text-gray-900">
              Dashboard
            </Link>
            <Link :href="route('admin.appraisals')" class="text-gray-600 hover:text-gray-900">
              All Appraisals
            </Link>
          </div>
        </div>
      </div>
    </nav>

    <div class="py-6">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Report Filters -->
        <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Generate Appraisal Report</h3>
          <form @submit.prevent="generateReport">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
              <div>
                <label for="date_from" class="block text-sm font-medium text-gray-700">From Date</label>
                <input
                  type="date"
                  id="date_from"
                  v-model="form.date_from"
                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                />
              </div>
              <div>
                <label for="date_to" class="block text-sm font-medium text-gray-700">To Date</label>
                <input
                  type="date"
                  id="date_to"
                  v-model="form.date_to"
                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                />
              </div>
              <div class="flex items-end">
                <button
                  type="submit"
                  :disabled="processing"
                  class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
                >
                  {{ processing ? 'Generating...' : 'Generate Report' }}
                </button>
              </div>
            </div>
          </form>
        </div>

        <!-- Report Content -->
        <div v-if="reportData" class="space-y-6">
          <!-- Summary Stats -->
          <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="bg-white overflow-hidden shadow rounded-lg">
              <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">Total Appraisals</dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ reportData.total_appraisals }}</dd>
              </div>
            </div>
            <div class="bg-white overflow-hidden shadow rounded-lg">
              <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">Average Score</dt>
                <dd class="mt-1 text-3xl font-semibold text-blue-600">{{ reportData.average_score }}%</dd>
              </div>
            </div>
            <div class="bg-white overflow-hidden shadow rounded-lg">
              <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">Report Period</dt>
                <dd class="mt-1 text-lg font-semibold text-gray-900">
                  {{ filters.date_from ? formatDate(filters.date_from) : 'All time' }} -
                  {{ filters.date_to ? formatDate(filters.date_to) : 'Present' }}
                </dd>
              </div>
            </div>
          </div>

          <!-- Score Distribution -->
          <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Score Distribution</h3>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
              <div v-for="(count, range) in reportData.score_distribution" :key="range"
                   class="text-center bg-gray-50 rounded-lg p-4">
                <div class="text-2xl font-bold text-blue-600">{{ count }}</div>
                <div class="text-sm text-gray-600">{{ range }}</div>
              </div>
            </div>
          </div>

          <!-- Top Teachers -->
          <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
              <h3 class="text-lg leading-6 font-medium text-gray-900">Top Performing Teachers</h3>
              <p class="mt-1 max-w-2xl text-sm text-gray-500">Teachers with the highest appraisal scores</p>
            </div>
            <ul class="divide-y divide-gray-200">
              <li v-for="(teacher, index) in reportData.top_teachers" :key="index" class="px-4 py-4 sm:px-6">
                <div class="flex items-center justify-between">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 w-8 text-center">
                      <span class="text-lg font-bold text-gray-400">#{{ index + 1 }}</span>
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">{{ teacher.teacher_name }}</div>
                      <div class="text-sm text-gray-500">{{ teacher.date }}</div>
                    </div>
                  </div>
                  <div class="text-right">
                    <div class="text-2xl font-bold" :class="scoreColor(teacher.score)">
                      {{ teacher.score }}%
                    </div>
                    <div class="text-sm font-medium" :class="gradeColor(teacher.grade)">
                      {{ teacher.grade }}
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </div>

          <!-- Export Options -->
          <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Export Report</h3>
            <div class="flex space-x-4">
              <button
                @click="exportPDF"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
              >
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export as PDF
              </button>
              <button
                @click="exportCSV"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
              >
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export as CSV
              </button>
            </div>
          </div>
        </div>

        <!-- Empty State -->
        <div v-else class="bg-white shadow rounded-lg p-12 text-center">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900">No report generated</h3>
          <p class="mt-1 text-sm text-gray-500">
            Use the filters above to generate an appraisal report for your selected period.
          </p>
        </div>
      </div>
    </div>
  </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, router, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
  reportData: Object,
  filters: Object
})

const processing = ref(false)

const form = useForm({
  date_from: props.filters.date_from || '',
  date_to: props.filters.date_to || ''
})

const generateReport = () => {
  processing.value = true
  form.get(route('admin.appraisals.report'), {
    preserveState: true,
    onFinish: () => {
      processing.value = false
    }
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
    day: 'numeric'
  })
}

const exportPDF = () => {
  // Implement PDF export logic
  alert('PDF export functionality would be implemented here')
}

const exportCSV = () => {
  // Implement CSV export logic
  alert('CSV export functionality would be implemented here')
}
</script>
