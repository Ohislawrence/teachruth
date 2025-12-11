<template>
    <div v-if="show" class="mb-6">
        <div class="bg-green-50 border border-green-200 rounded-xl p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ message }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button
                            type="button"
                            @click="$emit('dismiss')"
                            class="inline-flex rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-green-50"
                        >
                            <span class="sr-only">Dismiss</span>
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    message: {
        type: String,
        default: ''
    },
    flashKey: {
        type: String,
        default: 'success'
    }
})

const emit = defineEmits(['dismiss'])

const show = computed(() => {
    return props.message || (window.$page?.props?.flash && window.$page.props.flash[props.flashKey])
})

const successMessage = computed(() => {
    return props.message || (window.$page?.props?.flash && window.$page.props.flash[props.flashKey]) || ''
})
</script>
