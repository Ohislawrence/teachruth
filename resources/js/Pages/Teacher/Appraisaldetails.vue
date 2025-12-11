<template>
  <AppLayout title="Appraisal Details">
    <div class="min-h-screen bg-gray-100">
      <!-- Navigation -->
      <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between h-16">
            <div class="flex items-center">
              <Link :href="route('teacher.appraisals')" class="text-gray-600 hover:text-gray-900 mr-4 flex items-center">
                <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Appraisals
              </Link>
              <h1 class="text-xl font-semibold text-gray-900">Appraisal Details</h1>
            </div>
            <div class="flex items-center space-x-4">
              <Link :href="route('teacher.dashboard')" class="text-gray-600 hover:text-gray-900">
                Dashboard
              </Link>
              <Link :href="route('teacher.appraisals')" class="text-gray-600 hover:text-gray-900">
                All Appraisals
              </Link>
            </div>
          </div>
        </div>
      </nav>

      <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <!-- Header -->
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
              <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div>
                  <h1 class="text-2xl font-bold text-gray-900">{{ page.props.auth.user.name.replace(/\b\w/g, c => c.toUpperCase()) }} Appraisal Report</h1>
                  <p class="mt-1 text-lg text-gray-600">Level-3 Competency Assessment Analysis</p>
                  <p class="text-sm text-gray-500">Generated on {{ formatDate(appraisal.created_at) }}</p>
                </div>
                <div class="text-center lg:text-right">
                  <div class="text-4xl font-bold" :class="scoreColor(appraisal.overall_score)">
                    {{ appraisal.overall_score }}%
                  </div>
                  <div class="text-lg font-semibold" :class="gradeColor(appraisal.grade)">
                    Grade: {{ appraisal.grade }}
                  </div>
                  <div v-if="appraisal.is_latest" class="mt-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Latest Appraisal
                  </div>
                </div>
              </div>
            </div>

            <div class="px-4 py-5 sm:p-6">
              <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">
                  <!-- Overall Performance -->
                  <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4 pb-3 border-b border-gray-200">
                      Overall Performance Summary
                    </h2>
                    <div class="prose max-w-none text-gray-700 leading-relaxed">
                      <p class="text-lg mb-4">{{ appraisal.detailed_feedback }}</p>

                      <!-- Summary Stats -->
                      <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6 p-4 bg-blue-50 rounded-lg">
                        <div class="text-center">
                          <div class="text-2xl font-bold text-blue-700">{{ appraisal.overall_score }}%</div>
                          <div class="text-sm text-blue-600">Overall Score</div>
                        </div>
                        <div class="text-center">
                          <div class="text-2xl font-bold" :class="gradeColor(appraisal.grade)">{{ appraisal.grade }}</div>
                          <div class="text-sm text-gray-600">Grade</div>
                        </div>
                        <div class="text-center">
                          <div class="text-2xl font-bold text-gray-700">{{ totalCompetencies }}</div>
                          <div class="text-sm text-gray-600">Competencies</div>
                        </div>
                        <div class="text-center">
                          <div class="text-2xl font-bold text-gray-700">{{ totalIndicators }}</div>
                          <div class="text-sm text-gray-600">Indicators</div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Detailed Competency Breakdown -->
                  <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6 pb-3 border-b border-gray-200">
                      Competency Performance Analysis
                    </h2>

                    <div class="space-y-6">
                      <div v-for="(competency, key) in appraisal.scores_breakdown" :key="key"
                           class="border-l-4 border-blue-500 bg-blue-50 p-5 rounded-r-lg hover:bg-blue-100 transition-colors">
                        <div class="flex flex-col md:flex-row md:items-center justify-between mb-4">
                          <div class="mb-3 md:mb-0">
                            <h3 class="text-lg font-medium text-gray-900">{{ competency.name }}</h3>
                            <p class="text-sm text-gray-600 mt-1">Level-3 Teaching Competency</p>
                          </div>
                          <div class="text-right">
                            <div class="text-2xl font-bold" :class="scoreColor(competency.score)">
                              {{ competency.score }}%
                            </div>
                            <div class="text-sm text-gray-600">
                              Avg: {{ calculateIndicatorAverage(competency.indicators).toFixed(1) }}/4
                            </div>
                          </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="mb-4">
                          <div class="flex justify-between text-sm text-gray-600 mb-1">
                            <span>Progress</span>
                            <span>{{ competency.score }}%</span>
                          </div>
                          <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="h-3 rounded-full" :class="scoreBarColor(competency.score)"
                                 :style="{ width: Math.min(competency.score, 100) + '%' }"></div>
                          </div>
                        </div>

                        <!-- Indicator Scores -->
                        <div class="mt-4">
                          <h4 class="text-sm font-medium text-gray-900 mb-3">Indicator Performance (1-4 scale)</h4>
                          <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                            <div v-for="(indicatorScore, indicatorName) in competency.indicators" :key="indicatorName"
                                 class="bg-white p-3 rounded-lg border border-gray-200 text-center hover:shadow-sm transition-shadow">
                              <div class="text-xs text-gray-600 mb-1 leading-tight">
                                {{ formatIndicatorName(indicatorName) }}
                              </div>
                              <div class="text-xl font-bold" :class="indicatorScoreColor(indicatorScore)">
                                {{ indicatorScore }}
                              </div>
                              <div class="text-xs text-gray-500 mt-1">
                                {{ getIndicatorRatingText(indicatorScore) }}
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Strengths & Improvement Areas -->
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Strengths -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                      <div class="flex items-center mb-4 pb-3 border-b border-gray-200">
                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
                          <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                          </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900">Key Strengths</h2>
                      </div>
                      <div class="space-y-3">
                        <div v-if="Array.isArray(parsedStrengths)" v-for="(strength, index) in parsedStrengths" :key="index"
                             class="flex items-start p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                          <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                          </svg>
                          <span class="text-green-800">{{ strength }}</span>
                        </div>
                        <template v-else>
                          <div class="text-gray-700 leading-relaxed whitespace-pre-line">
                            {{ appraisal.strengths }}
                          </div>
                        </template>
                      </div>
                    </div>

                    <!-- Improvement Areas -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                      <div class="flex items-center mb-4 pb-3 border-b border-gray-200">
                        <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center mr-3">
                          <svg class="h-6 w-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                          </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900">Areas for Improvement</h2>
                      </div>
                      <div class="space-y-3">
                        <div v-if="Array.isArray(parsedImprovementAreas)" v-for="(area, index) in parsedImprovementAreas" :key="index"
                             class="flex items-start p-3 bg-amber-50 rounded-lg hover:bg-amber-100 transition-colors">
                          <svg class="h-5 w-5 text-amber-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                          </svg>
                          <span class="text-amber-800">{{ area }}</span>
                        </div>
                        <template v-else>
                          <div class="text-gray-700 leading-relaxed whitespace-pre-line">
                            {{ appraisal.improvement_areas }}
                          </div>
                        </template>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                  <!-- Action Cards -->
                  <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-3 border-b border-gray-200">Actions</h3>
                    <div class="space-y-3">
                      <button
                        @click="downloadPDF"
                        class="w-full flex justify-center items-center px-4 py-3 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
                      >
                        <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Download PDF Report
                      </button>
                      <Link
                        :href="route('teacher.reappraise')"
                        class="w-full flex justify-center items-center px-4 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
                      >
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Request New Appraisal
                      </Link>
                    </div>
                  </div>

                  <!-- Performance Insights -->
                  <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-blue-900 mb-4">Performance Insights</h3>
                    <div class="space-y-4">
                      <div v-for="(competency, key) in appraisal.scores_breakdown" :key="key">
                        <div class="flex justify-between items-center mb-1">
                          <span class="text-sm font-medium text-blue-800">{{ competency.name }}</span>
                          <span class="text-sm font-bold" :class="scoreColor(competency.score)">
                            {{ competency.score }}%
                          </span>
                        </div>
                        <div class="w-full bg-blue-200 rounded-full h-2">
                          <div class="h-2 rounded-full" :class="scoreBarColor(competency.score)"
                               :style="{ width: Math.min(competency.score, 100) + '%' }"></div>
                        </div>
                        <div class="text-xs text-blue-600 mt-1">
                          Avg indicator: {{ calculateIndicatorAverage(competency.indicators).toFixed(1) }}/4
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Competency Ranking -->
                  <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-green-900 mb-4">Top Performing Competencies</h3>
                    <div class="space-y-3">
                      <div v-for="(competency, index) in topCompetencies" :key="competency.key"
                           class="flex items-center p-3 bg-white rounded-lg border border-green-100">
                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3">
                          <span class="text-sm font-bold text-green-700">{{ index + 1 }}</span>
                        </div>
                        <div class="flex-1">
                          <div class="font-medium text-green-900">{{ competency.name }}</div>
                          <div class="text-sm text-green-700">{{ competency.score }}%</div>
                        </div>
                        <div class="text-lg font-bold" :class="scoreColor(competency.score)">
                          {{ getPerformanceLevel(competency.score) }}
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Recommendations -->
                  <div class="bg-gradient-to-r from-purple-50 to-violet-50 border border-purple-200 rounded-lg p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-purple-900 mb-4">Development Recommendations</h3>
                    <ul class="text-sm text-purple-800 space-y-3">
                      <li class="flex items-start">
                        <svg class="h-5 w-5 text-purple-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Focus professional development on your lowest scoring competencies</span>
                      </li>
                      <li class="flex items-start">
                        <svg class="h-5 w-5 text-purple-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Set SMART goals for indicator scores below 3</span>
                      </li>
                      <li class="flex items-start">
                        <svg class="h-5 w-5 text-purple-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Document progress and seek peer feedback regularly</span>
                      </li>
                      <li class="flex items-start">
                        <svg class="h-5 w-5 text-purple-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Schedule quarterly self-assessments to track improvement</span>
                      </li>
                    </ul>
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
import { Link,usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
  appraisal: Object
})

const page = usePage();
const parsedStrengths = computed(() => {
  if (!props.appraisal.strengths) return []
  if (Array.isArray(props.appraisal.strengths)) return props.appraisal.strengths

  // Try to parse string into array
  const text = props.appraisal.strengths.toString()
  const separators = ['. ', '; ', '| ', '• ', '- ']
  for (const sep of separators) {
    if (text.includes(sep)) {
      return text.split(sep).map(item => item.trim()).filter(item => item)
    }
  }

  // If no separators found, wrap as single item array
  return [text]
})

const parsedImprovementAreas = computed(() => {
  if (!props.appraisal.improvement_areas) return []
  if (Array.isArray(props.appraisal.improvement_areas)) return props.appraisal.improvement_areas

  // Try to parse string into array
  const text = props.appraisal.improvement_areas.toString()
  const separators = ['. ', '; ', '| ', '• ', '- ']
  for (const sep of separators) {
    if (text.includes(sep)) {
      return text.split(sep).map(item => item.trim()).filter(item => item)
    }
  }

  // If no separators found, wrap as single item array
  return [text]
})

const totalCompetencies = computed(() => {
  if (!props.appraisal.scores_breakdown) return 0
  return Object.keys(props.appraisal.scores_breakdown).length
})

const totalIndicators = computed(() => {
  if (!props.appraisal.scores_breakdown) return 0
  let count = 0
  Object.values(props.appraisal.scores_breakdown).forEach(competency => {
    if (competency.indicators) {
      count += Object.keys(competency.indicators).length
    }
  })
  return count
})

const topCompetencies = computed(() => {
  if (!props.appraisal.scores_breakdown) return []

  return Object.entries(props.appraisal.scores_breakdown)
    .map(([key, competency]) => ({
      key,
      name: competency.name || formatCompetencyName(key),
      score: competency.score
    }))
    .sort((a, b) => b.score - a.score)
    .slice(0, 3)
})

const scoreColor = (score) => {
  if (score >= 90) return 'text-green-600'
  if (score >= 80) return 'text-blue-600'
  if (score >= 70) return 'text-yellow-600'
  if (score >= 60) return 'text-orange-600'
  return 'text-red-600'
}

const scoreBarColor = (score) => {
  if (score >= 90) return 'bg-green-500'
  if (score >= 80) return 'bg-blue-500'
  if (score >= 70) return 'bg-yellow-500'
  if (score >= 60) return 'bg-orange-500'
  return 'bg-red-500'
}

const indicatorScoreColor = (score) => {
  const numScore = parseFloat(score)
  if (numScore >= 3.5) return 'text-green-600'
  if (numScore >= 3) return 'text-blue-600'
  if (numScore >= 2.5) return 'text-yellow-600'
  if (numScore >= 2) return 'text-orange-600'
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
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

const formatIndicatorName = (name) => {
  // Convert snake_case to readable text
  return name.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())
}

const formatCompetencyName = (key) => {
  const names = {
    'competency_1': 'Innovative Teaching Strategies',
    'competency_2': 'Student Assessment & Reporting',
    'competency_3': 'Self Development & Reflection',
    'competency_4': 'Enhance Colleagues\' Development',
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

const getIndicatorRatingText = (score) => {
  const numScore = parseFloat(score)
  if (numScore >= 3.5) return 'Excellent'
  if (numScore >= 3) return 'Good'
  if (numScore >= 2.5) return 'Developing'
  if (numScore >= 2) return 'Basic'
  return 'Beginning'
}

const getPerformanceLevel = (score) => {
  if (score >= 90) return 'A+'
  if (score >= 80) return 'A'
  if (score >= 70) return 'B'
  if (score >= 60) return 'C'
  if (score >= 50) return 'D'
  return 'F'
}

const downloadPDF = () => {
  if (props.appraisal.appraisal_report_path) {
    window.open(props.appraisal.report_url, '_blank')
  } else {
    // Generate PDF on the fly or show message
    alert('PDF report is being generated. Please check back later.')
  }
}
</script>

<style scoped>
.prose {
  max-width: none;
}

.prose p {
  margin-bottom: 1em;
  line-height: 1.7;
}

.prose p:last-child {
  margin-bottom: 0;
}
</style>
