<template>
    <div class="min-h-screen bg-gradient-to-b from-emerald-50 via-teal-50 to-white py-12">
        <div class="max-w-2xl mx-auto">
            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold">
                            1
                        </div>
                        <span class="ml-2 text-sm font-medium text-emerald-700">Account Created</span>
                    </div>
                    <div class="h-1 flex-1 mx-4 bg-emerald-200"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold">
                            2
                        </div>
                        <span class="ml-2 text-sm font-medium text-emerald-700">School Details</span>
                    </div>
                    <div class="h-1 flex-1 mx-4 bg-emerald-200"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-400 border-2 border-emerald-200 flex items-center justify-center font-bold">
                            3
                        </div>
                        <span class="ml-2 text-sm font-medium text-gray-500">Complete</span>
                    </div>
                </div>
                <p class="text-center text-emerald-600 text-sm">Step 2 of 3: School Information</p>
            </div>

            <div class="bg-white shadow-2xl rounded-2xl border border-emerald-100 overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-8 text-center border-b border-emerald-100">
                    <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900">School Information</h1>
                    <p class="text-emerald-700 mt-2">Tell us more about your school</p>
                </div>

                <form @submit.prevent="submitForm" class="p-6 space-y-6">
                    <!-- About School -->
                    <div>
                        <label for="about" class="block text-sm font-semibold text-emerald-700 mb-2">
                            About Your School
                        </label>
                        <textarea
                            id="about"
                            v-model="form.about"
                            rows="4"
                            class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                            placeholder="Brief description of your school, mission, values, etc."
                        ></textarea>
                        <p class="text-xs text-gray-500 mt-1">Optional - You can update this later</p>
                    </div>

                    <!-- Address Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="address" class="block text-sm font-semibold text-emerald-700 mb-2">
                                Full Address
                            </label>
                            <input
                                type="text"
                                id="address"
                                v-model="form.address"
                                required
                                class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                                placeholder="School building address"
                            />
                        </div>

                        <div>
                            <label for="state" class="block text-sm font-semibold text-emerald-700 mb-2">
                                State
                            </label>
                            <select
                                id="state"
                                v-model="form.state"
                                required
                                class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition bg-white"
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
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="lga" class="block text-sm font-semibold text-emerald-700 mb-2">
                                Local Government Area (LGA)
                            </label>
                            <input
                                type="text"
                                id="lga"
                                v-model="form.lga"
                                required
                                class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                                placeholder="Local Government Area"
                            />
                        </div>

                        <div>
                            <label for="website" class="block text-sm font-semibold text-emerald-700 mb-2">
                                School Website
                            </label>
                            <input
                                type="url"
                                id="website"
                                v-model="form.website"
                                class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                                placeholder="https://example.com"
                            />
                            <p class="text-xs text-gray-500 mt-1">Optional</p>
                        </div>
                    </div>

                    <!-- School Type and Ownership -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="school_type" class="block text-sm font-semibold text-emerald-700 mb-2">
                                School Type
                            </label>
                            <select
                                id="school_type"
                                v-model="form.school_type"
                                required
                                class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition bg-white"
                            >
                                <option value="">Select School Type</option>
                                <option value="nursery">Nursery/Preschool</option>
                                <option value="primary">Primary School</option>
                                <option value="secondary">Secondary School</option>
                                <option value="mixed">Mixed (Primary & Secondary)</option>
                            </select>
                        </div>

                        <div>
                            <label for="ownership" class="block text-sm font-semibold text-emerald-700 mb-2">
                                Ownership Type
                            </label>
                            <select
                                id="ownership"
                                v-model="form.ownership"
                                required
                                class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition bg-white"
                            >
                                <option value="">Select Ownership</option>
                                <option value="private">Private</option>
                                <option value="public">Public/Government</option>
                                <option value="mission">Mission/Religious</option>
                                <option value="community">Community-Owned</option>
                            </select>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-emerald-100">
                        <div class="flex justify-between">
                            <Link
                                :href="route('school.register.step1')"
                                class="inline-flex items-center px-6 py-3 border-2 border-emerald-300 text-base font-semibold rounded-xl text-emerald-700 bg-white hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-200 transition"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Back
                            </Link>

                            <button
                                type="submit"
                                :disabled="processing"
                                class="inline-flex items-center px-8 py-3 border border-transparent rounded-xl shadow-lg text-white font-bold text-lg transition transform hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-emerald-300"
                                :class="processing
                                    ? 'bg-emerald-400'
                                    : 'bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700'"
                            >
                                {{ processing ? 'Saving...' : 'Continue to Next Step' }}
                                <svg v-if="!processing" class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="text-center pt-4">
                        <p class="text-sm text-gray-600">
                            You can skip optional fields and update them later in your profile.
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, router, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const processing = ref(false)

const form = useForm({
    about: '',
    address: '',
    state: '',
    lga: '',
    website: '',
    school_type: '',
    ownership: '',
})

const submitForm = () => {
    processing.value = true
    form.post(route('school.register.storeStep2'), {
        onFinish: () => {
            processing.value = false
        }
    })
}
</script>
