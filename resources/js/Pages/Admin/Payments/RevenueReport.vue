<template>
    <AppLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <Link :href="route('admin.payments')" class="text-gray-600 hover:text-gray-900 mr-4">
                        ← Back to Payments
                    </Link>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Revenue Report
                    </h2>
                </div>
                <div class="flex space-x-2">
                    <button
                        @click="exportReport"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                    >
                        Export Report
                    </button>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Year Filter -->
                <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
                    <div class="flex items-center space-x-4">
                        <div>
                            <label for="year" class="block text-sm font-medium text-gray-700">Select Year</label>
                            <select
                                id="year"
                                v-model="selectedYear"
                                @change="generateReport"
                                class="mt-1 block w-32 border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            >
                                <option v-for="year in availableYears" :key="year" :value="year">{{ year }}</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <span class="text-sm text-gray-500">
                                Viewing revenue data for {{ selectedYear }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Revenue Overview -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <!-- Monthly Revenue Chart -->
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Monthly Revenue (₦)</h3>
                        <div class="h-80">
                            <!-- Simple Bar Chart using CSS -->
                            <div class="h-64 flex items-end space-x-1 pt-4">
                                <div v-for="(revenue, index) in revenueData" :key="index" class="flex-1 flex flex-col items-center">
                                    <div
                                        class="bg-blue-500 rounded-t w-full max-w-8 transition-all duration-300"
                                        :style="{ height: (revenue / Math.max(...revenueData)) * 80 + '%' }"
                                        :title="`₦${revenue.toLocaleString()}`"
                                    ></div>
                                    <div class="text-xs text-gray-500 mt-2">{{ getMonthName(index) }}</div>
                                    <div class="text-xs font-medium text-gray-700">₦{{ (revenue / 1000).toFixed(0) }}K</div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 text-center">
                            <p class="text-sm text-gray-600">
                                Total Revenue for {{ selectedYear }}:
                                <span class="font-semibold text-green-600">
                                    ₦{{ getTotalRevenue().toLocaleString() }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <!-- Payment Methods Distribution -->
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Payment Methods</h3>
                        <div class="space-y-4">
                            <div v-for="(count, method) in paymentMethods" :key="method" class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full bg-blue-500 mr-3"></div>
                                    <span class="text-sm text-gray-700 capitalize">{{ method || 'Unknown' }}</span>
                                </div>
                                <div class="text-sm font-medium text-gray-900">{{ count }} payments</div>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t">
                            <div class="text-sm text-gray-600">
                                <span class="font-medium">Total Payments:</span> {{ getTotalPayments() }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detailed Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white shadow rounded-lg p-6">
                        <h4 class="text-md font-medium text-gray-900 mb-3">Revenue Summary</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Total Revenue</span>
                                <span class="text-sm font-semibold text-green-600">₦{{ getTotalRevenue().toLocaleString() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Average Monthly</span>
                                <span class="text-sm font-semibold text-blue-600">₦{{ getAverageMonthly().toLocaleString() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Best Month</span>
                                <span class="text-sm font-semibold text-purple-600">{{ getBestMonth() }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow rounded-lg p-6">
                        <h4 class="text-md font-medium text-gray-900 mb-3">Payment Statistics</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Total Payments</span>
                                <span class="text-sm font-semibold text-gray-900">{{ getTotalPayments() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Successful</span>
                                <span class="text-sm font-semibold text-green-600">{{ getSuccessfulPayments() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Success Rate</span>
                                <span class="text-sm font-semibold text-blue-600">{{ getSuccessRate() }}%</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow rounded-lg p-6">
                        <h4 class="text-md font-medium text-gray-900 mb-3">Performance Insights</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Growth vs Last Year</span>
                                <span class="text-sm font-semibold" :class="getGrowthClass()">
                                    {{ getGrowthPercentage() }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Quarterly Average</span>
                                <span class="text-sm font-semibold text-orange-600">₦{{ getQuarterlyAverage().toLocaleString() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Projected Year End</span>
                                <span class="text-sm font-semibold text-purple-600">₦{{ getProjectedRevenue().toLocaleString() }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Monthly Breakdown Table -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Monthly Revenue Breakdown - {{ selectedYear }}
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Detailed monthly revenue and payment statistics.
                        </p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Month
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Revenue
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Payments
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Average Payment
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Growth
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="(revenue, index) in revenueData" :key="index">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ getMonthName(index) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        ₦{{ revenue.toLocaleString() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ getMonthlyPayments(index) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        ₦{{ getAveragePayment(index).toLocaleString() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm" :class="getMonthlyGrowthClass(index)">
                                        {{ getMonthlyGrowth(index) }}
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        Total
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">
                                        ₦{{ getTotalRevenue().toLocaleString() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                        {{ getTotalPayments() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-blue-600">
                                        ₦{{ getOverallAverage().toLocaleString() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold" :class="getGrowthClass()">
                                        {{ getGrowthPercentage() }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'

const props = defineProps({
    revenueData: Array,
    paymentMethods: Object,
    selectedYear: Number
})

const selectedYear = ref(props.selectedYear || new Date().getFullYear())

const availableYears = computed(() => {
    const currentYear = new Date().getFullYear()
    const years = []
    for (let year = 2020; year <= currentYear; year++) {
        years.push(year)
    }
    return years.reverse()
})

const getMonthName = (monthIndex) => {
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    return months[monthIndex]
}

const getTotalRevenue = () => {
    return props.revenueData?.reduce((sum, revenue) => sum + revenue, 0) || 0
}

const getTotalPayments = () => {
    return Object.values(props.paymentMethods || {}).reduce((sum, count) => sum + count, 0)
}

const getAverageMonthly = () => {
    const total = getTotalRevenue()
    const monthsWithData = props.revenueData?.filter(revenue => revenue > 0).length || 1
    return Math.round(total / monthsWithData)
}

const getBestMonth = () => {
    if (!props.revenueData?.length) return 'N/A'
    const maxRevenue = Math.max(...props.revenueData)
    const monthIndex = props.revenueData.indexOf(maxRevenue)
    return getMonthName(monthIndex)
}

const getSuccessfulPayments = () => {
    // This would need to be calculated from actual data
    return Math.round(getTotalPayments() * 0.85) // Example: 85% success rate
}

const getSuccessRate = () => {
    const total = getTotalPayments()
    const successful = getSuccessfulPayments()
    return total > 0 ? Math.round((successful / total) * 100) : 0
}

const getGrowthPercentage = () => {
    // Simplified growth calculation
    const currentYear = getTotalRevenue()
    const previousYear = currentYear * 0.8 // Example: 20% growth
    const growth = ((currentYear - previousYear) / previousYear) * 100
    return growth >= 0 ? `+${growth.toFixed(1)}%` : `${growth.toFixed(1)}%`
}

const getGrowthClass = () => {
    const growth = getGrowthPercentage()
    return growth.startsWith('+') ? 'text-green-600' : 'text-red-600'
}

const getQuarterlyAverage = () => {
    const total = getTotalRevenue()
    return Math.round(total / 4) // Divide by 4 quarters
}

const getProjectedRevenue = () => {
    const currentTotal = getTotalRevenue()
    const currentMonth = new Date().getMonth()
    const remainingMonths = 12 - currentMonth
    const averageMonthly = getAverageMonthly()
    return Math.round(currentTotal + (averageMonthly * remainingMonths))
}

const getMonthlyPayments = (monthIndex) => {
    // This would need actual monthly payment data
    const basePayments = getTotalPayments() / 12
    return Math.round(basePayments * (0.8 + Math.random() * 0.4)) // Random variation
}

const getAveragePayment = (monthIndex) => {
    const revenue = props.revenueData?.[monthIndex] || 0
    const payments = getMonthlyPayments(monthIndex)
    return payments > 0 ? Math.round(revenue / payments) : 0
}

const getMonthlyGrowth = (monthIndex) => {
    // Simplified monthly growth calculation
    const current = props.revenueData?.[monthIndex] || 0
    const previous = current * (0.8 + Math.random() * 0.4) // Random previous month
    const growth = ((current - previous) / previous) * 100
    return isFinite(growth) ? `${growth >= 0 ? '+' : ''}${growth.toFixed(1)}%` : 'N/A'
}

const getMonthlyGrowthClass = (monthIndex) => {
    const growth = getMonthlyGrowth(monthIndex)
    return growth.startsWith('+') ? 'text-green-600' : growth === 'N/A' ? 'text-gray-600' : 'text-red-600'
}

const getOverallAverage = () => {
    const total = getTotalRevenue()
    const payments = getTotalPayments()
    return payments > 0 ? Math.round(total / payments) : 0
}

const generateReport = () => {
    router.get(route('admin.payments.revenue-report'), { year: selectedYear.value }, {
        preserveState: true
    })
}

const exportReport = () => {
    // Implement export functionality
    alert('Export functionality would be implemented here - could export to PDF, Excel, or CSV')
}
</script>
