<template>
    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Qualifying Questions Settings
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Stats and Actions -->
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-4 mb-6">
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Questions</dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ questions.length }}</dd>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Active Questions</dt>
                            <dd class="mt-1 text-3xl font-semibold text-green-600">
                                {{ activeQuestionsCount }}
                            </dd>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Multiple Choice</dt>
                            <dd class="mt-1 text-3xl font-semibold text-blue-600">
                                {{ multipleChoiceCount }}
                            </dd>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="flex items-end justify-between px-4 py-5 sm:p-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 truncate">Actions</dt>
                                <dd class="mt-1">
                                    <button
                                        @click="openAddModal"
                                        class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                    >
                                        Add Question
                                    </button>
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Questions List -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Qualifying Questions
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Manage the questions that teachers answer during registration.
                        </p>
                    </div>

                    <ul class="divide-y divide-gray-200">
                        <li v-for="question in sortedQuestions" :key="question.id" class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                                {{ question.question }}
                                                <span v-if="!question.is_active" class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                                    Inactive
                                                </span>
                                            </h3>
                                            <div class="mt-1 flex items-center space-x-4 text-sm text-gray-500">
                                                <span class="flex items-center">
                                                    <svg class="h-4 w-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    {{ questionTypeLabel(question.type) }}
                                                </span>
                                                <span class="flex items-center">
                                                    <svg class="h-4 w-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                                                    </svg>
                                                    Order: {{ question.order }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Options Display -->
                                    <div v-if="question.options && question.options.length > 0" class="mt-3">
                                        <h4 class="text-sm font-medium text-gray-700 mb-2">Options:</h4>
                                        <div class="flex flex-wrap gap-2">
                                            <span v-for="(option, index) in question.options" :key="index"
                                                  class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ option }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="ml-4 flex-shrink-0 flex flex-col space-y-2">
                                    <button
                                        @click="openEditModal(question)"
                                        class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                    >
                                        Edit
                                    </button>
                                    <button
                                        @click="toggleQuestionStatus(question)"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                        :class="question.is_active ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700'"
                                    >
                                        {{ question.is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                    <button
                                        @click="deleteQuestion(question)"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <!-- Empty State -->
                    <div v-if="questions.length === 0" class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No questions configured</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Get started by creating your first qualifying question.
                        </p>
                        <div class="mt-6">
                            <button
                                @click="openAddModal"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            >
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add First Question
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add/Edit Question Modal -->
        <div v-if="showQuestionModal" class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50">
            <div class="fixed inset-0 transform transition-all">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-2xl sm:w-full sm:mx-auto">
                <div class="px-6 py-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">
                            {{ isEditing ? 'Edit Question' : 'Add New Question' }}
                        </h3>
                        <button @click="closeQuestionModal" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form @submit.prevent="saveQuestion">
                        <div class="space-y-4">
                            <!-- Question Text -->
                            <div>
                                <label for="question" class="block text-sm font-medium text-gray-700">Question Text</label>
                                <textarea
                                    id="question"
                                    v-model="questionForm.question"
                                    rows="3"
                                    required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    placeholder="Enter the question that teachers will answer..."
                                ></textarea>
                            </div>

                            <!-- Question Type -->
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700">Question Type</label>
                                <select
                                    id="type"
                                    v-model="questionForm.type"
                                    required
                                    @change="handleTypeChange"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                >
                                    <option value="">Select Type</option>
                                    <option value="multiple_choice">Multiple Choice</option>
                                    <option value="text">Text Answer</option>
                                    <option value="boolean">Yes/No (Boolean)</option>
                                </select>
                            </div>

                            <!-- Options (for multiple choice) -->
                            <div v-if="questionForm.type === 'multiple_choice'">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Options</label>
                                <div class="space-y-2">
                                    <div v-for="(option, index) in questionForm.options" :key="index" class="flex items-center space-x-2">
                                        <input
                                            type="text"
                                            v-model="questionForm.options[index]"
                                            required
                                            class="flex-1 border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                            placeholder="Enter option..."
                                        />
                                        <button
                                            type="button"
                                            @click="removeOption(index)"
                                            class="inline-flex items-center p-2 border border-transparent rounded-md text-red-600 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                        >
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <button
                                        type="button"
                                        @click="addOption"
                                        class="inline-flex items-center px-3 py-1 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                    >
                                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Add Option
                                    </button>
                                </div>
                            </div>

                            <!-- Order -->
                            <div>
                                <label for="order" class="block text-sm font-medium text-gray-700">Display Order</label>
                                <input
                                    type="number"
                                    id="order"
                                    v-model="questionForm.order"
                                    required
                                    min="0"
                                    class="mt-1 block w-32 border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                />
                                <p class="mt-1 text-sm text-gray-500">Lower numbers appear first</p>
                            </div>

                            <!-- Active Status -->
                            <div class="flex items-center">
                                <input
                                    id="is_active"
                                    v-model="questionForm.is_active"
                                    type="checkbox"
                                    class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded"
                                />
                                <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                    Active (visible to teachers during registration)
                                </label>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <button
                                type="button"
                                @click="closeQuestionModal"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                :disabled="questionForm.processing"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
                            >
                                {{ questionForm.processing ? 'Saving...' : (isEditing ? 'Update Question' : 'Create Question') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { router, useForm } from '@inertiajs/vue3'
import { ref, computed } from 'vue'

const props = defineProps({
    questions: Array
})

const showQuestionModal = ref(false)
const isEditing = ref(false)
const selectedQuestion = ref(null)

const questionForm = useForm({
    question: '',
    type: '',
    options: [],
    order: 0,
    is_active: true
})

const activeQuestionsCount = computed(() => {
    return props.questions.filter(q => q.is_active).length
})

const multipleChoiceCount = computed(() => {
    return props.questions.filter(q => q.type === 'multiple_choice').length
})

const sortedQuestions = computed(() => {
    return [...props.questions].sort((a, b) => a.order - b.order)
})

const questionTypeLabel = (type) => {
    const labels = {
        'multiple_choice': 'Multiple Choice',
        'text': 'Text Answer',
        'boolean': 'Yes/No'
    }
    return labels[type] || type
}

const openAddModal = () => {
    isEditing.value = false
    selectedQuestion.value = null
    questionForm.reset()
    questionForm.order = props.questions.length > 0 ? Math.max(...props.questions.map(q => q.order)) + 1 : 1
    showQuestionModal.value = true
}

const openEditModal = (question) => {
    isEditing.value = true
    selectedQuestion.value = question
    questionForm.question = question.question
    questionForm.type = question.type
    questionForm.options = question.options ? [...question.options] : []
    questionForm.order = question.order
    questionForm.is_active = question.is_active
    showQuestionModal.value = true
}

const closeQuestionModal = () => {
    showQuestionModal.value = false
    selectedQuestion.value = null
    questionForm.reset()
}

const handleTypeChange = () => {
    if (questionForm.type === 'multiple_choice' && questionForm.options.length === 0) {
        questionForm.options = ['']
    } else if (questionForm.type !== 'multiple_choice') {
        questionForm.options = []
    }
}

const addOption = () => {
    questionForm.options.push('')
}

const removeOption = (index) => {
    questionForm.options.splice(index, 1)
}

const saveQuestion = () => {
    if (isEditing.value && selectedQuestion.value) {
        questionForm.put(route('admin.settings.questions.update', selectedQuestion.value.id), {
            preserveScroll: true,
            onSuccess: () => {
                closeQuestionModal()
            }
        })
    } else {
        questionForm.post(route('admin.settings.questions.store'), {
            preserveScroll: true,
            onSuccess: () => {
                closeQuestionModal()
            }
        })
    }
}

const toggleQuestionStatus = (question) => {
    const action = question.is_active ? 'deactivate' : 'activate'
    if (confirm(`Are you sure you want to ${action} this question?`)) {
        router.post(route('admin.settings.questions.toggle', question.id), {}, {
            preserveScroll: true,
            onSuccess: () => {
                // Page will refresh with updated data
            }
        })
    }
}

const deleteQuestion = (question) => {
    if (confirm('Are you sure you want to delete this question? This action cannot be undone.')) {
        router.delete(route('admin.settings.questions.destroy', question.id), {
            preserveScroll: true,
            onSuccess: () => {
                // Page will refresh with updated data
            }
        })
    }
}
</script>
