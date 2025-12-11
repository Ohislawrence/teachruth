<template>
    <AppLayout title="School Profile">
        <div class="min-h-screen bg-gradient-to-b from-emerald-50 via-teal-50 to-white">
            <!-- Navigation -->
            <nav class="bg-gradient-to-r from-emerald-600 to-teal-600 shadow-lg">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <div class="flex items-center space-x-3">
                                <Link :href="route('school.dashboard')" class="text-white hover:text-emerald-100 transition">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                </Link>
                                <div>
                                    <h1 class="text-xl font-bold text-white">School Profile</h1>
                                    <p class="text-xs text-emerald-100">Manage your school information</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <Link
                                :href="route('school.dashboard')"
                                class="text-sm font-medium text-white hover:text-emerald-100 transition"
                            >
                                Dashboard
                            </Link>
                            <Link
                                :href="route('school.jobs')"
                                class="text-sm font-medium text-white hover:text-emerald-100 transition"
                            >
                                My Jobs
                            </Link>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="py-8">
                <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                    <!-- Header -->
                    <div class="mb-8">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h2 class="text-3xl font-bold text-gray-900">School Profile</h2>
                                <p class="text-emerald-700 mt-2">Update your school information and settings</p>
                            </div>
                            <div class="mt-4 sm:mt-0">
                                <div class="flex items-center space-x-2">
                                    <span class="px-3 py-1 rounded-full text-sm font-bold"
                                          :class="profile.is_verified ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'">
                                        {{ profile.is_verified ? '✓ Verified' : 'Not Verified' }}
                                    </span>
                                    <span class="text-sm text-gray-600">
                                        Last updated {{ formatRelativeTime(profile.updated_at) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Success Message -->
                    <div v-if="$page.props.flash.success" class="mb-8">
                        <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800">{{ $page.props.flash.success }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Error Message -->
                    <div v-if="Object.keys(form.errors).length > 0" class="mb-8">
                        <div class="bg-red-50 border border-red-200 rounded-xl p-4">
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
                                            <li v-for="error in form.errors" :key="error">{{ error }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Left Column - Profile Form -->
                        <div class="lg:col-span-2">
                            <div class="bg-white shadow-2xl rounded-2xl border border-emerald-100 overflow-hidden">
                                <form @submit.prevent="submitForm">
                                    <!-- Basic Information -->
                                    <div class="p-6 border-b border-emerald-100">
                                        <h3 class="text-xl font-bold text-emerald-800 mb-6 flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            Basic Information
                                        </h3>

                                        <div class="space-y-6">
                                            <!-- School Name -->
                                            <div>
                                                <label for="school_name" class="block text-sm font-semibold text-emerald-700 mb-2">
                                                    <span class="text-red-500">*</span> School Name
                                                </label>
                                                <input
                                                    type="text"
                                                    id="school_name"
                                                    v-model="form.school_name"
                                                    required
                                                    class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                                                    placeholder="Enter your school name"
                                                    :class="form.errors.school_name ? 'border-red-300' : ''"
                                                />
                                                <p v-if="form.errors.school_name" class="text-red-500 text-sm mt-1">{{ form.errors.school_name }}</p>
                                            </div>

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
                                                    placeholder="Tell teachers about your school, mission, values, achievements..."
                                                    :class="form.errors.about ? 'border-red-300' : ''"
                                                ></textarea>
                                                <p v-if="form.errors.about" class="text-red-500 text-sm mt-1">{{ form.errors.about }}</p>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    This description appears on your job postings and helps attract quality teachers.
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Contact Information -->
                                    <div class="p-6 border-b border-emerald-100">
                                        <h3 class="text-xl font-bold text-emerald-800 mb-6 flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            Contact Information
                                        </h3>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <!-- Phone -->
                                            <div>
                                                <label for="phone" class="block text-sm font-semibold text-emerald-700 mb-2">
                                                    <span class="text-red-500">*</span> Phone Number
                                                </label>
                                                <input
                                                    type="tel"
                                                    id="phone"
                                                    v-model="form.phone"
                                                    required
                                                    class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                                                    placeholder="08012345678"
                                                    :class="form.errors.phone ? 'border-red-300' : ''"
                                                />
                                                <p v-if="form.errors.phone" class="text-red-500 text-sm mt-1">{{ form.errors.phone }}</p>
                                            </div>

                                            <!-- Website -->
                                            <div>
                                                <label for="website" class="block text-sm font-semibold text-emerald-700 mb-2">
                                                    Website (Optional)
                                                </label>
                                                <input
                                                    type="url"
                                                    id="website"
                                                    v-model="form.website"
                                                    class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                                                    placeholder="https://example.com"
                                                    :class="form.errors.website ? 'border-red-300' : ''"
                                                />
                                                <p v-if="form.errors.website" class="text-red-500 text-sm mt-1">{{ form.errors.website }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Location Details -->
                                    <div class="p-6 border-b border-emerald-100">
                                        <h3 class="text-xl font-bold text-emerald-800 mb-6 flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            Location Details
                                        </h3>

                                        <div class="space-y-6">
                                            <!-- Address -->
                                            <div>
                                                <label for="address" class="block text-sm font-semibold text-emerald-700 mb-2">
                                                    <span class="text-red-500">*</span> Full Address
                                                </label>
                                                <textarea
                                                    id="address"
                                                    v-model="form.address"
                                                    required
                                                    rows="3"
                                                    class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                                                    placeholder="School building address"
                                                    :class="form.errors.address ? 'border-red-300' : ''"
                                                ></textarea>
                                                <p v-if="form.errors.address" class="text-red-500 text-sm mt-1">{{ form.errors.address }}</p>
                                            </div>

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                <!-- State -->
                                                <div>
                                                    <label for="state" class="block text-sm font-semibold text-emerald-700 mb-2">
                                                        <span class="text-red-500">*</span> State
                                                    </label>
                                                    <select
                                                        id="state"
                                                        v-model="form.state"
                                                        required
                                                        class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition bg-white"
                                                        :class="form.errors.state ? 'border-red-300' : ''"
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
                                                    <p v-if="form.errors.state" class="text-red-500 text-sm mt-1">{{ form.errors.state }}</p>
                                                </div>

                                                <!-- LGA -->
                                                <div>
                                                    <label for="lga" class="block text-sm font-semibold text-emerald-700 mb-2">
                                                        <span class="text-red-500">*</span> Local Government Area (LGA)
                                                    </label>
                                                    <input
                                                        type="text"
                                                        id="lga"
                                                        v-model="form.lga"
                                                        required
                                                        class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition"
                                                        placeholder="Enter LGA"
                                                        :class="form.errors.lga ? 'border-red-300' : ''"
                                                    />
                                                    <p v-if="form.errors.lga" class="text-red-500 text-sm mt-1">{{ form.errors.lga }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- School Classification -->
                                    <div class="p-6 border-b border-emerald-100">
                                        <h3 class="text-xl font-bold text-emerald-800 mb-6 flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                            </svg>
                                            School Classification
                                        </h3>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <!-- School Type -->
                                            <div>
                                                <label for="school_type" class="block text-sm font-semibold text-emerald-700 mb-2">
                                                    <span class="text-red-500">*</span> School Type
                                                </label>
                                                <select
                                                    id="school_type"
                                                    v-model="form.school_type"
                                                    required
                                                    class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition bg-white"
                                                    :class="form.errors.school_type ? 'border-red-300' : ''"
                                                >
                                                    <option value="">Select School Type</option>
                                                    <option value="nursery">Nursery/Preschool</option>
                                                    <option value="primary">Primary School</option>
                                                    <option value="secondary">Secondary School</option>
                                                    <option value="mixed">Mixed (Primary & Secondary)</option>
                                                </select>
                                                <p v-if="form.errors.school_type" class="text-red-500 text-sm mt-1">{{ form.errors.school_type }}</p>
                                            </div>

                                            <!-- Ownership -->
                                            <div>
                                                <label for="ownership" class="block text-sm font-semibold text-emerald-700 mb-2">
                                                    <span class="text-red-500">*</span> Ownership Type
                                                </label>
                                                <select
                                                    id="ownership"
                                                    v-model="form.ownership"
                                                    required
                                                    class="w-full px-4 py-3 border-2 border-emerald-100 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none transition bg-white"
                                                    :class="form.errors.ownership ? 'border-red-300' : ''"
                                                >
                                                    <option value="">Select Ownership</option>
                                                    <option value="private">Private</option>
                                                    <option value="public">Public/Government</option>
                                                    <option value="mission">Mission/Religious</option>
                                                    <option value="community">Community-Owned</option>
                                                </select>
                                                <p v-if="form.errors.ownership" class="text-red-500 text-sm mt-1">{{ form.errors.ownership }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Logo Upload -->
                                    <div class="p-6">
                                        <h3 class="text-xl font-bold text-emerald-800 mb-6 flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            School Logo
                                        </h3>

                                        <div class="space-y-6">
                                            <!-- Current Logo Preview -->
                                            <div v-if="currentLogoUrl" class="mb-4">
                                                <p class="text-sm font-semibold text-emerald-700 mb-3">Current Logo</p>
                                                <div class="flex items-center space-x-6">
                                                    <div class="w-32 h-32 rounded-xl border-2 border-emerald-200 bg-white p-2">
                                                        <img :src="currentLogoUrl" alt="School Logo" class="w-full h-full object-contain rounded-lg">
                                                    </div>
                                                    <div>
                                                        <button
                                                            type="button"
                                                            @click="removeLogo"
                                                            class="inline-flex items-center px-4 py-2 border border-red-300 text-sm font-semibold rounded-xl text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-200 transition"
                                                        >
                                                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                            Remove Logo
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Logo Upload -->
                                            <div>
                                                <label class="block text-sm font-semibold text-emerald-700 mb-2">
                                                    Upload New Logo
                                                </label>
                                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-emerald-100 border-dashed rounded-xl hover:border-emerald-300 transition"
                                                     :class="form.errors.logo ? 'border-red-300' : ''"
                                                     @dragover.prevent="dragOver = true"
                                                     @dragleave="dragOver = false"
                                                     @drop.prevent="handleLogoDrop">
                                                    <div class="space-y-1 text-center">
                                                        <svg class="mx-auto h-12 w-12 text-emerald-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                        <div class="flex text-sm text-gray-600">
                                                            <label for="logo" class="relative cursor-pointer bg-white rounded-md font-medium text-emerald-600 hover:text-emerald-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-emerald-500">
                                                                <span>Upload a file</span>
                                                                <input
                                                                    id="logo"
                                                                    type="file"
                                                                    class="sr-only"
                                                                    @change="handleLogoUpload"
                                                                    accept="image/*"
                                                                />
                                                            </label>
                                                            <p class="pl-1">or drag and drop</p>
                                                        </div>
                                                        <p class="text-xs text-gray-500">
                                                            PNG, JPG, GIF up to 2MB
                                                        </p>
                                                    </div>
                                                </div>
                                                <p v-if="form.errors.logo" class="text-red-500 text-sm mt-1">{{ form.errors.logo }}</p>

                                                <!-- Preview of selected logo -->
                                                <div v-if="logoPreview" class="mt-4">
                                                    <p class="text-sm font-semibold text-emerald-700 mb-2">New Logo Preview</p>
                                                    <div class="w-32 h-32 rounded-xl border-2 border-emerald-200 bg-white p-2">
                                                        <img :src="logoPreview" alt="Logo Preview" class="w-full h-full object-contain rounded-lg">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Form Actions -->
                                    <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-6 border-t border-emerald-100">
                                        <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                                            <div>
                                                <p class="text-sm text-gray-600">
                                                    All fields marked with <span class="text-red-500">*</span> are required
                                                </p>
                                            </div>
                                            <div class="flex space-x-4">
                                                <Link
                                                    :href="route('school.dashboard')"
                                                    class="inline-flex items-center px-6 py-3 border-2 border-emerald-300 text-base font-semibold rounded-xl text-emerald-700 bg-white hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-200 transition"
                                                >
                                                    Cancel
                                                </Link>
                                                <button
                                                    type="submit"
                                                    :disabled="form.processing"
                                                    class="inline-flex items-center px-8 py-3 border border-transparent text-base font-bold rounded-xl shadow-lg text-white transition transform hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-emerald-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                                                    :class="form.processing
                                                        ? 'bg-emerald-400'
                                                        : 'bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700'"
                                                >
                                                    <svg v-if="!form.processing" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    {{ form.processing ? 'Saving Changes...' : 'Save Changes' }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Right Column - Profile Preview & Help -->
                        <div class="space-y-8">
                            <!-- Profile Preview -->
                            <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 overflow-hidden">
                                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 sm:px-8">
                                    <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Profile Preview
                                    </h3>
                                </div>
                                <div class="p-6">
                                    <div class="text-center">
                                        <!-- Logo Preview -->
                                        <div class="mb-6">
                                            <div class="w-24 h-24 rounded-xl border-2 border-emerald-200 bg-white p-2 mx-auto">
                                                <div v-if="logoPreview || currentLogoUrl" class="w-full h-full">
                                                    <img :src="logoPreview || currentLogoUrl" alt="School Logo" class="w-full h-full object-contain rounded-lg">
                                                </div>
                                                <div v-else class="w-full h-full rounded-lg bg-emerald-100 flex items-center justify-center">
                                                    <svg class="w-10 h-10 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- School Name -->
                                        <h4 class="text-xl font-bold text-gray-900 mb-2">{{ form.school_name || profile.school_name }}</h4>

                                        <!-- School Type & Ownership -->
                                        <div class="flex items-center justify-center space-x-2 mb-4">
                                            <span class="px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full text-xs font-semibold">
                                                {{ formatSchoolType(form.school_type || profile.school_type) }}
                                            </span>
                                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold capitalize">
                                                {{ form.ownership || profile.ownership }}
                                            </span>
                                        </div>

                                        <!-- Location -->
                                        <div class="text-sm text-gray-600 mb-4">
                                            <div class="flex items-center justify-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                <span>{{ form.state || profile.state }}, {{ form.lga || profile.lga }}</span>
                                            </div>
                                        </div>

                                        <!-- About Preview -->
                                        <div class="mt-6 pt-6 border-t border-emerald-100">
                                            <h5 class="text-sm font-semibold text-emerald-700 mb-2">About Preview</h5>
                                            <div class="text-sm text-gray-700 bg-gray-50 rounded-lg p-3 max-h-40 overflow-y-auto">
                                                {{ form.about || profile.about || 'No description yet. Add a description to attract teachers.' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Verification Status -->
                            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 shadow-xl rounded-2xl border border-emerald-100 overflow-hidden">
                                <div class="px-6 py-4 sm:px-8">
                                    <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                        Verification Status
                                    </h3>
                                </div>
                                <div class="px-6 py-6 sm:px-8 bg-white/50">
                                    <div v-if="profile.is_verified" class="text-center">
                                        <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4">
                                            <svg class="w-8 h-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <h4 class="text-lg font-bold text-green-800 mb-2">Verified School</h4>
                                        <p class="text-sm text-green-700 mb-4">
                                            Your school has been verified and trusted by our platform.
                                        </p>
                                        <div class="bg-green-100 border border-green-200 rounded-xl p-3">
                                            <p class="text-sm font-medium text-green-800">✓ Higher visibility in search</p>
                                            <p class="text-sm font-medium text-green-800 mt-1">✓ More teacher applications</p>
                                            <p class="text-sm font-medium text-green-800 mt-1">✓ Trusted by teachers</p>
                                        </div>
                                    </div>
                                    <div v-else class="text-center">
                                        <div class="w-16 h-16 rounded-full bg-yellow-100 flex items-center justify-center mx-auto mb-4">
                                            <svg class="w-8 h-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.856-.833-2.464 0L4.154 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                            </svg>
                                        </div>
                                        <h4 class="text-lg font-bold text-yellow-800 mb-2">Not Verified</h4>
                                        <p class="text-sm text-yellow-700 mb-4">
                                            Complete your profile and request verification for increased trust.
                                        </p>
                                        <div class="bg-yellow-100 border border-yellow-200 rounded-xl p-3 mb-4">
                                            <p class="text-sm font-medium text-yellow-800">To get verified:</p>
                                            <ul class="text-sm text-yellow-700 mt-2 space-y-1 text-left pl-5">
                                                <li>• Complete all profile information</li>
                                                <li>• Add your school logo</li>
                                                <li>• Provide accurate contact details</li>
                                                <li>• Contact admin for verification</li>
                                            </ul>
                                        </div>
                                        <a href="mailto:admin@teachingplatform.com"
                                           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-semibold rounded-xl text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-300 transition">
                                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            Request Verification
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Profile Tips -->
                            <div class="bg-white shadow-xl rounded-2xl border border-emerald-100 overflow-hidden">
                                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 sm:px-8">
                                    <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Profile Tips
                                    </h3>
                                </div>
                                <div class="p-6 space-y-4">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 mt-1">
                                            <div class="w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-emerald-800">Complete Profile</p>
                                            <p class="text-sm text-emerald-700 mt-1">
                                                Schools with complete profiles receive 40% more applications.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 mt-1">
                                            <div class="w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-emerald-800">Professional Logo</p>
                                            <p class="text-sm text-emerald-700 mt-1">
                                                Schools with logos appear more professional and trustworthy.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 mt-1">
                                            <div class="w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-emerald-800">Detailed Description</p>
                                            <p class="text-sm text-emerald-700 mt-1">
                                                Share your school's mission, values, and achievements to attract quality teachers.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="pt-4 border-t border-emerald-100">
                                        <p class="text-sm text-gray-600">
                                            Your profile information appears on all job postings and helps teachers learn about your school.
                                        </p>
                                    </div>
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
import { Link, useForm } from '@inertiajs/vue3'
import { ref, computed } from 'vue'

const props = defineProps({
    profile: Object
})

const dragOver = ref(false)
const logoPreview = ref(null)

const currentLogoUrl = computed(() => {
    return props.profile.logo_url
})

const form = useForm({
    school_name: props.profile.school_name,
    about: props.profile.about || '',
    phone: props.profile.phone,
    website: props.profile.website || '',
    address: props.profile.address,
    state: props.profile.state,
    lga: props.profile.lga,
    school_type: props.profile.school_type,
    ownership: props.profile.ownership,
    logo: null,
})

const handleLogoUpload = (event) => {
    const file = event.target.files[0]
    if (file) {
        // Validate file size (2MB max)
        if (file.size > 2 * 1024 * 1024) {
            alert('File size must be less than 2MB')
            return
        }

        // Validate file type
        if (!file.type.match('image.*')) {
            alert('Please select an image file')
            return
        }

        form.logo = file

        // Create preview
        const reader = new FileReader()
        reader.onload = (e) => {
            logoPreview.value = e.target.result
        }
        reader.readAsDataURL(file)
    }
}

const handleLogoDrop = (event) => {
    dragOver.value = false
    const file = event.dataTransfer.files[0]
    if (file) {
        // Create a fake input event to reuse the upload logic
        const fakeEvent = {
            target: {
                files: [file]
            }
        }
        handleLogoUpload(fakeEvent)
    }
}

const removeLogo = () => {
    // Create a hidden input to trigger logo removal
    form.logo = null
    logoPreview.value = null

    // In a real implementation, you might want to send a special value
    // to indicate logo removal. For now, we'll just clear the preview.
}

const submitForm = () => {
    // Convert form data to FormData for file upload
    const formData = new FormData()

    // Append all form fields
    Object.keys(form.data()).forEach(key => {
        if (form[key] !== null && form[key] !== undefined) {
            formData.append(key, form[key])
        }
    })

    form.post(route('school.profile.update'), {
        preserveScroll: true,
        onSuccess: () => {
            // Reset logo preview after successful save
            if (!form.logo) {
                logoPreview.value = null
            }
        }
    })
}

const formatRelativeTime = (dateString) => {
    const date = new Date(dateString)
    const now = new Date()
    const diffInSeconds = Math.floor((now - date) / 1000)

    if (diffInSeconds < 60) return 'Just now'
    if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)} minutes ago`
    if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)} hours ago`
    if (diffInSeconds < 604800) return `${Math.floor(diffInSeconds / 86400)} days ago`

    return date.toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric'
    })
}

const formatSchoolType = (type) => {
    const types = {
        'nursery': 'Nursery/Preschool',
        'primary': 'Primary School',
        'secondary': 'Secondary School',
        'mixed': 'Mixed (Primary & Secondary)'
    }
    return types[type] || type.charAt(0).toUpperCase() + type.slice(1)
}
</script>
