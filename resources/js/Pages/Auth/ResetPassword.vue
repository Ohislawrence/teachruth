<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref, onMounted } from 'vue';

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.update'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

// Animation state
const loaded = ref(false);
onMounted(() => {
    setTimeout(() => {
        loaded.value = true;
    }, 100);
});

// Password strength indicator
const passwordStrength = ref(0);
const updatePasswordStrength = (password) => {
    let strength = 0;
    if (password.length >= 8) strength += 25;
    if (/[A-Z]/.test(password)) strength += 25;
    if (/[0-9]/.test(password)) strength += 25;
    if (/[^A-Za-z0-9]/.test(password)) strength += 25;
    passwordStrength.value = strength;
};
</script>

<template>
    <Head title="Reset Password | Teachergauge" />

    <div class="min-h-screen bg-gradient-to-br from-emerald-50 via-teal-50/30 to-white">
        <!-- Background decorative elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-1/4 -left-1/4 w-96 h-96 bg-gradient-to-br from-emerald-200/20 to-teal-300/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-1/4 -right-1/4 w-96 h-96 bg-gradient-to-tr from-teal-200/20 to-emerald-300/10 rounded-full blur-3xl"></div>
        </div>

        <!-- Back to Home link -->
        <div class="absolute top-6 left-6 z-10">
            <Link
                :href="route('welcome')"
                class="inline-flex items-center text-sm font-medium text-emerald-700 hover:text-emerald-800 group transition-colors"
            >
                <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Home
            </Link>
        </div>

        <div class="relative min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="w-full max-w-md">
                <!-- Logo and Title -->
                <div class="text-center mb-8" :class="{ 'animate-fade-in-up': loaded }">
                    <div class="flex justify-center mb-6">
                        <div class="relative">
                            <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-200/50">
                                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                </svg>
                            </div>
                            <div class="absolute -top-1 -right-1 w-4 h-4 bg-gradient-to-r from-emerald-400 to-teal-500 rounded-full animate-pulse"></div>
                        </div>
                    </div>

                    <h2 class="text-3xl font-bold bg-gradient-to-r from-emerald-700 to-teal-800 bg-clip-text text-transparent">
                        Reset Password
                    </h2>
                    <p class="mt-2 text-gray-600">
                        Create a new secure password for your Teachergauge account
                    </p>
                </div>

                <!-- Reset Password Card -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-emerald-100/50 p-8" :class="{ 'animate-fade-in-up': loaded }">
                    <form @submit.prevent="submit" class="space-y-6">
                        <!-- Email Input (read-only if provided) -->
                        <div class="space-y-2">
                            <InputLabel for="email" value="Email Address" class="text-sm font-semibold text-gray-700" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <TextInput
                                    id="email"
                                    v-model="form.email"
                                    type="email"
                                    class="pl-10 w-full rounded-xl border-emerald-200 focus:border-emerald-500 focus:ring-emerald-500/20 transition"
                                    :class="{ 'bg-emerald-50/50 cursor-not-allowed': email }"
                                    :readonly="!!email"
                                    required
                                    autofocus
                                    autocomplete="username"
                                />
                            </div>
                            <InputError class="mt-1 text-sm" :message="form.errors.email" />
                        </div>

                        <!-- New Password Input -->
                        <div class="space-y-2">
                            <InputLabel for="password" value="New Password" class="text-sm font-semibold text-gray-700" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <TextInput
                                    id="password"
                                    v-model="form.password"
                                    @input="updatePasswordStrength(form.password)"
                                    type="password"
                                    class="pl-10 w-full rounded-xl border-emerald-200 focus:border-emerald-500 focus:ring-emerald-500/20 transition"
                                    placeholder="Enter your new password"
                                    required
                                    autocomplete="new-password"
                                />
                            </div>

                            <!-- Password Strength Indicator -->
                            <div v-if="form.password" class="mt-3">
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-gray-600">Password strength</span>
                                    <span class="font-medium" :class="{
                                        'text-red-500': passwordStrength < 50,
                                        'text-amber-500': passwordStrength >= 50 && passwordStrength < 75,
                                        'text-emerald-500': passwordStrength >= 75
                                    }">
                                        {{ passwordStrength < 50 ? 'Weak' : passwordStrength < 75 ? 'Good' : 'Strong' }}
                                    </span>
                                </div>
                                <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full transition-all duration-300" :style="{ width: passwordStrength + '%' }" :class="{
                                        'bg-red-400': passwordStrength < 50,
                                        'bg-amber-400': passwordStrength >= 50 && passwordStrength < 75,
                                        'bg-emerald-500': passwordStrength >= 75
                                    }"></div>
                                </div>
                            </div>

                            <!-- Password Requirements -->
                            <div class="mt-3 space-y-1">
                                <p class="text-xs text-gray-600 font-medium">Password must contain:</p>
                                <ul class="text-xs text-gray-500 space-y-1">
                                    <li class="flex items-center" :class="{ 'text-emerald-600': form.password.length >= 8 }">
                                        <svg class="w-3 h-3 mr-2" :class="{ 'text-emerald-500': form.password.length >= 8, 'text-gray-300': form.password.length < 8 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="form.password.length >= 8 ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12'" />
                                        </svg>
                                        At least 8 characters
                                    </li>
                                    <li class="flex items-center" :class="{ 'text-emerald-600': /[A-Z]/.test(form.password) }">
                                        <svg class="w-3 h-3 mr-2" :class="{ 'text-emerald-500': /[A-Z]/.test(form.password), 'text-gray-300': !/[A-Z]/.test(form.password) }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="/[A-Z]/.test(form.password) ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12'" />
                                        </svg>
                                        One uppercase letter
                                    </li>
                                    <li class="flex items-center" :class="{ 'text-emerald-600': /[0-9]/.test(form.password) }">
                                        <svg class="w-3 h-3 mr-2" :class="{ 'text-emerald-500': /[0-9]/.test(form.password), 'text-gray-300': !/[0-9]/.test(form.password) }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="/[0-9]/.test(form.password) ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12'" />
                                        </svg>
                                        One number
                                    </li>
                                    <li class="flex items-center" :class="{ 'text-emerald-600': /[^A-Za-z0-9]/.test(form.password) }">
                                        <svg class="w-3 h-3 mr-2" :class="{ 'text-emerald-500': /[^A-Za-z0-9]/.test(form.password), 'text-gray-300': !/[^A-Za-z0-9]/.test(form.password) }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="/[^A-Za-z0-9]/.test(form.password) ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12'" />
                                        </svg>
                                        One special character
                                    </li>
                                </ul>
                            </div>

                            <InputError class="mt-1 text-sm" :message="form.errors.password" />
                        </div>

                        <!-- Confirm Password Input -->
                        <div class="space-y-2">
                            <InputLabel for="password_confirmation" value="Confirm New Password" class="text-sm font-semibold text-gray-700" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <TextInput
                                    id="password_confirmation"
                                    v-model="form.password_confirmation"
                                    type="password"
                                    class="pl-10 w-full rounded-xl border-emerald-200 focus:border-emerald-500 focus:ring-emerald-500/20 transition"
                                    placeholder="Confirm your new password"
                                    required
                                    autocomplete="new-password"
                                />
                            </div>
                            <!-- Password Match Indicator -->
                            <div v-if="form.password_confirmation" class="mt-2">
                                <div class="flex items-center text-xs" :class="{ 'text-emerald-600': form.password === form.password_confirmation, 'text-red-500': form.password !== form.password_confirmation }">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="form.password === form.password_confirmation ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12'" />
                                    </svg>
                                    {{ form.password === form.password_confirmation ? 'Passwords match' : 'Passwords do not match' }}
                                </div>
                            </div>
                            <InputError class="mt-1 text-sm" :message="form.errors.password_confirmation" />
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <PrimaryButton
                                class="w-full justify-center py-3 px-4 rounded-xl text-base font-semibold shadow-lg shadow-emerald-200/50 hover:shadow-emerald-300/50 transition-all duration-300 transform hover:-translate-y-0.5"
                                :class="{
                                    'opacity-25': form.processing,
                                    'from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700': !form.processing,
                                    'cursor-not-allowed': form.password !== form.password_confirmation || form.password.length < 8
                                }"
                                :disabled="form.processing || form.password !== form.password_confirmation || form.password.length < 8"
                            >
                                <span v-if="!form.processing" class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    Reset Password
                                </span>
                                <span v-else class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Resetting Password...
                                </span>
                            </PrimaryButton>
                        </div>

                        <!-- Security Notice -->
                        <div class="rounded-xl bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-100 p-4 mt-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-emerald-800">Security First</p>
                                    <p class="text-xs text-emerald-700 mt-1">
                                        Choose a strong, unique password to protect your account. We recommend using a password manager.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Back to Login -->
                    <div class="mt-8 pt-6 border-t border-emerald-100 text-center">
                        <p class="text-sm text-gray-600">
                            Remembered your password?
                            <Link :href="route('login')" class="font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">
                                Return to login
                            </Link>
                        </p>
                    </div>
                </div>

                <!-- Copyright -->
                <p class="text-center text-sm text-gray-500 mt-8" :class="{ 'animate-fade-in-up': loaded }">
                    &copy; {{ new Date().getFullYear() }} Teachergauge. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</template>

<style scoped>
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
    animation: fade-in-up 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards;
}

/* Smooth focus states */
:deep(input:focus) {
    outline: none;
    ring-width: 2px;
}

/* Custom checkbox styling */
:deep([type='checkbox']:checked) {
    background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/%3e%3c/svg%3e");
    border-color: transparent;
    background-color: currentColor;
    background-size: 100% 100%;
    background-position: center;
    background-repeat: no-repeat;
}
</style>
