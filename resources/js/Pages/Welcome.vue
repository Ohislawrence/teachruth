<template>
  <div class="min-h-screen bg-gradient-to-b from-white via-emerald-50/30 to-teal-50/20">
    <!-- Navigation -->
    <nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-emerald-100/50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
          <div class="flex items-center">
            <div class="flex-shrink-0 flex items-center space-x-3">
              <div class="relative">
                <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg">
                  <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                  </svg>
                </div>
                <div class="absolute -top-1 -right-1 w-3 h-3 bg-gradient-to-r from-emerald-400 to-teal-500 rounded-full animate-pulse"></div>
              </div>
              <span class="text-2xl font-bold bg-gradient-to-r from-emerald-700 to-teal-800 bg-clip-text text-transparent">
                Teachergauge
              </span>
            </div>
          </div>

          <div class="flex items-center space-x-6">
            <Link :href="route('login')" class="group relative text-sm font-semibold text-gray-700 hover:text-emerald-700 transition-all duration-300">
              <span class="relative">
                Log in
                <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-emerald-500 group-hover:w-full transition-all duration-300"></span>
              </span>
            </Link>
            <Link :href="route('teacher.register.step1')"
                  class="relative overflow-hidden group px-5 py-2.5 text-sm font-semibold rounded-full bg-gradient-to-r from-emerald-500 to-teal-600 text-white shadow-lg shadow-emerald-200 hover:shadow-xl hover:shadow-emerald-300 transition-all duration-300 hover:-translate-y-0.5">
              <span class="relative z-10">For Teachers</span>
              <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-teal-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </Link>
            <Link :href="route('school.register.step1')"
                  class="relative overflow-hidden group px-5 py-2.5 text-sm font-semibold rounded-full bg-gradient-to-r from-emerald-600 to-teal-700 text-white shadow-lg shadow-emerald-200 hover:shadow-xl hover:shadow-emerald-300 transition-all duration-300 hover:-translate-y-0.5">
              <span class="relative z-10">For Schools</span>
              <div class="absolute inset-0 bg-gradient-to-r from-emerald-700 to-teal-800 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </Link>
          </div>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative overflow-hidden pt-12 pb-20 sm:pt-20 sm:pb-28 lg:pt-24 lg:pb-32">
      <!-- Background Elements -->
      <div class="absolute top-0 left-1/4 w-72 h-72 bg-gradient-to-br from-emerald-200/20 to-teal-300/10 rounded-full blur-3xl"></div>
      <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-gradient-to-tr from-teal-200/10 to-emerald-300/20 rounded-full blur-3xl"></div>

      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="lg:grid lg:grid-cols-2 lg:gap-12 items-center">
          <!-- Left Content -->
          <div class="relative" ref="heroContent">
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-gradient-to-r from-emerald-100 to-teal-100 text-emerald-700 text-sm font-semibold mb-6 animate-fade-in-up">
              <svg class="w-4 h-4 mr-2 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
              </svg>
              AI-Powered Teaching Excellence
            </div>

            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight">
              <span class="block">Transform Teaching</span>
              <span class="block mt-2">
                <span class="bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                  With Smart Appraisals
                </span>
              </span>
            </h1>

            <p class="mt-6 text-lg md:text-xl text-gray-600 leading-relaxed">
              Teachergauge combines AI-driven analytics with human insight to evaluate teaching performance—helping schools discover exceptional talent and empowering educators with data-driven growth opportunities.
            </p>

            <div class="mt-8 flex flex-col sm:flex-row gap-4">
              <Link :href="route('teacher.register.step1')"
                    class="group relative px-8 py-4 text-base font-semibold rounded-xl text-white shadow-xl shadow-emerald-300/50 hover:shadow-2xl hover:shadow-emerald-400/50 transition-all duration-300 hover:-translate-y-1">
                <div class="absolute inset-0 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-xl"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-teal-700 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <span class="relative flex items-center justify-center">
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                  </svg>
                  Start as Teacher
                </span>
              </Link>

              <Link :href="route('login')"
                    class="group px-8 py-4 text-base font-semibold rounded-xl border-2 border-emerald-200 bg-white text-emerald-700 hover:bg-emerald-50 hover:border-emerald-300 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <span class="flex items-center justify-center">
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                  View Dashboard
                </span>
              </Link>
            </div>

            <!-- Trust Badges -->
            <div class="mt-10 flex items-center space-x-6">
              <div class="flex items-center">
                <div class="flex -space-x-2">
                  <div class="w-8 h-8 rounded-full bg-gradient-to-r from-emerald-400 to-teal-500 border-2 border-white"></div>
                  <div class="w-8 h-8 rounded-full bg-gradient-to-r from-emerald-500 to-teal-600 border-2 border-white"></div>
                  <div class="w-8 h-8 rounded-full bg-gradient-to-r from-emerald-600 to-teal-700 border-2 border-white"></div>
                </div>
                <span class="ml-3 text-sm font-medium text-gray-700">
                  <span class="font-bold text-emerald-700">500+</span> Educators
                </span>
              </div>
              <div class="flex items-center">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-emerald-500 to-teal-600 flex items-center justify-center">
                  <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                  </svg>
                </div>
                <span class="ml-3 text-sm font-medium text-gray-700">
                  <span class="font-bold text-emerald-700">120+</span> Schools
                </span>
              </div>
            </div>
          </div>

          <!-- Right - Dashboard Preview -->
          <div class="relative mt-12 lg:mt-0" ref="dashboardRef">
            <div class="relative max-w-lg mx-auto lg:mx-0 lg:ml-auto">
              <!-- Floating Elements -->
              <div class="absolute -top-6 -left-6 w-32 h-32 bg-gradient-to-br from-emerald-200/30 to-teal-300/20 rounded-2xl blur-xl"></div>
              <div class="absolute -bottom-6 -right-6 w-40 h-40 bg-gradient-to-tr from-teal-200/20 to-emerald-300/30 rounded-2xl blur-xl"></div>

              <!-- Main Dashboard Card -->
              <div class="relative bg-gradient-to-br from-white to-emerald-50/50 rounded-2xl shadow-2xl shadow-emerald-200/50 border border-emerald-100/50 overflow-hidden backdrop-blur-sm">
                <!-- Glass Header -->
                <div class="bg-gradient-to-r from-white/80 to-emerald-50/80 backdrop-blur-md border-b border-emerald-100/50 px-6 py-4">
                  <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                      <div class="w-3 h-3 rounded-full bg-gradient-to-r from-emerald-400 to-teal-500"></div>
                      <div class="text-sm font-semibold text-emerald-800">AI Appraisal Dashboard</div>
                    </div>
                    <div class="flex space-x-1.5">
                      <div class="w-2.5 h-2.5 rounded-full bg-gradient-to-r from-rose-400 to-pink-500"></div>
                      <div class="w-2.5 h-2.5 rounded-full bg-gradient-to-r from-amber-400 to-orange-500"></div>
                      <div class="w-2.5 h-2.5 rounded-full bg-gradient-to-r from-emerald-400 to-teal-500"></div>
                    </div>
                  </div>
                </div>

                <!-- Metrics Grid -->
                <div class="p-6 grid grid-cols-2 gap-4">
                  <MetricCard
                    v-for="metric in metrics"
                    :key="metric.label"
                    :label="metric.label"
                    :value="metric.value"
                    :color="metric.color"
                    :progress="metric.progress"
                    :icon="metric.icon"
                    class="transform hover:scale-105 transition-transform duration-300"
                  />
                </div>

                <!-- Insight Bar -->
                <div class="px-6 pb-6">
                  <div class="bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl p-4 border border-emerald-100">
                    <div class="flex items-center">
                      <svg class="w-5 h-5 text-emerald-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      <p class="text-sm text-emerald-800">
                        <span class="font-semibold">AI Insight:</span> Strong differentiation skills observed with consistent student engagement patterns
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Value Proposition -->
    <section class="py-16 bg-gradient-to-b from-white to-emerald-50/30">
      <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center relative">
          <!-- Animated background element -->
          <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-gradient-to-r from-emerald-200/20 to-teal-300/10 rounded-full blur-3xl"></div>

          <div class="relative">
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-gradient-to-r from-emerald-100 to-teal-100 text-emerald-700 text-sm font-semibold mb-4">
              Trusted by Schools Nationwide
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900">
              Objective Evaluation.
              <span class="block mt-2 bg-gradient-to-r from-emerald-600 to-teal-700 bg-clip-text text-transparent">
                Smarter Hiring.
              </span>
            </h2>
            <p class="mt-6 text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
              Move beyond subjective reviews. Teachergauge delivers transparent, data-driven appraisals that highlight teaching excellence and predict classroom success.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Features -->
    <section id="features" class="py-20 relative overflow-hidden">
      <!-- Background Pattern -->
      <div class="absolute inset-0 bg-gradient-to-b from-emerald-50/50 to-teal-50/30"></div>
      <div class="absolute top-0 right-0 w-1/3 h-1/3 bg-gradient-to-bl from-emerald-200/10 to-teal-300/5 rounded-full blur-3xl"></div>
      <div class="absolute bottom-0 left-0 w-1/3 h-1/3 bg-gradient-to-tr from-emerald-200/10 to-teal-300/5 rounded-full blur-3xl"></div>

      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center mb-16">
          <h2 class="text-sm font-semibold text-emerald-600 tracking-wider uppercase mb-4">
            How It Works
          </h2>
          <h3 class="text-4xl md:text-5xl font-bold text-gray-900">
            Smarter Appraisal,
            <span class="block mt-2 bg-gradient-to-r from-emerald-600 to-teal-700 bg-clip-text text-transparent">
              Better Matches
            </span>
          </h3>
          <p class="mt-6 text-xl text-gray-600 max-w-3xl mx-auto">
            From classroom observation to job placement—Teachergauge supports every step with AI-driven intelligence.
          </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
          <FeatureCard
            v-for="feature in features"
            :key="feature.title"
            :icon="feature.icon"
            :title="feature.title"
            :description="feature.description"
            :gradient="feature.gradient"
            class="transform hover:-translate-y-2 transition-all duration-300"
          />
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 relative overflow-hidden">
      <div class="absolute inset-0 bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800"></div>

      <!-- Animated background elements -->
      <div class="absolute top-0 left-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl animate-pulse"></div>
      <div class="absolute bottom-0 right-0 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s"></div>

      <div class="max-w-4xl mx-auto px-4 sm:px-6 relative">
        <div class="text-center">
          <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm text-white text-sm font-semibold mb-6">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            Join the Future of Education
          </div>

          <h2 class="text-4xl md:text-5xl font-bold text-white">
            Elevate Teaching
            <span class="block mt-2">
              With Data-Driven Insights
            </span>
          </h2>

          <p class="mt-6 text-xl text-emerald-100 max-w-2xl mx-auto">
            Be part of a growing community transforming education through transparent, AI-powered teacher evaluation.
          </p>

          <div class="mt-10">
            <Link :href="route('teacher.register.step1')"
                  class="group relative inline-flex items-center px-10 py-5 text-lg font-bold rounded-2xl text-emerald-700 bg-white shadow-2xl hover:shadow-3xl hover:shadow-white/20 transition-all duration-300 hover:-translate-y-1">
              <div class="absolute inset-0 bg-gradient-to-r from-white to-emerald-50 rounded-2xl"></div>
              <div class="absolute inset-0 bg-gradient-to-r from-emerald-50 to-white rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
              <span class="relative flex items-center">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                Start Free - No Credit Card Required
              </span>
            </Link>

            <p class="mt-6 text-emerald-200 text-sm">
              Join 500+ educators and 120+ schools already transforming education
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gradient-to-b from-white to-gray-50 border-t border-gray-100">
      <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="text-center">
          <div class="flex justify-center items-center space-x-2 mb-6">
            <div class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-lg flex items-center justify-center">
              <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
              </svg>
            </div>
            <span class="text-2xl font-bold bg-gradient-to-r from-emerald-700 to-teal-800 bg-clip-text text-transparent">
              Teachergauge
            </span>
          </div>

          <p class="text-gray-600">
            AI-powered teacher appraisal for modern education
          </p>

          <p class="mt-4 text-sm text-gray-500">
            &copy; {{ currentYear }} Teachergauge. All rights reserved.
          </p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';

// Data
const metrics = ref([
  { label: 'Lesson Clarity', value: '94%', color: 'emerald', progress: 94, icon: '🎯' },
  { label: 'Student Engagement', value: '89%', color: 'teal', progress: 89, icon: '👥' },
  { label: 'Differentiation', value: '87%', color: 'green', progress: 87, icon: '📊' },
  { label: 'Feedback Quality', value: '91%', color: 'emerald', progress: 91, icon: '💬' },
]);

const features = ref([
  {
    icon: '🤖',
    title: 'AI Teaching Analysis',
    description: 'Evaluate 12+ teaching dimensions with intelligent video analysis and student data insights.',
    gradient: 'from-emerald-500 to-teal-600'
  },
  {
    icon: '🔍',
    title: 'Verified Profiles',
    description: 'Every profile includes validated credentials, appraisal scores, and specialization tags.',
    gradient: 'from-emerald-600 to-teal-700'
  },
  {
    icon: '🎯',
    title: 'Smart Job Matching',
    description: 'Discover educators whose strengths align with your school\'s culture and curriculum needs.',
    gradient: 'from-teal-600 to-emerald-700'
  },
  {
    icon: '📈',
    title: 'Growth Tracking',
    description: 'Monitor professional development with personalized recommendations and progress analytics.',
    gradient: 'from-teal-500 to-emerald-600'
  }
]);

// Components
const MetricCard = {
  props: ['label', 'value', 'color', 'progress', 'icon'],
  template: `
    <div class="bg-white rounded-xl p-5 border border-emerald-100 shadow-sm hover:shadow-md transition-shadow duration-300">
      <div class="flex items-start justify-between mb-3">
        <div>
          <div class="text-sm font-medium text-gray-600 mb-1">{{ label }}</div>
          <div class="text-2xl font-bold text-emerald-700">{{ value }}</div>
        </div>
        <div class="text-2xl">{{ icon }}</div>
      </div>
      <div class="space-y-2">
        <div class="h-2 bg-emerald-100 rounded-full overflow-hidden">
          <div class="h-full bg-gradient-to-r from-emerald-400 to-teal-500 rounded-full transition-all duration-500"
               :style="{ width: progress + '%' }"></div>
        </div>
        <div class="flex justify-between text-xs text-gray-500">
          <span>0%</span>
          <span class="font-semibold text-emerald-700">{{ progress }}%</span>
          <span>100%</span>
        </div>
      </div>
    </div>
  `
};

const FeatureCard = {
  props: ['icon', 'title', 'description', 'gradient'],
  template: `
    <div class="bg-white rounded-2xl p-8 border border-emerald-100 shadow-lg hover:shadow-xl transition-all duration-300">
      <div class="mb-6">
        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-emerald-100 to-teal-100 flex items-center justify-center text-2xl mb-4">
          {{ icon }}
        </div>
        <h4 class="text-xl font-bold text-gray-900 mb-3">{{ title }}</h4>
        <p class="text-gray-600 leading-relaxed">{{ description }}</p>
      </div>
      <div class="pt-4 border-t border-emerald-50">
        <div class="inline-flex items-center text-sm font-semibold text-emerald-700 group cursor-pointer">
          <span>Learn more</span>
          <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
          </svg>
        </div>
      </div>
    </div>
  `
};

// Refs
const heroContent = ref(null);
const dashboardRef = ref(null);
const currentYear = new Date().getFullYear();

onMounted(() => {
  // Add intersection observers for animations
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('animate-fade-in-up');
      }
    });
  }, observerOptions);

  if (heroContent.value) observer.observe(heroContent.value);
  if (dashboardRef.value) observer.observe(dashboardRef.value);
});
</script>

<style scoped>
@keyframes fade-in-up {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in-up {
  animation: fade-in-up 0.8s cubic-bezier(0.22, 1, 0.36, 1) forwards;
}

/* Stagger children animations */
.hero-content > * {
  opacity: 0;
  animation: fade-in-up 0.8s cubic-bezier(0.22, 1, 0.36, 1) forwards;
}

.hero-content > *:nth-child(1) { animation-delay: 0.1s; }
.hero-content > *:nth-child(2) { animation-delay: 0.2s; }
.hero-content > *:nth-child(3) { animation-delay: 0.3s; }
.hero-content > *:nth-child(4) { animation-delay: 0.4s; }
.hero-content > *:nth-child(5) { animation-delay: 0.5s; }

/* Smooth scroll behavior */
html {
  scroll-behavior: smooth;
}

/* Custom scrollbar */
::-webkit-scrollbar {
  width: 10px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
  background: linear-gradient(to bottom, #10b981, #0d9488);
  border-radius: 5px;
}

::-webkit-scrollbar-thumb:hover {
  background: linear-gradient(to bottom, #059669, #0f766e);
}
</style>
