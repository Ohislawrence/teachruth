<template>
    <AppLayout>
  <div class="min-h-screen bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <h1 class="text-xl font-semibold text-gray-900">Admin Dashboard</h1>
          </div>
          <div class="flex items-center space-x-4">
            <Link :href="route('admin.teachers')" class="text-gray-600 hover:text-gray-900">
              Teachers
            </Link>
            <Link :href="route('admin.schools')" class="text-gray-600 hover:text-gray-900">
              Schools
            </Link>
            <Link :href="route('admin.jobs')" class="text-gray-600 hover:text-gray-900">
              Jobs
            </Link>
            <Link :href="route('admin.appraisals')" class="text-gray-600 hover:text-gray-900">
              Appraisals
            </Link>
            <Link :href="route('admin.payments')" class="text-gray-600 hover:text-gray-900">
              Payments
            </Link>
          </div>
        </div>
      </div>
    </nav>

    <div class="py-6">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
          <!-- Total Teachers -->
          <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                  </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">Total Teachers</dt>
                    <dd class="text-lg font-medium text-gray-900">{{ stats.total_teachers }}</dd>
                  </dl>
                </div>
              </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
              <div class="text-sm">
                <Link :href="route('admin.teachers')" class="font-medium text-blue-600 hover:text-blue-500">
                  View all
                </Link>
              </div>
            </div>
          </div>

          <!-- Total Schools -->
          <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                  </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">Total Schools</dt>
                    <dd class="text-lg font-medium text-gray-900">{{ stats.total_schools }}</dd>
                  </dl>
                </div>
              </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
              <div class="text-sm">
                <span class="text-yellow-600 font-medium">{{ stats.pending_approvals }} pending approval</span>
                <Link :href="route('admin.schools')" class="ml-2 font-medium text-blue-600 hover:text-blue-500">
                  Manage
                </Link>
              </div>
            </div>
          </div>

          <!-- Total Jobs -->
          <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                  </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">Total Jobs</dt>
                    <dd class="text-lg font-medium text-gray-900">{{ stats.total_jobs }}</dd>
                  </dl>
                </div>
              </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
              <div class="text-sm">
                <span class="text-gray-600">{{ stats.total_applications }} applications</span>
                <Link :href="route('admin.jobs')" class="ml-2 font-medium text-blue-600 hover:text-blue-500">
                  View jobs
                </Link>
              </div>
            </div>
          </div>

          <!-- Total Revenue -->
          <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                  </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">Total Revenue</dt>
                    <dd class="text-lg font-medium text-gray-900">₦{{ stats.total_revenue.toLocaleString() }}</dd>
                  </dl>
                </div>
              </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
              <div class="text-sm">
                <Link :href="route('admin.payments')" class="font-medium text-blue-600 hover:text-blue-500">
                  View payments
                </Link>
              </div>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
          <!-- Teacher Registrations Chart -->
          <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Teacher Registrations ({{ new Date().getFullYear() }})</h3>
            <div class="h-64">
              <BarChart :chart-data="teacherChartData" :options="chartOptions" />
            </div>
          </div>

          <!-- Quick Stats -->
          <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Stats</h3>
            <div class="grid grid-cols-2 gap-4">
              <div class="bg-blue-50 rounded-lg p-4">
                <div class="text-2xl font-bold text-blue-600">{{ stats.total_appraisals }}</div>
                <div class="text-sm text-blue-800">Total Appraisals</div>
              </div>
              <div class="bg-green-50 rounded-lg p-4">
                <div class="text-2xl font-bold text-green-600">{{ stats.total_applications }}</div>
                <div class="text-sm text-green-800">Job Applications</div>
              </div>
              <div class="bg-yellow-50 rounded-lg p-4">
                <div class="text-2xl font-bold text-yellow-600">{{ stats.pending_approvals }}</div>
                <div class="text-sm text-yellow-800">Pending Approvals</div>
              </div>
              <div class="bg-purple-50 rounded-lg p-4">
                <div class="text-2xl font-bold text-purple-600">₦{{ (stats.total_revenue / 1000).toFixed(0) }}K</div>
                <div class="text-sm text-purple-800">Revenue</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Recent Activities -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <!-- Recent Teachers -->
          <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
              <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Teachers</h3>
              <p class="mt-1 max-w-2xl text-sm text-gray-500">Newly registered teachers</p>
            </div>
            <ul class="divide-y divide-gray-200">
              <li v-for="teacher in recentActivities.new_teachers" :key="teacher.id" class="px-4 py-4 sm:px-6">
                <div class="flex items-center justify-between">
                  <div class="flex items-center">
                    <div class="flex-shrink-0">
                      <img class="h-10 w-10 rounded-full" :src="teacher.profile_photo_url" :alt="teacher.name" />
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">{{ teacher.name }}</div>
                      <div class="text-sm text-gray-500">{{ teacher.email }}</div>
                      <div v-if="teacher.teacher_profile" class="text-xs text-gray-400">
                        {{ teacher.teacher_profile.qualification }}
                      </div>
                    </div>
                  </div>
                  <div class="text-sm text-gray-500">
                    {{ formatDate(teacher.created_at) }}
                  </div>
                </div>
              </li>
            </ul>
            <div class="bg-gray-50 px-4 py-4 sm:px-6">
              <Link
                :href="route('admin.teachers')"
                class="text-sm font-medium text-blue-600 hover:text-blue-500"
              >
                View all teachers →
              </Link>
            </div>
          </div>

          <!-- Recent Schools -->
          <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
              <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Schools</h3>
              <p class="mt-1 max-w-2xl text-sm text-gray-500">Newly registered schools</p>
            </div>
            <ul class="divide-y divide-gray-200">
              <li v-for="school in recentActivities.new_schools" :key="school.id" class="px-4 py-4 sm:px-6">
                <div class="flex items-center justify-between">
                  <div class="flex items-center">
                    <div class="flex-shrink-0">
                      <img class="h-10 w-10 rounded-full" :src="school.profile_photo_url" :alt="school.name" />
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">
                        {{ school.school_profile?.school_name || school.name }}
                      </div>
                      <div class="text-sm text-gray-500">{{ school.email }}</div>
                      <div class="text-xs text-gray-400 capitalize">
                        {{ school.school_profile?.state }}, {{ school.school_profile?.lga }}
                        <span v-if="!school.school_profile?.is_verified" class="ml-2 text-yellow-600">
                          • Pending
                        </span>
                        <span v-else class="ml-2 text-green-600">
                          • Verified
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="text-sm text-gray-500">
                    {{ formatDate(school.created_at) }}
                  </div>
                </div>
              </li>
            </ul>
            <div class="bg-gray-50 px-4 py-4 sm:px-6">
              <Link
                :href="route('admin.schools')"
                class="text-sm font-medium text-blue-600 hover:text-blue-500"
              >
                View all schools →
              </Link>
            </div>
          </div>
        </div>

        <!-- Additional Sections -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
          <!-- Recent Jobs -->
          <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
              <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Job Postings</h3>
              <p class="mt-1 max-w-2xl text-sm text-gray-500">Latest job opportunities</p>
            </div>
            <ul class="divide-y divide-gray-200">
              <li v-for="job in recentActivities.recent_jobs" :key="job.id" class="px-4 py-4 sm:px-6">
                <div class="flex items-center justify-between">
                  <div>
                    <div class="text-sm font-medium text-gray-900">{{ job.title }}</div>
                    <div class="text-sm text-gray-500">
                      {{ job.school.school_profile.school_name }}
                    </div>
                    <div class="text-xs text-gray-400 capitalize">
                      {{ job.subject.replace('_', ' ') }} • {{ job.level.replace('_', ' ') }}
                    </div>
                  </div>
                  <div class="text-right">
                    <div class="text-sm text-gray-500">
                      {{ formatDate(job.created_at) }}
                    </div>
                    <div class="text-xs text-gray-400">
                      {{ job.applications_count || 0 }} applications
                    </div>
                  </div>
                </div>
              </li>
            </ul>
            <div class="bg-gray-50 px-4 py-4 sm:px-6">
              <Link
                :href="route('admin.jobs')"
                class="text-sm font-medium text-blue-600 hover:text-blue-500"
              >
                View all jobs →
              </Link>
            </div>
          </div>

          <!-- Recent Payments -->
          <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
              <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Payments</h3>
              <p class="mt-1 max-w-2xl text-sm text-gray-500">Latest successful transactions</p>
            </div>
            <ul class="divide-y divide-gray-200">
              <li v-for="payment in recentActivities.recent_payments" :key="payment.id" class="px-4 py-4 sm:px-6">
                <div class="flex items-center justify-between">
                  <div>
                    <div class="text-sm font-medium text-gray-900">
                      {{ payment.user?.name }}
                    </div>
                    <div class="text-sm text-gray-500">
                      {{ payment.payment_reference }}
                    </div>
                    <div class="text-xs text-gray-400">
                      {{ payment.user?.email }}
                    </div>
                  </div>
                  <div class="text-right">
                    <div class="text-sm font-medium text-green-600">
                      ₦{{ payment.amount.toLocaleString() }}
                    </div>
                    <div class="text-xs text-gray-500">
                      {{ formatDate(payment.created_at) }}
                    </div>
                  </div>
                </div>
              </li>
            </ul>
            <div class="bg-gray-50 px-4 py-4 sm:px-6">
              <Link
                :href="route('admin.payments')"
                class="text-sm font-medium text-blue-600 hover:text-blue-500"
              >
                View all payments →
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </AppLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { ref, onMounted } from 'vue'
import { BarChart } from 'vue-chart-3'
import { Chart, registerables } from 'chart.js'
import AppLayout from '@/Layouts/AppLayout.vue'

Chart.register(...registerables)

const props = defineProps({
  stats: Object,
  recentActivities: Object,
  teacherChartData: Array
})

const chartOptions = ref({
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      display: false
    }
  },
  scales: {
    y: {
      beginAtZero: true,
      ticks: {
        stepSize: 1
      }
    }
  }
})

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    month: 'short',
    day: 'numeric'
  })
}
</script>
