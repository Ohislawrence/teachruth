<template>
    <AppLayout title="Post New Job">
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
                                    <h1 class="text-xl font-bold text-white">Post New Job</h1>
                                    <p class="text-xs text-emerald-100">Create a teaching position</p>
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
                                My Jobs
                            </Link>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="py-8">
                <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                    <!-- Header -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-3xl font-bold text-gray-900">Create New Teaching Position</h2>
                                <p class="text-emerald-700 mt-2">Fill in the details to post a new job opening</p>
                            </div>
                            <div class="text-sm">
                                <span class="text-red-500">*</span> Required fields
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow-2xl rounded-2xl border border-emerald-100 overflow-hidden">
                        <form @submit.prevent="submitForm" class="p-6 space-y-8">
                            <!-- Basic Information -->
                            <div>
                                <h3 class="text-xl font-bold text-emerald-800 mb-6 pb-2 border-b border-emerald-100">
                                    <svg class="w-5 h-5 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Basic Information
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Job Title -->
                                    <div>
                                        <label for="title" class="block text-sm font-semibold text-emerald-700 mb-2">
                                            <span class="text-red-500">*</span> Job Title
                                        </label>
                                        <input
                                            type="text"
                                            id="title"
                                            v-model="form.title"
                                            required
                                            class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                                            placeholder="e.g., Mathematics Teacher"
                                            :class="form.errors.title ? 'border-red-300' : ''"
                                        />
                                        <p v-if="form.errors.title" class="text-red-500 text-sm mt-1">{{ form.errors.title }}</p>
                                    </div>

                                    <!-- Subject -->
                                    <div>
                                        <label for="subject" class="block text-sm font-semibold text-emerald-700 mb-2">
                                            <span class="text-red-500">*</span> Subject
                                        </label>
                                        <select
                                            id="subject"
                                            v-model="form.subject"
                                            required
                                            class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition bg-white"
                                            :class="form.errors.subject ? 'border-red-300' : ''"
                                        >
                                            <option value="">Select Subject</option>
                                            <option v-for="subject in subjects" :key="subject" :value="subject">
                                                {{ formatSubjectName(subject) }}
                                            </option>
                                        </select>
                                        <p v-if="form.errors.subject" class="text-red-500 text-sm mt-1">{{ form.errors.subject }}</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                    <!-- Level -->
                                    <div>
                                        <label for="level" class="block text-sm font-semibold text-emerald-700 mb-2">
                                            <span class="text-red-500">*</span> Grade Level
                                        </label>
                                        <select
                                            id="level"
                                            v-model="form.level"
                                            required
                                            class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition bg-white"
                                            :class="form.errors.level ? 'border-red-300' : ''"
                                        >
                                            <option value="">Select Level</option>
                                            <option value="nursery">Nursery School</option>
                                            <option value="primary">Primary School</option>
                                            <option value="junior_secondary">Junior Secondary</option>
                                            <option value="senior_secondary">Senior Secondary</option>
                                        </select>
                                        <p v-if="form.errors.level" class="text-red-500 text-sm mt-1">{{ form.errors.level }}</p>
                                    </div>

                                    <!-- Class/Grade -->
                                    <div>
                                        <label for="class_grade" class="block text-sm font-semibold text-emerald-700 mb-2">
                                            Specific Class/Grade (Optional)
                                        </label>
                                        <input
                                            type="text"
                                            id="class_grade"
                                            v-model="form.class_grade"
                                            class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                                            placeholder="e.g., Grade 5, JSS 2, SS 3"
                                        />
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <label for="description" class="block text-sm font-semibold text-emerald-700 mb-2">
                                        <span class="text-red-500">*</span> Job Description
                                    </label>
                                    <textarea
                                        id="description"
                                        v-model="form.description"
                                        required
                                        rows="6"
                                        class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                                        placeholder="Describe the job responsibilities, expectations, and requirements..."
                                        :class="form.errors.description ? 'border-red-300' : ''"
                                    ></textarea>
                                    <p v-if="form.errors.description" class="text-red-500 text-sm mt-1">{{ form.errors.description }}</p>
                                </div>
                            </div>

                            <!-- Location & Employment Details -->
                            <div>
                                <h3 class="text-xl font-bold text-emerald-800 mb-6 pb-2 border-b border-emerald-100">
                                    <svg class="w-5 h-5 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Location & Employment Details
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- State -->
                                    <div>
                                        <label for="state" class="block text-sm font-semibold text-emerald-700 mb-2">
                                            <span class="text-red-500">*</span> State
                                        </label>
                                        <select
                                            id="state"
                                            v-model="form.state"
                                            required
                                            class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition bg-white"
                                            :class="form.errors.state ? 'border-red-300' : ''"
                                        >
                                            <option value="">Select State</option>
                                            <option value="Lagos">Lagos</option>
                                            <option value="Abuja">Abuja</option>
                                            <option value="Oyo">Oyo</option>
                                            <option value="Kano">Kano</option>
                                            <option value="Rivers">Rivers</option>
                                            <option value="Delta">Delta</option>
                                            <option value="Ogun">Ogun</option>
                                            <option value="Enugu">Enugu</option>
                                            <option value="Kaduna">Kaduna</option>
                                            <option value="Edo">Edo</option>
                                            <option value="Plateau">Plateau</option>
                                            <option value="Cross River">Cross River</option>
                                            <option value="Akwa Ibom">Akwa Ibom</option>
                                            <option value="Bauchi">Bauchi</option>
                                            <option value="Imo">Imo</option>
                                            <option value="Benue">Benue</option>
                                            <option value="Borno">Borno</option>
                                            <option value="Anambra">Anambra</option>
                                            <option value="Sokoto">Sokoto</option>
                                            <option value="Nasarawa">Nasarawa</option>
                                            <option value="Bayelsa">Bayelsa</option>
                                            <option value="Niger">Niger</option>
                                            <option value="Ekiti">Ekiti</option>
                                            <option value="Taraba">Taraba</option>
                                            <option value="Kwara">Kwara</option>
                                            <option value="Kebbi">Kebbi</option>
                                            <option value="Ondo">Ondo</option>
                                            <option value="Osun">Osun</option>
                                            <option value="Kogi">Kogi</option>
                                            <option value="Zamfara">Zamfara</option>
                                            <option value="Yobe">Yobe</option>
                                            <option value="Gombe">Gombe</option>
                                            <option value="Jigawa">Jigawa</option>
                                            <option value="Katsina">Katsina</option>
                                            <option value="Ebonyi">Ebonyi</option>
                                        </select>
                                        <p v-if="form.errors.state" class="text-red-500 text-sm mt-1">{{ form.errors.state }}</p>
                                    </div>

                                    <!-- LGA -->
                                    <div>
                                        <label for="lga" class="block text-sm font-semibold text-emerald-700 mb-2">
                                            <span class="text-red-500">*</span> Local Government Area (LGA)
                                        </label>
                                        <input
                                            type="text"
                                            id="lga"
                                            v-model="form.lga"
                                            required
                                            class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                                            placeholder="Enter LGA"
                                            :class="form.errors.lga ? 'border-red-300' : ''"
                                        />
                                        <p v-if="form.errors.lga" class="text-red-500 text-sm mt-1">{{ form.errors.lga }}</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                    <!-- Employment Type -->
                                    <div>
                                        <label for="employment_type" class="block text-sm font-semibold text-emerald-700 mb-2">
                                            <span class="text-red-500">*</span> Employment Type
                                        </label>
                                        <select
                                            id="employment_type"
                                            v-model="form.employment_type"
                                            required
                                            class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition bg-white"
                                            :class="form.errors.employment_type ? 'border-red-300' : ''"
                                        >
                                            <option value="">Select Type</option>
                                            <option value="full_time">Full Time</option>
                                            <option value="part_time">Part Time</option>
                                            <option value="contract">Contract</option>
                                            <option value="temporary">Temporary</option>
                                        </select>
                                        <p v-if="form.errors.employment_type" class="text-red-500 text-sm mt-1">{{ form.errors.employment_type }}</p>
                                    </div>

                                    <!-- Application Deadline -->
                                    <div>
                                        <label for="application_deadline" class="block text-sm font-semibold text-emerald-700 mb-2">
                                            <span class="text-red-500">*</span> Application Deadline
                                        </label>
                                        <input
                                            type="date"
                                            id="application_deadline"
                                            v-model="form.application_deadline"
                                            required
                                            :min="minDate"
                                            class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                                            :class="form.errors.application_deadline ? 'border-red-300' : ''"
                                        />
                                        <p v-if="form.errors.application_deadline" class="text-red-500 text-sm mt-1">{{ form.errors.application_deadline }}</p>
                                        <p class="text-xs text-gray-500 mt-1">Applications will close automatically after this date</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Salary Information -->
                            <div>
                                <h3 class="text-xl font-bold text-emerald-800 mb-6 pb-2 border-b border-emerald-100">
                                    <svg class="w-5 h-5 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Salary Information (Optional)
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Minimum Salary -->
                                    <div>
                                        <label for="salary_range_min" class="block text-sm font-semibold text-emerald-700 mb-2">
                                            Minimum Salary (₦)
                                        </label>
                                        <input
                                            type="number"
                                            id="salary_range_min"
                                            v-model="form.salary_range_min"
                                            min="0"
                                            step="1000"
                                            class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                                            placeholder="e.g., 50000"
                                            :class="form.errors.salary_range_min ? 'border-red-300' : ''"
                                        />
                                        <p v-if="form.errors.salary_range_min" class="text-red-500 text-sm mt-1">{{ form.errors.salary_range_min }}</p>
                                    </div>

                                    <!-- Maximum Salary -->
                                    <div>
                                        <label for="salary_range_max" class="block text-sm font-semibold text-emerald-700 mb-2">
                                            Maximum Salary (₦)
                                        </label>
                                        <input
                                            type="number"
                                            id="salary_range_max"
                                            v-model="form.salary_range_max"
                                            min="0"
                                            step="1000"
                                            class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                                            placeholder="e.g., 150000"
                                            :class="form.errors.salary_range_max ? 'border-red-300' : ''"
                                        />
                                        <p v-if="form.errors.salary_range_max" class="text-red-500 text-sm mt-1">{{ form.errors.salary_range_max }}</p>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500 mt-2">
                                    Leave both fields blank if salary is negotiable. Maximum should be greater than minimum if both are provided.
                                </p>
                            </div>

                            <!-- Form Actions -->
                            <div class="pt-6 border-t border-emerald-100">
                                <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                                    <div>
                                        <p class="text-sm text-gray-600">
                                            All fields marked with <span class="text-red-500">*</span> are required
                                        </p>
                                    </div>
                                    <div class="flex space-x-4">
                                        <Link
                                            :href="route('school.jobs')"
                                            class="inline-flex items-center px-6 py-3 border-2 border-emerald-300 text-base font-semibold rounded-xl text-emerald-700 bg-white hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-200 transition"
                                        >
                                            Cancel
                                        </Link>
                                        <button
                                            type="submit"
                                            :disabled="form.processing"
                                            class="inline-flex items-center px-8 py-3 border border-transparent text-base font-bold rounded-xl shadow-lg text-white transition transform hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-emerald-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                                            :class="form.processing
                                                ? 'bg-emerald-400'
                                                : 'bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700'"
                                        >
                                            <svg v-if="!form.processing" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                            {{ form.processing ? 'Posting Job...' : 'Post Job' }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Tips -->
                    <div class="mt-8 bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-100 rounded-2xl p-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 p-3 rounded-lg bg-emerald-100">
                                <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-emerald-800">Tips for a Great Job Posting</h3>
                                <ul class="mt-2 space-y-2 text-emerald-700">
                                    <li class="flex items-start">
                                        <svg class="w-4 h-4 text-emerald-500 mt-1 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        <span>Be clear about responsibilities and expectations</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-4 h-4 text-emerald-500 mt-1 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        <span>Include specific qualifications and experience needed</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-4 h-4 text-emerald-500 mt-1 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        <span>Set a realistic application deadline (2-4 weeks recommended)</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-4 h-4 text-emerald-500 mt-1 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        <span>Provide salary range to attract serious applicants</span>
                                    </li>
                                </ul>
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
import { Link, router, useForm } from '@inertiajs/vue3'
import { ref, computed } from 'vue'

const props = defineProps({
    subjects: Array
})

const minDate = ref(new Date().toISOString().split('T')[0])

const form = useForm({
    title: '',
    description: '',
    subject: '',
    level: '',
    class_grade: '',
    state: '',
    lga: '',
    employment_type: '',
    salary_range_min: '',
    salary_range_max: '',
    application_deadline: '',
})

const submitForm = () => {
    form.post(route('school.jobs.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
        }
    })
}

const formatSubjectName = (subject) => {
    return subject.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())
}
</script>
