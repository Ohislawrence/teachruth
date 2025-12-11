<template>
  <AppLayout title="My Appraisals">
    <div class="min-h-screen bg-gradient-to-b from-emerald-50 via-teal-50 to-white">
      <!-- Navigation -->
      <nav class="bg-gradient-to-r from-emerald-600 to-teal-600 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between h-16">
            <div class="flex items-center">
              <div class="flex items-center space-x-3">
                <div class="p-2 bg-white/20 rounded-lg">
                  <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                  </svg>
                </div>
                <div>
                  <h1 class="text-xl font-bold text-white">My Appraisals</h1>
                  <p class="text-xs text-emerald-100">Track your teaching performance</p>
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
                :href="route('teacher.reappraise')"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-bold rounded-xl shadow-lg text-white bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 focus:outline-none focus:ring-2 focus:ring-emerald-300 transition"
              >
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                New Appraisal
              </Link>
            </div>
          </div>
        </div>
      </nav>

      <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <!-- Stats Cards -->
          <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
            <!-- Total Appraisals -->
            <div class="bg-gradient-to-br from-white to-emerald-50 shadow-xl rounded-2xl border border-emerald-100 transform transition-transform hover:-translate-y-1">
              <div class="p-6">
                <div class="flex items-center">
                  <div class="p-3 rounded-xl bg-emerald-100 mr-4">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                  </div>
                  <div>
                    <dt class="text-sm font-medium text-emerald-600">Total Appraisals</dt>
                    <dd class="mt-1 text-3xl font-bold text-gray-900">{{ appraisals.total }}</dd>
                  </div>
                </div>
              </div>
            </div>

            <!-- Average Score -->
            <div class="bg-gradient-to-br from-white to-emerald-50 shadow-xl rounded-2xl border border-emerald-100 transform transition-transform hover:-translate-y-1">
              <div class="p-6">
                <div class="flex items-center">
                  <div class="p-3 rounded-xl bg-emerald-100 mr-4">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.933 12.8a1 1 0 000-1.6L6.6 7.2A1 1 0 005 8v8a1 1 0 001.6.8l5.333-4zM19.933 12.8a1 1 0 000-1.6l-5.333-4A1 1 0 0013 8v8a1 1 0 001.6.8l5.333-4z" />
                    </svg>
                  </div>
                  <div>
                    <dt class="text-sm font-medium text-emerald-600">Average Score</dt>
                    <dd class="mt-1 text-3xl font-bold" :class="scoreColor(averageScore)">
                      {{ averageScore }}%
                    </dd>
                  </div>
                </div>
              </div>
            </div>

            <!-- Latest Score -->
            <div class="bg-gradient-to-br from-white to-emerald-50 shadow-xl rounded-2xl border border-emerald-100 transform transition-transform hover:-translate-y-1">
              <div class="p-6">
                <div class="flex items-center">
                  <div class="p-3 rounded-xl bg-emerald-100 mr-4">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                  </div>
                  <div>
                    <dt class="text-sm font-medium text-emerald-600">Latest Score</dt>
                    <dd class="mt-1 text-3xl font-bold" :class="latestScoreColor">
                      {{ latestScore }}%
                    </dd>
                    <p v-if="appraisals.data.length > 0" class="text-xs text-emerald-500 mt-1">
                      {{ formatDate(appraisals.data[0].created_at) }}
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Progress Trend -->
            <div class="bg-gradient-to-br from-white to-emerald-50 shadow-xl rounded-2xl border border-emerald-100 transform transition-transform hover:-translate-y-1">
              <div class="p-6">
                <div class="flex items-center">
                  <div class="p-3 rounded-xl bg-emerald-100 mr-4">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                  </div>
                  <div>
                    <dt class="text-sm font-medium text-emerald-600">Progress Trend</dt>
                    <dd class="mt-1 text-3xl font-bold" :class="progressTrendColor">
                      {{ progressTrend }}
                    </dd>
                    <p class="text-xs text-emerald-500 mt-1">
                      {{ progressTrend === 'N/A' ? 'Need more data' : 'vs. previous' }}
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Competency Overview -->
          <div class="mb-8">
            <div class="bg-white shadow-2xl rounded-2xl border border-emerald-100 overflow-hidden">
              <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-5 sm:px-8">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                  <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                  </svg>
                  Competency Overview (Latest Appraisal)
                </h3>
                <p class="mt-1 text-sm text-emerald-700">Performance across all 5 Level-3 competencies</p>
              </div>

              <div v-if="appraisals.data.length > 0" class="px-6 py-8 sm:px-8">
                <div class="space-y-6">
                  <div v-for="(competency, key) in latestCompetencyScores" :key="key"
                       class="border-l-4 rounded-r-xl p-5"
                       :class="competencyBorderColor(competency.score)">
                    <div class="flex justify-between items-start">
                      <div class="flex-1">
                        <div class="flex items-center justify-between mb-3">
                          <h4 class="text-lg font-bold text-gray-900">{{ competency.name }}</h4>
                          <span class="text-xl font-bold" :class="scoreColor(competency.score)">
                            {{ competency.score }}%
                          </span>
                        </div>

                        <!-- Progress Bar -->
                        <div class="mb-4">
                          <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-medium text-emerald-700">Performance Score</span>
                            <span class="text-sm font-medium text-gray-700">
                              {{ calculateIndicatorAverage(competency.indicators).toFixed(1) }}/4 avg
                            </span>
                          </div>
                          <div class="w-full bg-emerald-100 rounded-full h-3">
                            <div
                              class="h-3 rounded-full transition-all duration-500"
                              :class="scoreBarColor(competency.score)"
                              :style="{ width: Math.min(competency.score, 100) + '%' }"
                            ></div>
                          </div>
                        </div>

                        <!-- Indicator Scores -->
                        <div class="mt-4">
                          <h5 class="text-sm font-medium text-emerald-700 mb-2">Indicator Scores</h5>
                          <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                            <div v-for="(indicatorScore, indicatorName) in competency.indicators" :key="indicatorName"
                                 class="bg-white border border-emerald-100 rounded-lg p-3">
                              <div class="text-xs text-emerald-600 mb-1">
                                {{ formatIndicatorName(indicatorName) }}
                              </div>
                              <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                  <div class="w-2 h-2 rounded-full mr-2"
                                       :class="indicatorScore >= 3.5 ? 'bg-emerald-500' : indicatorScore >= 3 ? 'bg-amber-500' : 'bg-red-500'"></div>
                                  <span class="text-sm font-bold" :class="indicatorScoreColor(indicatorScore)">
                                    {{ indicatorScore }}/4
                                  </span>
                                </div>
                                <span class="text-xs" :class="indicatorScore >= 3 ? 'text-emerald-600' : 'text-amber-600'">
                                  {{ indicatorScore >= 3.5 ? 'Excellent' : indicatorScore >= 3 ? 'Good' : 'Needs Work' }}
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

              <div v-else class="px-6 py-12 text-center">
                <div class="mx-auto w-20 h-20 bg-gradient-to-r from-emerald-100 to-teal-100 rounded-full flex items-center justify-center mb-4">
                  <svg class="w-10 h-10 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                  </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">No Appraisal Data Yet</h3>
                <p class="text-emerald-600 max-w-md mx-auto mb-4">
                  Get your first AI-powered appraisal to see your competency scores.
                </p>
                <Link
                  :href="route('teacher.reappraise')"
                  class="inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-bold rounded-xl shadow text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-emerald-300 transition"
                >
                  Get Started
                </Link>
              </div>
            </div>
          </div>

          <!-- Appraisal History -->
          <div class="bg-white shadow-2xl rounded-2xl border border-emerald-100 overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-5 sm:px-8">
              <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                <div>
                  <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Appraisal History
                  </h3>
                  <p class="mt-1 text-sm text-emerald-700">
                    Your complete appraisal history and performance tracking
                  </p>
                </div>
                <div class="mt-3 sm:mt-0">
                  <span class="text-sm font-bold text-emerald-700">
                    {{ appraisals.total }} appraisal{{ appraisals.total !== 1 ? 's' : '' }}
                  </span>
                </div>
              </div>
            </div>

            <div class="divide-y divide-emerald-100">
              <div v-for="appraisal in appraisals.data" :key="appraisal.id"
                   class="px-6 py-8 sm:px-8 hover:bg-emerald-50/30 transition">
                <div class="flex flex-col lg:flex-row lg:items-start justify-between">
                  <!-- Appraisal Info -->
                  <div class="flex-1">
                    <div class="flex items-start space-x-4">
                      <!-- Date & Status -->
                      <div class="flex-shrink-0">
                        <div class="text-center">
                          <div class="w-16 h-16 rounded-xl bg-gradient-to-r from-emerald-100 to-teal-100 flex flex-col items-center justify-center">
                            <span class="text-lg font-bold text-emerald-700">{{ formatDay(appraisal.created_at) }}</span>
                            <span class="text-xs text-emerald-600">{{ formatMonth(appraisal.created_at) }}</span>
                          </div>
                          <div v-if="appraisal.is_latest" class="mt-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                              <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                              </svg>
                              Latest
                            </span>
                          </div>
                        </div>
                      </div>

                      <!-- Appraisal Details -->
                      <div class="flex-1 min-w-0">
                        <!-- Header with Score -->
                        <div class="flex flex-wrap items-center justify-between mb-4">
                          <div>
                            <h4 class="text-xl font-bold text-gray-900">
                              Teacher Appraisal
                            </h4>
                            <p class="text-sm text-emerald-600 mt-1">
                              Completed {{ formatFullDate(appraisal.created_at) }}
                            </p>
                          </div>
                          <div class="text-right">
                            <div class="text-3xl font-bold" :class="scoreColor(appraisal.overall_score)">
                              {{ appraisal.overall_score }}%
                            </div>
                            <div class="text-base font-bold px-3 py-1 rounded-lg inline-block mt-1"
                                 :class="gradeBackground(appraisal.grade)">
                              Grade: {{ appraisal.grade }}
                            </div>
                          </div>
                        </div>

                        <!-- Competency Scores -->
                        <div class="mb-6">
                          <h5 class="text-sm font-bold text-emerald-700 mb-3">Competency Scores</h5>
                          <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                            <div v-for="(competency, key) in appraisal.scores_breakdown" :key="key"
                                 class="text-center p-3 bg-emerald-50 rounded-lg">
                              <div class="text-xs font-medium text-emerald-600 mb-1 truncate">
                                {{ competency.name }}
                              </div>
                              <div class="text-lg font-bold" :class="scoreColor(competency.score)">
                                {{ competency.score }}%
                              </div>
                              <div class="text-xs text-emerald-500 mt-1">
                                Avg: {{ calculateIndicatorAverage(competency.indicators).toFixed(1) }}/4
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- Quick Summary -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                          <!-- Strengths -->
                          <div class="bg-gradient-to-r from-emerald-50 to-emerald-100/50 rounded-xl p-4 border border-emerald-100">
                            <h5 class="text-sm font-bold text-emerald-700 mb-2 flex items-center">
                              <svg class="w-4 h-4 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                              </svg>
                              Top Strengths
                            </h5>
                            <ul class="space-y-2">
                              <li v-for="(strength, index) in parseStringToList(appraisal.strengths).slice(0, 3)" :key="index"
                                  class="flex items-start text-sm">
                                <div class="w-2 h-2 bg-emerald-500 rounded-full mt-1.5 mr-2 flex-shrink-0"></div>
                                <span class="text-gray-700">{{ strength }}</span>
                              </li>
                            </ul>
                          </div>

                          <!-- Areas for Improvement -->
                          <div class="bg-gradient-to-r from-amber-50 to-amber-100/50 rounded-xl p-4 border border-amber-100">
                            <h5 class="text-sm font-bold text-amber-700 mb-2 flex items-center">
                              <svg class="w-4 h-4 mr-2 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z" />
                              </svg>
                              Areas for Improvement
                            </h5>
                            <ul class="space-y-2">
                              <li v-for="(area, index) in parseStringToList(appraisal.improvement_areas).slice(0, 3)" :key="index"
                                  class="flex items-start text-sm">
                                <div class="w-2 h-2 bg-amber-500 rounded-full mt-1.5 mr-2 flex-shrink-0"></div>
                                <span class="text-gray-700">{{ area }}</span>
                              </li>
                            </ul>
                          </div>
                        </div>

                        <!-- Key Insights -->
                        <div class="mt-4">
                          <h5 class="text-sm font-bold text-gray-900 mb-2">Key Insights</h5>
                          <p class="text-sm text-gray-600 line-clamp-2">
                            {{ truncateText(appraisal.detailed_feedback, 200) }}
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Action Buttons -->
                  <div class="mt-4 lg:mt-0 lg:ml-6">
                    <div class="flex flex-col space-y-3">
                      <Link
                        :href="route('teacher.appraisals.show', appraisal.id)"
                        class="inline-flex items-center justify-center px-5 py-2.5 border border-transparent text-sm font-bold rounded-xl shadow text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-emerald-300 transition"
                      >
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        View Details
                      </Link>

                      <button
                        v-if="appraisal.appraisal_report_path"
                        @click="downloadReport(appraisal)"
                        class="inline-flex items-center justify-center px-5 py-2.5 border-2 border-emerald-300 text-sm font-semibold rounded-xl text-emerald-700 bg-white hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-200 transition"
                      >
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Download PDF
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Empty State -->
              <div v-if="appraisals.data.length === 0" class="px-6 py-16 text-center">
                <div class="mx-auto w-24 h-24 bg-gradient-to-r from-emerald-100 to-teal-100 rounded-full flex items-center justify-center mb-6">
                  <svg class="w-12 h-12 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                  </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">No Appraisals Yet</h3>
                <p class="text-emerald-600 max-w-md mx-auto mb-6">
                  Get your first AI-powered appraisal to understand your teaching strengths and areas for improvement.
                </p>
                <div class="mt-6">
                  <Link
                    :href="route('teacher.reappraise')"
                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-bold rounded-xl shadow-lg text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-4 focus:ring-emerald-300 transition transform hover:-translate-y-0.5"
                  >
                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Get Your First Appraisal
                  </Link>
                </div>
              </div>
            </div>
          </div>

          <!-- Pagination -->
          <div v-if="appraisals.links.length > 3" class="mt-8 bg-white shadow-xl rounded-2xl border border-emerald-100 p-6">
            <div class="flex flex-col sm:flex-row items-center justify-between">
              <div class="mb-4 sm:mb-0">
                <p class="text-sm text-gray-700">
                  Showing
                  <span class="font-bold text-emerald-700">{{ appraisals.from }}</span>
                  to
                  <span class="font-bold text-emerald-700">{{ appraisals.to }}</span>
                  of
                  <span class="font-bold text-emerald-700">{{ appraisals.total }}</span>
                  appraisals
                </p>
              </div>
              <nav class="flex space-x-1">
                <Link
                  v-for="(link, index) in appraisals.links"
                  :key="index"
                  :href="link.url"
                  class="min-w-[40px] h-10 flex items-center justify-center border border-emerald-200 text-sm font-medium rounded-lg transition"
                  :class="{
                    'bg-gradient-to-r from-emerald-600 to-teal-600 text-white border-emerald-600 shadow-lg': link.active,
                    'text-emerald-700 hover:bg-emerald-50 hover:border-emerald-300': !link.active && link.url,
                    'text-gray-400 cursor-not-allowed': !link.url,
                    'rounded-l-lg': index === 0,
                    'rounded-r-lg': index === appraisals.links.length - 1
                  }"
                  v-html="link.label"
                ></Link>
              </nav>
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
  appraisals: Object
})

const averageScore = computed(() => {
  if (props.appraisals.data.length === 0) return 0
  const total = props.appraisals.data.reduce((sum, appraisal) => sum + parseFloat(appraisal.overall_score), 0)
  return Math.round(total / props.appraisals.data.length)
})

const latestScore = computed(() => {
  if (props.appraisals.data.length === 0) return 0
  return Math.round(parseFloat(props.appraisals.data[0].overall_score))
})

const latestCompetencyScores = computed(() => {
  if (props.appraisals.data.length === 0) return {}
  return props.appraisals.data[0].scores_breakdown || {}
})

const progressTrend = computed(() => {
  if (props.appraisals.data.length < 2) return 'N/A'

  const scores = props.appraisals.data.map(a => parseFloat(a.overall_score))
  const latest = scores[0]
  const previous = scores[1]
  const trend = latest - previous

  return trend >= 0 ? `+${trend.toFixed(1)}` : trend.toFixed(1)
})

const latestScoreColor = computed(() => {
  return scoreColor(latestScore.value)
})

const progressTrendColor = computed(() => {
  const trend = progressTrend.value
  if (trend === 'N/A') return 'text-gray-600'
  return trend.startsWith('+') ? 'text-emerald-600' : 'text-red-600'
})

const scoreColor = (score) => {
  if (score >= 90) return 'text-emerald-600'
  if (score >= 80) return 'text-emerald-500'
  if (score >= 70) return 'text-amber-500'
  if (score >= 60) return 'text-orange-500'
  return 'text-red-500'
}

const scoreBarColor = (score) => {
  if (score >= 90) return 'bg-gradient-to-r from-emerald-500 to-teal-500'
  if (score >= 80) return 'bg-emerald-400'
  if (score >= 70) return 'bg-amber-400'
  if (score >= 60) return 'bg-orange-400'
  return 'bg-red-400'
}

const competencyBorderColor = (score) => {
  if (score >= 90) return 'border-emerald-500 bg-emerald-50'
  if (score >= 80) return 'border-emerald-400 bg-emerald-50/50'
  if (score >= 70) return 'border-amber-400 bg-amber-50/50'
  if (score >= 60) return 'border-orange-400 bg-orange-50/50'
  return 'border-red-400 bg-red-50/50'
}

const indicatorScoreColor = (score) => {
  if (score >= 3.5) return 'text-emerald-600'
  if (score >= 3) return 'text-emerald-500'
  if (score >= 2.5) return 'text-amber-500'
  if (score >= 2) return 'text-orange-500'
  return 'text-red-500'
}

const gradeBackground = (grade) => {
  const backgrounds = {
    'A+': 'bg-gradient-to-r from-emerald-500 to-teal-500 text-white',
    'A': 'bg-gradient-to-r from-emerald-500 to-teal-500 text-white',
    'B': 'bg-gradient-to-r from-amber-500 to-orange-500 text-white',
    'C': 'bg-gradient-to-r from-orange-500 to-red-500 text-white',
    'D': 'bg-gradient-to-r from-red-500 to-red-600 text-white',
    'F': 'bg-gradient-to-r from-red-600 to-red-700 text-white'
  }
  return backgrounds[grade] || 'bg-gray-100 text-gray-800'
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}

const formatFullDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

const formatDay = (dateString) => {
  return new Date(dateString).getDate()
}

const formatMonth = (dateString) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    month: 'short'
  })
}

const formatIndicatorName = (name) => {
  // Convert snake_case to readable text
  return name.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())
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

  // Split by common separators
  const separators = ['. ', '; ', '| ', '• ', '- ']
  for (const sep of separators) {
    if (text.includes(sep)) {
      return text.split(sep).map(item => item.trim()).filter(item => item)
    }
  }

  // If no separators found, return as single item array
  return [text]
}

const truncateText = (text, maxLength) => {
  if (!text) return ''
  if (text.length <= maxLength) return text
  return text.substring(0, maxLength) + '...'
}

const downloadReport = (appraisal) => {
  if (appraisal.appraisal_report_path) {
    window.open(appraisal.report_url, '_blank')
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
