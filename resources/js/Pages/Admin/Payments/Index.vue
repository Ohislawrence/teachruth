<template>
    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Payments Management
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Stats -->
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-6 mb-6">
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Revenue</dt>
                            <dd class="mt-1 text-2xl font-semibold text-green-600">₦{{ stats.total_revenue?.toLocaleString() }}</dd>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Payments</dt>
                            <dd class="mt-1 text-2xl font-semibold text-gray-900">{{ stats.total_payments }}</dd>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Successful</dt>
                            <dd class="mt-1 text-2xl font-semibold text-green-600">{{ stats.successful_payments }}</dd>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Pending</dt>
                            <dd class="mt-1 text-2xl font-semibold text-yellow-600">{{ stats.pending_payments }}</dd>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Failed</dt>
                            <dd class="mt-1 text-2xl font-semibold text-red-600">{{ stats.failed_payments }}</dd>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Today's Revenue</dt>
                            <dd class="mt-1 text-2xl font-semibold text-blue-600">₦{{ stats.today_revenue?.toLocaleString() }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <!-- Search -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                            <input
                                type="text"
                                id="search"
                                v-model="filters.search"
                                placeholder="Reference, user name..."
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            />
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select
                                id="status"
                                v-model="filters.status"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            >
                                <option value="">All Status</option>
                                <option value="successful">Successful</option>
                                <option value="pending">Pending</option>
                                <option value="failed">Failed</option>
                            </select>
                        </div>

                        <!-- Date From -->
                        <div>
                            <label for="date_from" class="block text-sm font-medium text-gray-700">From Date</label>
                            <input
                                type="date"
                                id="date_from"
                                v-model="filters.date_from"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            />
                        </div>

                        <!-- Date To -->
                        <div>
                            <label for="date_to" class="block text-sm font-medium text-gray-700">To Date</label>
                            <input
                                type="date"
                                id="date_to"
                                v-model="filters.date_to"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            />
                        </div>

                        <!-- Actions -->
                        <div class="flex items-end space-x-2">
                            <button
                                @click="resetFilters"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            >
                                Reset
                            </button>
                            <Link
                                :href="route('admin.payments.revenue-report')"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            >
                                Revenue Report
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Payments List -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            All Payments
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Monitor and manage all payment transactions in the system.
                        </p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Reference
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        User
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Amount
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="payment in payments.data" :key="payment.id" class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-mono text-gray-900">{{ payment.payment_reference }}</div>
                                        <div class="text-xs text-gray-500">ID: {{ payment.id }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full" :src="payment.user?.profile_photo_url" :alt="payment.user?.name" />
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ payment.user?.name }}</div>
                                                <div class="text-sm text-gray-500">{{ payment.user?.email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">₦{{ payment.amount?.toLocaleString() }}</div>
                                        <div class="text-xs text-gray-500">{{ payment.currency }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                              :class="paymentStatusClass(payment.status)">
                                            {{ payment.status.toUpperCase() }}
                                        </span>
                                        <div v-if="payment.paid_at" class="text-xs text-gray-500 mt-1">
                                            Paid: {{ formatDate(payment.paid_at) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ formatDate(payment.created_at) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button
                                            @click="viewPaymentDetails(payment)"
                                            class="text-blue-600 hover:text-blue-900 mr-3"
                                        >
                                            View Details
                                        </button>
                                        <button
                                            v-if="payment.status === 'pending'"
                                            @click="verifyPayment(payment)"
                                            class="text-green-600 hover:text-green-900"
                                        >
                                            Verify
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div v-if="payments.links.length > 3" class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                        <div class="flex-1 flex justify-between sm:hidden">
                            <Link
                                :href="payments.prev_page_url"
                                :class="{'opacity-50 cursor-not-allowed': !payments.prev_page_url}"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                            >
                                Previous
                            </Link>
                            <Link
                                :href="payments.next_page_url"
                                :class="{'opacity-50 cursor-not-allowed': !payments.next_page_url}"
                                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                            >
                                Next
                            </Link>
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Showing
                                    <span class="font-medium">{{ payments.from }}</span>
                                    to
                                    <span class="font-medium">{{ payments.to }}</span>
                                    of
                                    <span class="font-medium">{{ payments.total }}</span>
                                    payments
                                </p>
                            </div>
                            <div>
                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                    <Link
                                        v-for="(link, index) in payments.links"
                                        :key="index"
                                        :href="link.url"
                                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                                        :class="{
                                            'bg-blue-50 border-blue-500 text-blue-600 z-10': link.active,
                                            'rounded-l-md': index === 0,
                                            'rounded-r-md': index === payments.links.length - 1
                                        }"
                                        v-html="link.label"
                                    ></Link>
                                </nav>
                            </div>
                        </div>
                    </div>

                    <!-- Empty State -->
                    <div v-if="payments.data.length === 0" class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No payments found</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            No payment transactions match your current filters.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Details Modal -->
        <div v-if="showPaymentModal" class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50">
            <div class="fixed inset-0 transform transition-all">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-2xl sm:w-full sm:mx-auto">
                <div class="px-6 py-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Payment Details</h3>
                        <button @click="closePaymentModal" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div v-if="selectedPayment" class="space-y-4">
                        <!-- Payment Information -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Reference</label>
                                <p class="text-sm font-mono text-gray-900">{{ selectedPayment.payment_reference }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Status</label>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                      :class="paymentStatusClass(selectedPayment.status)">
                                    {{ selectedPayment.status.toUpperCase() }}
                                </span>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Amount</label>
                                <p class="text-sm font-semibold text-gray-900">₦{{ selectedPayment.amount?.toLocaleString() }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Currency</label>
                                <p class="text-sm text-gray-900">{{ selectedPayment.currency }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Created</label>
                                <p class="text-sm text-gray-900">{{ formatDate(selectedPayment.created_at) }}</p>
                            </div>
                            <div v-if="selectedPayment.paid_at">
                                <label class="text-sm font-medium text-gray-500">Paid At</label>
                                <p class="text-sm text-gray-900">{{ formatDate(selectedPayment.paid_at) }}</p>
                            </div>
                        </div>

                        <!-- User Information -->
                        <div class="border-t pt-4">
                            <h4 class="text-md font-medium text-gray-900 mb-2">User Information</h4>
                            <div class="flex items-center space-x-3">
                                <img class="h-10 w-10 rounded-full" :src="selectedPayment.user?.profile_photo_url" :alt="selectedPayment.user?.name" />
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ selectedPayment.user?.name }}</p>
                                    <p class="text-sm text-gray-500">{{ selectedPayment.user?.email }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Gateway Response -->
                        <div v-if="selectedPayment.gateway_response" class="border-t pt-4">
                            <h4 class="text-md font-medium text-gray-900 mb-2">Gateway Response</h4>
                            <pre class="text-xs bg-gray-100 p-3 rounded overflow-auto max-h-32">{{ formatJSON(selectedPayment.gateway_response) }}</pre>
                        </div>

                        <!-- Metadata -->
                        <div v-if="selectedPayment.metadata" class="border-t pt-4">
                            <h4 class="text-md font-medium text-gray-900 mb-2">Metadata</h4>
                            <pre class="text-xs bg-gray-100 p-3 rounded overflow-auto max-h-32">{{ formatJSON(selectedPayment.metadata) }}</pre>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-3 flex justify-end">
                    <button
                        @click="closePaymentModal"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { ref, watch } from 'vue'
import { debounce } from 'lodash'

const props = defineProps({
    payments: Object,
    stats: Object,
    filters: Object
})

const filters = ref({
    search: props.filters.search || '',
    status: props.filters.status || '',
    date_from: props.filters.date_from || '',
    date_to: props.filters.date_to || ''
})

const showPaymentModal = ref(false)
const selectedPayment = ref(null)

// Watch filters with debounce
watch(filters, debounce((value) => {
    router.get(route('admin.payments'), value, {
        preserveState: true,
        replace: true
    })
}, 300), { deep: true })

const resetFilters = () => {
    filters.value = {
        search: '',
        status: '',
        date_from: '',
        date_to: ''
    }
}

const paymentStatusClass = (status) => {
    const classes = {
        'successful': 'bg-green-100 text-green-800',
        'pending': 'bg-yellow-100 text-yellow-800',
        'failed': 'bg-red-100 text-red-800'
    }
    return classes[status] || 'bg-gray-100 text-gray-800'
}

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    })
}

const formatJSON = (jsonString) => {
    try {
        const parsed = JSON.parse(jsonString)
        return JSON.stringify(parsed, null, 2)
    } catch {
        return jsonString
    }
}

const viewPaymentDetails = (payment) => {
    selectedPayment.value = payment
    showPaymentModal.value = true
}

const closePaymentModal = () => {
    showPaymentModal.value = false
    selectedPayment.value = null
}

const verifyPayment = (payment) => {
    if (confirm('Are you sure you want to manually verify this payment?')) {
        router.post(route('admin.payments.verify', payment.id), {}, {
            preserveScroll: true,
            onSuccess: () => {
                // Page will refresh with updated data
            }
        })
    }
}
</script>
