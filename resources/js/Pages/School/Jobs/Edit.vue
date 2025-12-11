<template>
    <AppLayout title="Edit Job">
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
                                    <h1 class="text-xl font-bold text-white">Edit Job</h1>
                                    <p class="text-xs text-emerald-100">Update teaching position details</p>
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
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h2 class="text-3xl font-bold text-gray-900">Edit Teaching Position</h2>
                                <p class="text-emerald-700 mt-2">Update the details of your job posting</p>
                            </div>
                            <div class="mt-4 sm:mt-0">
                                <Link
                                    :href="route('school.jobs.applicants', job.id)"
                                    class="inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-bold rounded-xl shadow-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition transform hover:-translate-y-0.5"
                                >
                                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    View Applicants ({{ job.applications_count }})
                                </Link>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow-2xl rounded-2xl border border-emerald-100 overflow-hidden">
                        <form @submit.prevent="submitForm" class="p-6 space-y-8">
                            <!-- Job Status -->
                            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl border border-emerald-100">
                                <div class="flex items-center">
                                    <div class="p-3 rounded-lg bg-emerald-100 mr-4">
                                        <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-emerald-600">Job Status</p>
                                        <p class="text-lg font-semibold text-gray-900">
                                            {{ job.is_active ? 'Active' : 'Inactive' }}
                                            <span class="text-sm font-normal text-gray-600 ml-2">
                                                ({{ getDaysLeft(job.application_deadline) }} days until deadline)
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" v-model="form.is_active" class="sr-only peer">
                                    <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-emerald-600"></div>
                                    <span class="ml-3 text-sm font-medium text-gray-900">{{ form.is_active ? 'Active' : 'Inactive' }}</span>
                                </label>
                            </div>

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

                            <!-- Danger Zone -->
                            <div v-if="job.applications_count === 0">
                                <h3 class="text-xl font-bold text-red-800 mb-6 pb-2 border-b border-red-100">
                                    <svg class="w-5 h-5 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.856-.833-2.464 0L4.154 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                    </svg>
                                    Danger Zone
                                </h3>

                                <div class="bg-red-50 border border-red-100 rounded-xl p-6">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-lg font-semibold text-red-800">Delete Job Posting</h4>
                                            <p class="text-red-600 mt-1">
                                                Once you delete this job posting, there is no going back. Please be certain.
                                            </p>
                                        </div>
                                        <button
                                            type="button"
                                            @click="deleteJob"
                                            class="inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-bold rounded-xl shadow-lg text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 transition"
                                        >
                                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Delete Job
                                        </button>
                                    </div>
                                </div>
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
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            {{ form.processing ? 'Updating...' : 'Update Job' }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
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
    job: Object,
    subjects: Array
})

const minDate = ref(new Date().toISOString().split('T')[0])

const form = useForm({
    title: props.job.title,
    description: props.job.description,
    subject: props.job.subject,
    level: props.job.level,
    class_grade: props.job.class_grade || '',
    state: props.job.state,
    lga: props.job.lga,
    employment_type: props.job.employment_type,
    salary_range_min: props.job.salary_range_min || '',
    salary_range_max: props.job.salary_range_max || '',
    application_deadline: props.job.application_deadline.split('T')[0],
    is_active: props.job.is_active,
})

const submitForm = () => {
    form.put(route('school.jobs.update', props.job.id), {
        preserveScroll: true,
    })
}

const deleteJob = () => {
    if (confirm('Are you sure you want to delete this job posting? This action cannot be undone.')) {
        if (props.job.applications_count > 0) {
            alert('Cannot delete job with existing applications. Please deactivate it instead.')
            return
        }

        router.delete(route('school.jobs.delete', props.job.id), {
            preserveScroll: true,
            onSuccess: () => {
                router.visit(route('school.jobs'))
            }
        })
    }
}

const formatSubjectName = (subject) => {
    return subject.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())
}

const getDaysLeft = (deadline) => {
    const deadlineDate = new Date(deadline)
    const today = new Date()
    const diffTime = deadlineDate - today
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24))
    return Math.max(0, diffDays)
}
</script>
