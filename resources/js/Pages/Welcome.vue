<template>
  <div class="min-h-screen bg-gradient-to-br from-emerald-50 to-teal-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
          <div class="flex items-center">
            <div class="flex-shrink-0 flex items-center">
              <svg
                class="h-8 w-8 text-emerald-600"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 
                  0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"
                  fill="currentColor"
                />
                <path d="M16 12a4 4 0 11-8 0 4 4 0 018 0z" fill="currentColor" />
              </svg>
              <span class="ml-2 text-xl font-bold text-gray-900">Teachergauge</span>
            </div>
          </div>

          <div class="flex items-center space-x-4">
            <Link
              :href="route('login')"
              class="text-sm font-medium text-gray-600 hover:text-emerald-700 transition"
            >
              Log in
            </Link>
            <Link
              :href="route('teacher.register.step1')"
              class="bg-emerald-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition"
            >
              Join as Teacher
            </Link>
          </div>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <section
      ref="heroSection"
      class="relative overflow-hidden pt-10 pb-16 sm:pt-16 sm:pb-24 lg:pb-32 opacity-0 transition-opacity duration-700"
      :class="{ 'opacity-100 translate-y-0 animate-fade-in-up': heroVisible }"
    >
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:w-1/2">
          <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight sm:text-5xl md:text-6xl">
            <span class="block">AI-Powered Teacher Appraisal</span>
            <span class="block mt-2 text-emerald-600">Designed for Growth & Excellence</span>
          </h1>
          <p class="mt-5 text-lg text-gray-600 max-w-xl">
            Teachergauge uses intelligent analytics to evaluate teaching performance—helping
            schools find top talent and teachers grow with data-driven insights.
          </p>
          <div class="mt-8 flex flex-col sm:flex-row sm:space-x-4 space-y-3 sm:space-y-0">
            <Link
              :href="route('teacher.register.step1')"
              class="inline-flex items-center justify-center px-6 py-3 text-base font-medium rounded-md shadow-sm text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition"
            >
              Start Your Profile
            </Link>
            <Link
              :href="route('login')"
              class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-emerald-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition"
            >
              View Dashboard Preview
            </Link>
          </div>
        </div>
      </div>

      <!-- Dashboard Preview -->
      <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 flex items-center justify-center">
        <div
          ref="dashboardRef"
          class="w-full max-w-lg transform opacity-0"
          :class="{ 'animate-dashboard-enter': dashboardVisible }"
        >
          <div
            class="relative bg-white rounded-xl shadow-lg border border-emerald-100 p-6 h-full flex flex-col"
          >
            <!-- Window Controls -->
            <div class="flex justify-between items-center mb-5">
              <div class="text-sm font-medium text-gray-800">AI Appraisal Dashboard</div>
              <div class="flex space-x-1.5">
                <div class="w-2.5 h-2.5 rounded-full bg-red-400"></div>
                <div class="w-2.5 h-2.5 rounded-full bg-yellow-400"></div>
                <div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>
              </div>
            </div>

            <!-- Metrics -->
            <div class="grid grid-cols-2 gap-4 flex-grow">
              <MetricCard label="Lesson Clarity" value="94%" color="emerald" :progress="94" />
              <MetricCard label="Student Engagement" value="89%" color="teal" :progress="89" />
              <MetricCard label="Differentiation" value="87%" color="green" :progress="87" />
              <MetricCard label="Feedback Quality" value="91%" color="emerald" :progress="91" />
            </div>

            <p class="mt-5 text-xs text-gray-500 text-center">
              AI-generated insights from live classroom observation & feedback
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Value Proposition -->
    <section class="py-16 bg-white">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-sm font-semibold text-emerald-600 tracking-wide uppercase">
          Trusted by Schools & Educators
        </h2>
        <p class="mt-2 text-3xl font-bold text-gray-900 sm:text-4xl">
          Objective Evaluation. Smarter Hiring.
        </p>
        <p class="mt-5 text-lg text-gray-600 max-w-2xl mx-auto">
          Teachergauge replaces subjective reviews with transparent, AI-powered appraisals—so
          great teachers shine, and schools build stronger teams.
        </p>
      </div>
    </section>

    <!-- Features -->
    <section id="features" class="py-16 bg-emerald-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
          <h2 class="text-sm font-semibold text-emerald-600 tracking-wide uppercase">
            How It Works
          </h2>
          <p class="mt-2 text-3xl font-bold text-gray-900 sm:text-4xl">
            Smarter Appraisal, Better Matches
          </p>
          <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
            From classroom observation to job placement—Teachergauge supports every step with
            AI-driven intelligence.
          </p>
        </div>

        <div class="mt-16 grid gap-12 md:grid-cols-2 lg:grid-cols-4">
          <FeatureItem
            icon="📊"
            title="AI Teaching Analysis"
            description="Our system evaluates 12+ teaching dimensions using video, student data, and rubrics—delivered with actionable insights."
          />
          <FeatureItem
            icon="🔍"
            title="Verified Profiles"
            description="Every teacher profile includes validated credentials, appraisal scores, and specialization tags."
          />
          <FeatureItem
            icon="🤝"
            title="Smart Job Matching"
            description="Schools discover educators whose strengths align with their culture, curriculum, and needs."
          />
          <FeatureItem
            icon="📈"
            title="Growth Tracking"
            description="Track professional progress over time with personalized development recommendations."
          />
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section
      ref="ctaSection"
      class="bg-emerald-600 opacity-0 transition-opacity duration-700"
      :class="{ 'animate-fade-in opacity-100': ctaVisible }"
    >
      <div class="max-w-3xl mx-auto text-center py-16 px-4 sm:px-6">
        <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
          Elevate Teaching with Data
        </h2>
        <p class="mt-4 text-lg text-emerald-100 max-w-xl mx-auto">
          Join a growing community of forward-thinking schools and educators transforming
          appraisal with AI.
        </p>
        <Link
          :href="route('teacher.register.step1')"
          class="mt-8 inline-block px-6 py-3 bg-white text-emerald-700 font-medium rounded-md shadow hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-emerald-600 transition"
        >
          Create Your Profile — Free
        </Link>
      </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200">
      <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="text-center text-sm text-gray-500">
          &copy; {{ currentYear }} Teachergauge. AI-powered teacher appraisal for modern
          education.
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';

// Components
const MetricCard = {
  props: ['label', 'value', 'color', 'progress'],
  computed: {
    bgColor() {
      return `bg-${this.color}-50`;
    },
    textColor() {
      return `text-${this.color}-700`;
    },
    barColor() {
      return `bg-${this.color}-600`;
    },
    barBg() {
      return `bg-${this.color}-200`;
    },
  },
  template: `
    <div :class="[bgColor, 'p-4 rounded-lg']">
      <div class="text-xs font-medium text-gray-700">{{ label }}</div>
      <div :class="textColor" class="text-xl font-bold mt-1">{{ value }}</div>
      <div :class="barBg" class="h-1.5 rounded-full mt-2 overflow-hidden">
        <div :class="barColor" class="h-full rounded-full" :style="{ width: progress + '%' }"></div>
      </div>
    </div>
  `,
};

const FeatureItem = {
  props: ['icon', 'title', 'description'],
  template: `
    <div class="text-center">
      <div class="text-3xl mb-3">{{ icon }}</div>
      <h3 class="text-lg font-semibold text-gray-900">{{ title }}</h3>
      <p class="mt-2 text-gray-600 text-sm">{{ description }}</p>
    </div>
  `,
};

// Reactive refs
const heroSection = ref(null);
const ctaSection = ref(null);
const dashboardRef = ref(null);
const heroVisible = ref(false);
const ctaVisible = ref(false);
const dashboardVisible = ref(false);
const currentYear = new Date().getFullYear();

let heroObserver, ctaObserver, dashboardObserver;

onMounted(() => {
  heroObserver = new IntersectionObserver(([entry]) => {
    if (entry.isIntersecting) {
      heroVisible.value = true;
      heroObserver.disconnect();
    }
  });
  if (heroSection.value) heroObserver.observe(heroSection.value);

  ctaObserver = new IntersectionObserver(([entry]) => {
    if (entry.isIntersecting) {
      ctaVisible.value = true;
      ctaObserver.disconnect();
    }
  });
  if (ctaSection.value) ctaObserver.observe(ctaSection.value);

  dashboardObserver = new IntersectionObserver(([entry]) => {
    if (entry.isIntersecting) {
      dashboardVisible.value = true;
      dashboardObserver.disconnect();
    }
  });
  if (dashboardRef.value) dashboardObserver.observe(dashboardRef.value);
});

onUnmounted(() => {
  heroObserver?.disconnect();
  ctaObserver?.disconnect();
  dashboardObserver?.disconnect();
});
</script>

<style scoped>
@keyframes dashboard-enter {
  from {
    opacity: 0;
    transform: scale(0.95) translateY(10px);
  }
  to {
    opacity: 1;
    transform: scale(1) translateY(0);
  }
}
.animate-dashboard-enter {
  animation: dashboard-enter 0.5s cubic-bezier(0.22, 1, 0.36, 1) forwards;
}
@keyframes fade-in-up {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
.animate-fade-in-up {
  animation: fade-in-up 0.8s ease-out forwards;
}
</style>
