<template>
  <AppLayout title="Teacher Appraisal Details">
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
                  <h1 class="text-xl font-bold text-white">Teacher Appraisal</h1>
                  <p class="text-xs text-emerald-100">Detailed competency assessment</p>
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
                Applications
              </Link>
            </div>
          </div>
        </div>
      </nav>

      <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <!-- Appraisal Header -->
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

                    <!-- Teacher Info -->
                    <div class="flex-1">
                      <div class="flex items-center space-x-4 mb-2">
                        <h1 class="text-3xl font-bold text-gray-900">{{ teacher.name }}</h1>
                        <div v-if="appraisal.is_latest"
                             class="px-3 py-1 rounded-full text-sm font-bold bg-green-100 text-green-800">
                          Latest Appraisal
                        </div>
                      </div>

                      <div class="space-y-2">
                        <p class="text-xl text-emerald-700 font-semibold">
                          AI-Powered Competency Assessment
                        </p>
                        <div class="flex items-center text-gray-600">
                          <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                          </svg>
                          Appraised on {{ formatDate(appraisal.created_at) }}
                        </div>
                        <div class="text-gray-600">
                          Level-3 Teaching Competency Framework
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Overall Score Card -->
                <div class="mt-4 lg:mt-0 lg:ml-4">
                  <div class="bg-gradient-to-r from-emerald-100 to-teal-100 rounded-xl p-6 border border-emerald-200 shadow-lg">
                    <div class="text-center">
                      <p class="text-sm font-medium text-emerald-600 mb-2">Overall Performance Score</p>
                      <div class="flex items-center justify-center">
                        <span class="text-5xl font-bold text-emerald-700">
                          {{ appraisal.overall_score }}
                        </span>
                        <span class="text-2xl text-emerald-600 ml-1">/100</span>
                      </div>
                      <div class="mt-4">
                        <span :class="gradeBadgeClass" class="px-4 py-2 rounded-full text-lg font-bold">
                          Grade: {{ appraisal.grade }}
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
              <!-- Performance Summary -->
              <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 sm:px-8">
                  <h2 class="text-xl font-bold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Performance Summary
                  </h2>
                </div>
                <div class="px-6 py-6 sm:px-8">
                  <div class="prose max-w-none">
                    <p class="text-gray-700 text-lg leading-relaxed whitespace-pre-line">
                      {{ appraisal.detailed_feedback }}
                    </p>
                  </div>

                  <!-- Summary Stats -->
                  <div class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-4 p-6 bg-emerald-50 rounded-xl border border-emerald-100">
                    <div class="text-center">
                      <div class="text-3xl font-bold text-emerald-700">{{ appraisal.overall_score }}%</div>
                      <div class="text-sm text-emerald-600 font-medium">Overall Score</div>
                    </div>
                    <div class="text-center">
                      <div class="text-3xl font-bold" :class="gradeTextColor">{{ appraisal.grade }}</div>
                      <div class="text-sm text-gray-600 font-medium">Grade</div>
                    </div>
                    <div class="text-center">
                      <div class="text-3xl font-bold text-gray-700">{{ totalCompetencies }}</div>
                      <div class="text-sm text-gray-600 font-medium">Competencies</div>
                    </div>
                    <div class="text-center">
                      <div class="text-3xl font-bold text-gray-700">{{ totalIndicators }}</div>
                      <div class="text-sm text-gray-600 font-medium">Indicators</div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Competency Breakdown -->
              <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 sm:px-8">
                  <h2 class="text-xl font-bold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Competency Analysis
                  </h2>
                </div>
                <div class="px-6 py-6 sm:px-8">
                  <div class="space-y-6">
                    <div v-for="(competency, key) in appraisal.scores_breakdown" :key="key"
                         class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 rounded-r-xl p-6 hover:shadow-lg transition-shadow">
                      <div class="flex flex-col md:flex-row md:items-center justify-between mb-5">
                        <div class="mb-4 md:mb-0">
                          <h3 class="text-xl font-semibold text-gray-900">{{ formatCompetencyName(key) }}</h3>
                          <p class="text-sm text-gray-600 mt-1">Teaching Competency Area</p>
                        </div>
                        <div class="text-center md:text-right">
                          <div class="text-3xl font-bold" :class="scoreColor(competency.score)">
                            {{ competency.score }}%
                          </div>
                          <div class="text-sm text-gray-600 mt-1">
                            Average: {{ calculateIndicatorAverage(competency.indicators).toFixed(1) }}/4
                          </div>
                        </div>
                      </div>

                      <!-- Progress Bar -->
                      <div class="mb-6">
                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                          <span class="font-medium">Performance Level</span>
                          <span class="font-semibold">{{ getPerformanceLevel(competency.score) }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                          <div class="h-3 rounded-full" :class="scoreBarColor(competency.score)"
                               :style="{ width: Math.min(competency.score, 100) + '%' }"></div>
                        </div>
                      </div>

                      <!-- Indicators -->
                      <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Indicator Performance (1-4 scale)</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                          <div v-for="(indicatorScore, indicatorName) in competency.indicators" :key="indicatorName"
                               class="bg-white p-4 rounded-xl border border-gray-200 hover:border-emerald-300 transition-colors">
                            <div class="flex justify-between items-start mb-2">
                              <span class="text-sm font-medium text-gray-700">
                                {{ formatIndicatorName(indicatorName) }}
                              </span>
                              <span class="text-lg font-bold" :class="indicatorScoreColor(indicatorScore)">
                                {{ indicatorScore }}
                              </span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2">
                              <div class="h-2 rounded-full" :class="indicatorBarColor(indicatorScore)"
                                   :style="{ width: (indicatorScore / 4 * 100) + '%' }"></div>
                            </div>
                            <div class="text-xs text-gray-500 mt-2 text-center">
                              {{ getIndicatorRatingText(indicatorScore) }}
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Strengths & Improvement Areas -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Strengths Card -->
                <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 overflow-hidden">
                  <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 sm:px-8">
                    <div class="flex items-center">
                      <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                      </div>
                      <h2 class="text-xl font-bold text-gray-900">Key Strengths</h2>
                    </div>
                  </div>
                  <div class="px-6 py-6 sm:px-8">
                    <div class="space-y-3">
                      <div v-for="(strength, index) in strengthsArray" :key="index"
                           class="flex items-start p-4 bg-green-50 rounded-xl hover:bg-green-100 transition-colors">
                        <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-green-800">{{ strength }}</span>
                      </div>
                      <div v-if="strengthsArray.length === 0" class="text-center py-8">
                        <p class="text-gray-500 italic">No strengths recorded</p>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Improvement Areas Card -->
                <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 overflow-hidden">
                  <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 sm:px-8">
                    <div class="flex items-center">
                      <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center mr-3">
                        <svg class="w-6 h-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                      </div>
                      <h2 class="text-xl font-bold text-gray-900">Areas for Improvement</h2>
                    </div>
                  </div>
                  <div class="px-6 py-6 sm:px-8">
                    <div class="space-y-3">
                      <div v-for="(area, index) in improvementAreasArray" :key="index"
                           class="flex items-start p-4 bg-amber-50 rounded-xl hover:bg-amber-100 transition-colors">
                        <svg class="w-5 h-5 text-amber-500 mr-3 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                        <span class="text-amber-800">{{ area }}</span>
                      </div>
                      <div v-if="improvementAreasArray.length === 0" class="text-center py-8">
                        <p class="text-gray-500 italic">No improvement areas recorded</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
              <!-- Teacher Information Card -->
              <div class="bg-gradient-to-r from-emerald-50 to-teal-50 shadow-xl rounded-2xl border border-emerald-100 overflow-hidden">
                <div class="px-6 py-4 sm:px-8">
                  <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Teacher Information
                  </h3>
                </div>
                <div class="px-6 py-6 sm:px-8 bg-white/50">
                  <div class="space-y-4">
                    <div class="flex justify-between items-center p-3 bg-white rounded-lg border border-emerald-100">
                      <span class="text-sm font-medium text-emerald-700">Name</span>
                      <span class="text-sm font-semibold text-gray-900">{{ teacher.name }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-white rounded-lg border border-emerald-100">
                      <span class="text-sm font-medium text-emerald-700">Email</span>
                      <a :href="'mailto:' + teacher.email" class="text-sm font-semibold text-emerald-600 hover:text-emerald-800">
                        {{ teacher.email }}
                      </a>
                    </div>
                    <div v-if="teacher.teacher_profile?.phone" class="flex justify-between items-center p-3 bg-white rounded-lg border border-emerald-100">
                      <span class="text-sm font-medium text-emerald-700">Phone</span>
                      <a :href="'tel:' + teacher.teacher_profile.phone" class="text-sm font-semibold text-gray-900">
                        {{ teacher.teacher_profile.phone }}
                      </a>
                    </div>
                    <div v-if="teacher.teacher_profile?.qualification" class="flex justify-between items-center p-3 bg-white rounded-lg border border-emerald-100">
                      <span class="text-sm font-medium text-emerald-700">Qualification</span>
                      <span class="text-sm font-semibold text-gray-900">{{ teacher.teacher_profile.qualification }}</span>
                    </div>
                    <div v-if="teacher.teacher_profile?.years_of_experience" class="flex justify-between items-center p-3 bg-white rounded-lg border border-emerald-100">
                      <span class="text-sm font-medium text-emerald-700">Experience</span>
                      <span class="text-sm font-semibold text-gray-900">{{ teacher.teacher_profile.years_of_experience }} years</span>
                    </div>
                  </div>
                  <div class="mt-6">
                    <Link
                      :href="route('school.applications.show', findApplicationId())"
                      class="inline-flex items-center justify-center w-full px-4 py-2.5 border border-emerald-300 text-sm font-semibold rounded-xl text-emerald-700 bg-white hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-200 transition"
                    >
                      <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                      </svg>
                      Back to Application
                    </Link>
                  </div>
                </div>
              </div>

              <!-- Action Card -->
              <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 sm:px-8">
                  <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Actions
                  </h3>
                </div>
                <div class="px-6 py-6 sm:px-8">
                  <div class="space-y-3">
                    <button
                      @click="downloadPDF"
                      class="w-full flex justify-center items-center px-4 py-3 border border-emerald-300 text-sm font-semibold rounded-xl text-emerald-700 bg-white hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-200 transition-colors"
                    >
                      <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                      </svg>
                      Download PDF Report
                    </button>
                    <button
                      @click="compareWithPrevious"
                      class="w-full flex justify-center items-center px-4 py-3 border border-blue-300 text-sm font-semibold rounded-xl text-blue-700 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-200 transition-colors"
                    >
                      <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                      </svg>
                      Compare with Previous
                    </button>
                    <a
                      :href="'mailto:' + teacher.email + '?subject=Regarding Your Teaching Appraisal&body=Dear ' + teacher.name + ',%0D%0A%0D%0AI wanted to discuss your recent teaching appraisal results with you.'"
                      class="block w-full text-center px-4 py-3 border border-transparent text-sm font-semibold rounded-xl text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-300 transition-colors"
                    >
                      <svg class="w-5 h-5 mr-2 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                      </svg>
                      Send Feedback Email
                    </a>
                  </div>
                </div>
              </div>

              <!-- Performance Insights -->
              <div class="bg-gradient-to-r from-blue-50 to-indigo-50 shadow-xl rounded-2xl border border-blue-100 overflow-hidden">
                <div class="px-6 py-4 sm:px-8">
                  <h3 class="text-xl font-bold text-blue-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Performance Insights
                  </h3>
                </div>
                <div class="px-6 py-6 sm:px-8">
                  <div class="space-y-4">
                    <div v-for="competency in topCompetencies" :key="competency.key">
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
                        Avg: {{ calculateIndicatorAverage(competency.indicators).toFixed(1) }}/4
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Top Competencies -->
              <div class="bg-gradient-to-r from-green-50 to-emerald-50 shadow-xl rounded-2xl border border-green-100 overflow-hidden">
                <div class="px-6 py-4 sm:px-8">
                  <h3 class="text-xl font-bold text-green-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                    Top Performing Competencies
                  </h3>
                </div>
                <div class="px-6 py-6 sm:px-8">
                  <div class="space-y-3">
                    <div v-for="(competency, index) in topCompetencies" :key="competency.key"
                         class="flex items-center p-4 bg-white rounded-xl border border-green-100 hover:shadow-md transition-shadow">
                      <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3">
                        <span class="text-sm font-bold text-green-700">{{ index + 1 }}</span>
                      </div>
                      <div class="flex-1">
                        <div class="font-semibold text-green-900">{{ competency.name }}</div>
                        <div class="text-sm text-green-700">{{ competency.score }}%</div>
                      </div>
                      <div class="text-lg font-bold" :class="scoreColor(competency.score)">
                        {{ getPerformanceLevel(competency.score) }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Development Recommendations -->
              <div class="bg-gradient-to-r from-purple-50 to-violet-50 shadow-xl rounded-2xl border border-purple-100 overflow-hidden">
                <div class="px-6 py-4 sm:px-8">
                  <h3 class="text-xl font-bold text-purple-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Recommendations
                  </h3>
                </div>
                <div class="px-6 py-6 sm:px-8">
                  <ul class="text-sm text-purple-800 space-y-3">
                    <li class="flex items-start">
                      <svg class="w-5 h-5 text-purple-500 mr-2 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      <span>Focus on competencies scoring below 70% for targeted development</span>
                    </li>
                    <li class="flex items-start">
                      <svg class="w-5 h-5 text-purple-500 mr-2 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      <span>Consider professional development in {{ lowestCompetency?.name || 'identified areas' }}</span>
                    </li>
                    <li class="flex items-start">
                      <svg class="w-5 h-5 text-purple-500 mr-2 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 01118 0z" />
                      </svg>
                      <span>Leverage strengths in {{ topCompetencies[0]?.name || 'key areas' }} for mentorship opportunities</span>
                    </li>
                  </ul>
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
import { computed, ref } from 'vue'

const props = defineProps({
  appraisal: Object,
  teacher: Object
})

const strengthsArray = computed(() => {
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

  return [text]
})

const improvementAreasArray = computed(() => {
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
      name: formatCompetencyName(key),
      score: competency.score,
      indicators: competency.indicators || {}
    }))
    .sort((a, b) => b.score - a.score)
    .slice(0, 3)
})

const lowestCompetency = computed(() => {
  if (!props.appraisal.scores_breakdown) return null

  const competencies = Object.entries(props.appraisal.scores_breakdown)
    .map(([key, competency]) => ({
      key,
      name: formatCompetencyName(key),
      score: competency.score
    }))
    .sort((a, b) => a.score - b.score)

  return competencies[0] || null
})

const gradeBadgeClass = computed(() => {
  const grade = props.appraisal.grade
  const classes = {
    'A+': 'bg-green-100 text-green-800',
    'A': 'bg-green-100 text-green-800',
    'B': 'bg-yellow-100 text-yellow-800',
    'C': 'bg-orange-100 text-orange-800',
    'D': 'bg-red-100 text-red-800',
    'F': 'bg-red-100 text-red-800'
  }
  return classes[grade] || 'bg-gray-100 text-gray-800'
})

const gradeTextColor = computed(() => {
  const grade = props.appraisal.grade
  const colors = {
    'A+': 'text-green-600',
    'A': 'text-green-600',
    'B': 'text-yellow-600',
    'C': 'text-orange-600',
    'D': 'text-red-600',
    'F': 'text-red-600'
  }
  return colors[grade] || 'text-gray-600'
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

const indicatorBarColor = (score) => {
  const numScore = parseFloat(score)
  if (numScore >= 3.5) return 'bg-green-500'
  if (numScore >= 3) return 'bg-blue-500'
  if (numScore >= 2.5) return 'bg-yellow-500'
  if (numScore >= 2) return 'bg-orange-500'
  return 'bg-red-500'
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
  return name.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())
}

const formatCompetencyName = (key) => {
  const names = {
    'competency_1': 'Innovative Teaching Strategies',
    'competency_2': 'Student Assessment & Reporting',
    'competency_3': 'Self Development & Reflection',
    'competency_4': 'Enhance Colleagues\' Development',
    'competency_5': 'School Leadership',
    'teaching_methodology': 'Teaching Methodology',
    'classroom_management': 'Classroom Management',
    'student_engagement': 'Student Engagement',
    'assessment_practices': 'Assessment Practices',
    'professional_development': 'Professional Development'
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

const findApplicationId = () => {
  // Use the application_id passed from the controller
  return props.application_id || ''
}

const downloadPDF = () => {
  if (props.appraisal.appraisal_report_path) {
    window.open(props.appraisal.report_url, '_blank')
  } else {
    alert('PDF report is not available for this appraisal.')
  }
}

const compareWithPrevious = () => {
  // This would need to be implemented based on your data structure
  alert('Compare feature coming soon. This will show comparison with previous appraisals.')
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
