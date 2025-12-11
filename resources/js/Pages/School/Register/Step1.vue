<template>
    <div class="min-h-screen bg-gradient-to-b from-emerald-50 via-teal-50 to-white py-12">
        <div class="max-w-md mx-auto">
            <!-- Error Alert -->
            <div v-if="$page.props.flash.error" class="mb-6">
                <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.856-.833-2.464 0L4.154 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">{{ $page.props.flash.error }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-2xl rounded-2xl border border-emerald-100 overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-8 text-center">
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-white">School Registration</h1>
                    <p class="text-emerald-100 mt-2">Create your school account in minutes</p>
                </div>

                <form @submit.prevent="validateAndSubmit" class="p-6 space-y-6">
                    <!-- School Name -->
                    <div>
                        <label for="school_name" class="block text-sm font-semibold text-emerald-700 mb-2">
                            School Name
                        </label>
                        <input
                            type="text"
                            id="school_name"
                            v-model="form.school_name"
                            required
                            class="w-full px-4 py-3 border-2 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                            :class="getInputClass('school_name')"
                            placeholder="Enter school name"
                            @input="clearError('school_name')"
                        />
                        <p v-if="showError('school_name')" class="text-red-500 text-sm mt-1">
                            {{ getError('school_name') }}
                        </p>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-emerald-700 mb-2">
                            Email Address
                        </label>
                        <input
                            type="email"
                            id="email"
                            v-model="form.email"
                            required
                            class="w-full px-4 py-3 border-2 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                            :class="getInputClass('email')"
                            placeholder="school@example.com"
                            @input="clearError('email')"
                        />
                        <p v-if="showError('email')" class="text-red-500 text-sm mt-1">
                            {{ getError('email') }}
                        </p>
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-emerald-700 mb-2">
                            Phone Number
                        </label>
                        <input
                            type="tel"
                            id="phone"
                            v-model="form.phone"
                            required
                            class="w-full px-4 py-3 border-2 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                            :class="getInputClass('phone')"
                            placeholder="08012345678"
                            @input="clearError('phone')"
                        />
                        <p v-if="showError('phone')" class="text-red-500 text-sm mt-1">
                            {{ getError('phone') }}
                        </p>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-emerald-700 mb-2">
                            Password
                        </label>
                        <input
                            type="password"
                            id="password"
                            v-model="form.password"
                            required
                            class="w-full px-4 py-3 border-2 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                            :class="getInputClass('password')"
                            placeholder="Create a strong password (min. 8 characters)"
                            @input="clearError('password'); validatePasswordMatch()"
                        />
                        <p v-if="showError('password')" class="text-red-500 text-sm mt-1">
                            {{ getError('password') }}
                        </p>
                        <div v-if="form.password && !showError('password')" class="mt-2 space-y-1">
                            <div class="flex items-center">
                                <div class="w-2 h-2 rounded-full mr-2" :class="passwordStrength >= 1 ? 'bg-emerald-500' : 'bg-gray-300'"></div>
                                <span class="text-xs" :class="passwordStrength >= 1 ? 'text-emerald-700' : 'text-gray-500'">
                                    At least 8 characters {{ form.password.length >= 8 ? '✓' : '' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-emerald-700 mb-2">
                            Confirm Password
                        </label>
                        <input
                            type="password"
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            required
                            class="w-full px-4 py-3 border-2 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                            :class="getInputClass('password_confirmation')"
                            placeholder="Confirm your password"
                            @input="clearError('password_confirmation'); validatePasswordMatch()"
                        />
                        <p v-if="showError('password_confirmation')" class="text-red-500 text-sm mt-1">
                            {{ getError('password_confirmation') }}
                        </p>
                        <div v-if="form.password && form.password_confirmation && !showError('password_confirmation')">
                            <p v-if="passwordsMatch" class="text-green-500 text-sm mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Passwords match
                            </p>
                            <p v-else class="text-red-500 text-sm mt-1">
                                Passwords do not match
                            </p>
                        </div>
                    </div>

                    <!-- Server Validation Errors -->
                    <div v-if="Object.keys($page.props.errors).length > 0" class="bg-red-50 border border-red-200 rounded-xl p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.856-.833-2.464 0L4.154 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">There were errors with your submission</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        <li v-for="(error, field) in serverErrors" :key="field">{{ error }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button
                            type="submit"
                            :disabled="processing || !isFormValid"
                            class="w-full py-3 px-4 border border-transparent rounded-xl shadow-lg text-white font-bold text-lg transition transform hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-emerald-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                            :class="processing || !isFormValid
                                ? 'bg-emerald-400'
                                : 'bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700'"
                        >
                            {{ processing ? 'Creating Account...' : 'Create School Account' }}
                        </button>
                    </div>

                    <div class="text-center pt-4 border-t border-emerald-100">
                        <p class="text-sm text-gray-600">
                            Already have an account?
                            <Link :href="route('login')" class="font-semibold text-emerald-600 hover:text-emerald-700">
                                Sign in here
                            </Link>
                        </p>
                    </div>
                </form>
            </div>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Are you a teacher?
                    <Link :href="route('teacher.register.step1')" class="font-semibold text-emerald-600 hover:text-emerald-700">
                        Register as Teacher
                    </Link>
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, router, useForm } from '@inertiajs/vue3'
import { ref, computed, watch } from 'vue'

const processing = ref(false)
const clientErrors = ref({})
const passwordsMatch = ref(true)

// Use the correct field names for Laravel's confirmed rule
const form = useForm({
    school_name: '',
    email: '',
    phone: '',
    password: '',
    password_confirmation: '', // Changed from confirm_password
})

// Computed properties
const passwordStrength = computed(() => {
    if (!form.password) return 0
    let strength = 0
    if (form.password.length >= 8) strength++
    // Add more strength checks if needed
    if (/[A-Z]/.test(form.password)) strength++
    if (/[0-9]/.test(form.password)) strength++
    if (/[^A-Za-z0-9]/.test(form.password)) strength++
    return strength
})

const serverErrors = computed(() => {
    return window.$page?.props?.errors || {}
})

const isFormValid = computed(() => {
    const hasErrors = Object.keys(clientErrors.value).length > 0
    const hasServerErrors = Object.keys(serverErrors.value).length > 0

    return form.school_name &&
           form.email &&
           form.phone &&
           form.password &&
           form.password_confirmation &&
           passwordsMatch.value &&
           form.password.length >= 8 &&
           !hasErrors &&
           !hasServerErrors
})

// Watch for server errors and map them to client errors
watch(() => form.errors, (newErrors) => {
    for (const [field, error] of Object.entries(newErrors)) {
        // Map password_confirmation error to client-side
        if (field === 'password' && error.includes('confirmation')) {
            clientErrors.value.password_confirmation = 'Passwords do not match'
        } else {
            clientErrors.value[field] = error
        }
    }
}, { deep: true })

// Watch for page errors
watch(() => serverErrors.value, (newErrors) => {
    if (newErrors) {
        for (const [field, error] of Object.entries(newErrors)) {
            // Map password_confirmation error to client-side
            if (field === 'password' && error.includes('confirmation')) {
                clientErrors.value.password_confirmation = 'Passwords do not match'
            } else {
                clientErrors.value[field] = error
            }
        }
    }
}, { deep: true })

// Helper methods
const getInputClass = (field) => {
    if (clientErrors.value[field] || form.errors[field]) {
        return 'border-red-300'
    }
    return 'border-emerald-100'
}

const showError = (field) => {
    return clientErrors.value[field] || form.errors[field]
}

const getError = (field) => {
    return clientErrors.value[field] || form.errors[field]
}

const clearError = (field) => {
    if (clientErrors.value[field]) {
        delete clientErrors.value[field]
    }
}

const validatePasswordMatch = () => {
    if (form.password && form.password_confirmation) {
        if (form.password !== form.password_confirmation) {
            clientErrors.value.password_confirmation = 'Passwords do not match'
            passwordsMatch.value = false
        } else {
            delete clientErrors.value.password_confirmation
            passwordsMatch.value = true
        }
    }
}

const validateForm = () => {
    clientErrors.value = {}

    // Validate required fields
    if (!form.school_name.trim()) {
        clientErrors.value.school_name = 'School name is required'
    }

    if (!form.email.trim()) {
        clientErrors.value.email = 'Email is required'
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email)) {
        clientErrors.value.email = 'Please enter a valid email address'
    }

    if (!form.phone.trim()) {
        clientErrors.value.phone = 'Phone number is required'
    } else if (!/^[0-9+\-\s()]{10,20}$/.test(form.phone)) {
        clientErrors.value.phone = 'Please enter a valid phone number'
    }

    if (!form.password) {
        clientErrors.value.password = 'Password is required'
    } else if (form.password.length < 8) {
        clientErrors.value.password = 'Password must be at least 8 characters'
    }

    if (!form.password_confirmation) {
        clientErrors.value.password_confirmation = 'Please confirm your password'
    } else if (form.password !== form.password_confirmation) {
        clientErrors.value.password_confirmation = 'Passwords do not match'
    }

    return Object.keys(clientErrors.value).length === 0
}

const validateAndSubmit = () => {
    // Clear previous errors
    clientErrors.value = {}

    // Client-side validation
    if (!validateForm()) {
        return
    }

    // Server-side submission
    processing.value = true

    // Prepare data for submission
    const submitData = {
        school_name: form.school_name,
        email: form.email,
        phone: form.phone,
        password: form.password,
        password_confirmation: form.password_confirmation,
    }

    console.log('Submitting data:', submitData) // Debug log

    form.post(route('school.register.storeStep1'), {
        data: submitData,
        preserveState: true,
        preserveScroll: true,
        onFinish: () => {
            processing.value = false
        },
        onError: (errors) => {
            console.log('Registration errors:', errors)
            // Handle password confirmation error mapping
            if (errors.password && errors.password.includes('confirmation')) {
                clientErrors.value.password_confirmation = 'Passwords do not match'
            }
        }
    })
}
</script>
