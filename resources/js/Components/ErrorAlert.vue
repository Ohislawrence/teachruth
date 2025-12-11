<template>
    <div v-if="hasErrors" class="mb-6">
        <div class="bg-red-50 border border-red-200 rounded-xl p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.856-.833-2.464 0L4.154 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800" v-if="title">{{ title }}</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <slot>
                            <ul class="list-disc pl-5 space-y-1">
                                <li v-for="(error, field) in errors" :key="field">{{ error }}</li>
                            </ul>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    errors: {
        type: Object,
        default: () => ({})
    },
    title: {
        type: String,
        default: 'There were errors with your submission'
    }
})

const hasErrors = computed(() => {
    return Object.keys(props.errors).length > 0
})
</script>
