<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref, onMounted } from 'vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

// Animation state
const loaded = ref(false);
onMounted(() => {
    setTimeout(() => {
        loaded.value = true;
    }, 100);
});
</script>

<template>
    <Head title="Log in to Teachergauge" />

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
            <div class="w-full max-w-md space-y-8">
                <!-- Logo and Title -->
                <div class="text-center" :class="{ 'animate-fade-in-up': loaded }">
                    <div class="flex justify-center mb-6">
                        <div class="relative">
                            <div class="absolute -top-1 -right-1 w-4 h-4 bg-gradient-to-r from-emerald-400 to-teal-500 rounded-full animate-pulse"></div>
                        </div>
                    </div>

                    <h2 class="text-3xl font-bold bg-gradient-to-r from-emerald-700 to-teal-800 bg-clip-text text-transparent">
                        Welcome Back
                    </h2>
                    <p class="mt-2 text-gray-600">
                        Sign in to access your Teachergauge dashboard
                    </p>
                </div>

                <!-- Success Message -->
                <div v-if="status" class="rounded-xl bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200 p-4" :class="{ 'animate-fade-in-up': loaded }">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-emerald-800">{{ status }}</p>
                        </div>
                    </div>
                </div>

                <!-- Login Card -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-emerald-100/50 p-8" :class="{ 'animate-fade-in-up': loaded }">
                    <form @submit.prevent="submit" class="space-y-6">
                        <!-- Email Input -->
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
                                    placeholder="you@example.com"
                                    required
                                    autofocus
                                    autocomplete="username"
                                />
                            </div>
                            <InputError class="mt-1 text-sm" :message="form.errors.email" />
                        </div>

                        <!-- Password Input -->
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <InputLabel for="password" value="Password" class="text-sm font-semibold text-gray-700" />
                                <Link
                                    v-if="canResetPassword"
                                    :href="route('password.request')"
                                    class="text-sm font-medium text-emerald-600 hover:text-emerald-700 transition-colors"
                                >
                                    Forgot password?
                                </Link>
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <TextInput
                                    id="password"
                                    v-model="form.password"
                                    type="password"
                                    class="pl-10 w-full rounded-xl border-emerald-200 focus:border-emerald-500 focus:ring-emerald-500/20 transition"
                                    placeholder="••••••••"
                                    required
                                    autocomplete="current-password"
                                />
                            </div>
                            <InputError class="mt-1 text-sm" :message="form.errors.password" />
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center">
                            <Checkbox
                                v-model:checked="form.remember"
                                name="remember"
                                class="rounded border-emerald-300 text-emerald-600 focus:ring-emerald-500/20"
                            />
                            <span class="ml-2 text-sm text-gray-600">Keep me signed in</span>
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <PrimaryButton
                                class="w-full justify-center py-3 px-4 rounded-xl text-base font-semibold shadow-lg shadow-emerald-200/50 hover:shadow-emerald-300/50 transition-all duration-300 transform hover:-translate-y-0.5"
                                :class="{ 'opacity-25': form.processing, 'from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700': !form.processing }"
                                :disabled="form.processing"
                            >
                                <span v-if="!form.processing" class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg>
                                    Sign In
                                </span>
                                <span v-else class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Signing In...
                                </span>
                            </PrimaryButton>
                        </div>


                    </form>

                    <!-- Divider -->
                    <div class="relative my-8">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-emerald-100"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white text-gray-500">New to Teachergauge?</span>
                        </div>
                    </div>

                    <!-- Sign Up Links -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <Link
                            :href="route('teacher.register.step1')"
                            class="group flex items-center justify-center px-4 py-3 border border-emerald-200 rounded-xl text-sm font-semibold text-emerald-700 bg-white hover:bg-emerald-50 hover:border-emerald-300 transition-all duration-300"
                        >
                            <svg class="w-4 h-4 mr-2 text-emerald-600 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Join as Teacher
                        </Link>
                        <Link
                            :href="route('school.register.step1')"
                            class="group flex items-center justify-center px-4 py-3 border border-teal-200 rounded-xl text-sm font-semibold text-teal-700 bg-white hover:bg-teal-50 hover:border-teal-300 transition-all duration-300"
                        >
                            <svg class="w-4 h-4 mr-2 text-teal-600 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Join as School
                        </Link>
                    </div>

                    <!-- Terms & Privacy -->
                    <p class="mt-8 text-center text-xs text-gray-500">
                        By signing in, you agree to our
                        <Link :href="route('terms.show')" class="text-emerald-600 hover:text-emerald-700 font-medium">Terms</Link>
                        and
                        <Link :href="route('policy.show')" class="text-emerald-600 hover:text-emerald-700 font-medium">Privacy Policy</Link>
                    </p>
                </div>

                <!-- Copyright -->
                <p class="text-center text-sm text-gray-500" :class="{ 'animate-fade-in-up': loaded }">
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
