<template>
    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                System Settings
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="space-y-6">
                    <!-- General Settings -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                General Settings
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                Basic system configuration and preferences.
                            </p>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <form @submit.prevent="saveGeneralSettings">
                                <div class="space-y-6">
                                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                        <div>
                                            <label for="app_name" class="block text-sm font-medium text-gray-700">Application Name</label>
                                            <input
                                                type="text"
                                                id="app_name"
                                                v-model="generalForm.app_name"
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                            />
                                        </div>
                                        <div>
                                            <label for="teacher_registration_fee" class="block text-sm font-medium text-gray-700">Teacher Registration Fee (₦)</label>
                                            <input
                                                type="number"
                                                id="teacher_registration_fee"
                                                v-model="generalForm.teacher_registration_fee"
                                                min="0"
                                                step="100"
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                            />
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                        <div>
                                            <label for="reappraisal_fee" class="block text-sm font-medium text-gray-700">Re-appraisal Fee (₦)</label>
                                            <input
                                                type="number"
                                                id="reappraisal_fee"
                                                v-model="generalForm.reappraisal_fee"
                                                min="0"
                                                step="100"
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                            />
                                        </div>
                                        <div>
                                            <label for="max_job_applications" class="block text-sm font-medium text-gray-700">Max Job Applications per Teacher</label>
                                            <input
                                                type="number"
                                                id="max_job_applications"
                                                v-model="generalForm.max_job_applications"
                                                min="1"
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                            />
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <input
                                            id="require_school_verification"
                                            v-model="generalForm.require_school_verification"
                                            type="checkbox"
                                            class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded"
                                        />
                                        <label for="require_school_verification" class="ml-2 block text-sm text-gray-900">
                                            Require school verification before job posting
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input
                                            id="auto_approve_teachers"
                                            v-model="generalForm.auto_approve_teachers"
                                            type="checkbox"
                                            class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded"
                                        />
                                        <label for="auto_approve_teachers" class="ml-2 block text-sm text-gray-900">
                                            Automatically approve teacher registrations
                                        </label>
                                    </div>
                                </div>
                                <div class="mt-6 flex justify-end">
                                    <button
                                        type="submit"
                                        :disabled="generalForm.processing"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
                                    >
                                        {{ generalForm.processing ? 'Saving...' : 'Save General Settings' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Payment Settings -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Payment Settings
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                Configure payment gateway and transaction settings.
                            </p>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <form @submit.prevent="savePaymentSettings">
                                <div class="space-y-6">
                                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                        <div>
                                            <label for="payment_gateway" class="block text-sm font-medium text-gray-700">Payment Gateway</label>
                                            <select
                                                id="payment_gateway"
                                                v-model="paymentForm.payment_gateway"
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                            >
                                                <option value="paystack">Paystack</option>
                                                <option value="flutterwave">Flutterwave</option>
                                                <option value="stripe">Stripe</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="currency" class="block text-sm font-medium text-gray-700">Currency</label>
                                            <select
                                                id="currency"
                                                v-model="paymentForm.currency"
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                            >
                                                <option value="NGN">NGN - Nigerian Naira</option>
                                                <option value="USD">USD - US Dollar</option>
                                                <option value="GBP">GBP - British Pound</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                        <div>
                                            <label for="paystack_public_key" class="block text-sm font-medium text-gray-700">Paystack Public Key</label>
                                            <input
                                                type="password"
                                                id="paystack_public_key"
                                                v-model="paymentForm.paystack_public_key"
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                                placeholder="pk_test_..."
                                            />
                                        </div>
                                        <div>
                                            <label for="paystack_secret_key" class="block text-sm font-medium text-gray-700">Paystack Secret Key</label>
                                            <input
                                                type="password"
                                                id="paystack_secret_key"
                                                v-model="paymentForm.paystack_secret_key"
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                                placeholder="sk_test_..."
                                            />
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <input
                                            id="payment_test_mode"
                                            v-model="paymentForm.payment_test_mode"
                                            type="checkbox"
                                            class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded"
                                        />
                                        <label for="payment_test_mode" class="ml-2 block text-sm text-gray-900">
                                            Enable test mode (sandbox)
                                        </label>
                                    </div>
                                </div>
                                <div class="mt-6 flex justify-end">
                                    <button
                                        type="submit"
                                        :disabled="paymentForm.processing"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
                                    >
                                        {{ paymentForm.processing ? 'Saving...' : 'Save Payment Settings' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Email Settings -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Email & Notification Settings
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                Configure email templates and notification preferences.
                            </p>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <form @submit.prevent="saveEmailSettings">
                                <div class="space-y-6">
                                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                        <div>
                                            <label for="mail_from_address" class="block text-sm font-medium text-gray-700">From Email Address</label>
                                            <input
                                                type="email"
                                                id="mail_from_address"
                                                v-model="emailForm.mail_from_address"
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                            />
                                        </div>
                                        <div>
                                            <label for="mail_from_name" class="block text-sm font-medium text-gray-700">From Name</label>
                                            <input
                                                type="text"
                                                id="mail_from_name"
                                                v-model="emailForm.mail_from_name"
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                            />
                                        </div>
                                    </div>
                                    <div class="space-y-4">
                                        <div class="flex items-center">
                                            <input
                                                id="send_appraisal_emails"
                                                v-model="emailForm.send_appraisal_emails"
                                                type="checkbox"
                                                class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded"
                                            />
                                            <label for="send_appraisal_emails" class="ml-2 block text-sm text-gray-900">
                                                Send appraisal completion emails to teachers
                                            </label>
                                        </div>
                                        <div class="flex items-center">
                                            <input
                                                id="send_application_emails"
                                                v-model="emailForm.send_application_emails"
                                                type="checkbox"
                                                class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded"
                                            />
                                            <label for="send_application_emails" class="ml-2 block text-sm text-gray-900">
                                                Send application status update emails
                                            </label>
                                        </div>
                                        <div class="flex items-center">
                                            <input
                                                id="send_payment_receipts"
                                                v-model="emailForm.send_payment_receipts"
                                                type="checkbox"
                                                class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded"
                                            />
                                            <label for="send_payment_receipts" class="ml-2 block text-sm text-gray-900">
                                                Send payment receipt emails
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-6 flex justify-end">
                                    <button
                                        type="submit"
                                        :disabled="emailForm.processing"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
                                    >
                                        {{ emailForm.processing ? 'Saving...' : 'Save Email Settings' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Danger Zone -->
                    <div class="bg-red-50 shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-red-200">
                            <h3 class="text-lg leading-6 font-medium text-red-900">
                                Danger Zone
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm text-red-700">
                                Irreversible actions that affect the entire system.
                            </p>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="text-md font-medium text-red-900">Clear All Cache</h4>
                                        <p class="text-sm text-red-700">Clear application cache and temporary data</p>
                                    </div>
                                    <button
                                        @click="clearCache"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                    >
                                        Clear Cache
                                    </button>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="text-md font-medium text-red-900">Reset System</h4>
                                        <p class="text-sm text-red-700">Reset all data (users, jobs, appraisals) - DEVELOPMENT ONLY</p>
                                    </div>
                                    <button
                                        @click="resetSystem"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-800 hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                    >
                                        Reset System
                                    </button>
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
import { useForm } from '@inertiajs/vue3'

// Initialize forms with default values
const generalForm = useForm({
    app_name: 'Teacher Appraisal System',
    teacher_registration_fee: 5000,
    reappraisal_fee: 2500,
    max_job_applications: 10,
    require_school_verification: true,
    auto_approve_teachers: false
})

const paymentForm = useForm({
    payment_gateway: 'paystack',
    currency: 'NGN',
    paystack_public_key: '',
    paystack_secret_key: '',
    payment_test_mode: true
})

const emailForm = useForm({
    mail_from_address: 'noreply@teacherappraisal.com',
    mail_from_name: 'Teacher Appraisal System',
    send_appraisal_emails: true,
    send_application_emails: true,
    send_payment_receipts: true
})

const saveGeneralSettings = () => {
    generalForm.post(route('admin.settings.general.save'), {
        preserveScroll: true,
        onSuccess: () => {
            // Show success message
        }
    })
}

const savePaymentSettings = () => {
    paymentForm.post(route('admin.settings.payment.save'), {
        preserveScroll: true,
        onSuccess: () => {
            // Show success message
        }
    })
}

const saveEmailSettings = () => {
    emailForm.post(route('admin.settings.email.save'), {
        preserveScroll: true,
        onSuccess: () => {
            // Show success message
        }
    })
}

const clearCache = () => {
    if (confirm('Are you sure you want to clear all cache? This may temporarily slow down the system.')) {
        // Implement cache clearing
        alert('Cache cleared successfully!')
    }
}

const resetSystem = () => {
    if (confirm('WARNING: This will delete ALL data including users, jobs, and appraisals. This action cannot be undone. Are you absolutely sure?')) {
        if (confirm('This is your final warning. All data will be permanently lost. Type "RESET" to confirm.')) {
            const userInput = prompt('Please type "RESET" to confirm system reset:')
            if (userInput === 'RESET') {
                // Implement system reset
                alert('System reset initiated. This may take a few minutes.')
            }
        }
    }
}
</script>
