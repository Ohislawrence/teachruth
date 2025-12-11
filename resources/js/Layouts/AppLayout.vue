<script setup>
import { ref, computed, watch } from 'vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);
const page = usePage();
const flash = computed(() => page.props.flash || {});

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logout'));
};

// Check user type using computed properties
const isAdmin = computed(() => {
    return page.props.auth.user.type === 'admin';
});

const isTeacher = computed(() => {
    return page.props.auth.user.type === 'teacher';
});

const isSchool = computed(() => {
    return page.props.auth.user.type === 'school';
});

// Get user for template usage
const user = computed(() => page.props.auth.user);
const jetstream = computed(() => page.props.jetstream);

// Watch for flash messages and auto-dismiss them
watch(() => flash.value, (newFlash) => {
    if (newFlash.error || newFlash.success) {
        setTimeout(() => {
            router.reload({ only: ['flash'] });
        }, 5000);
    }
}, { deep: true });
</script>

<template>
    <div>
        <Head :title="title" />

        <Banner />

        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationMark class="block h-9 w-auto" />
                                </Link>
                            </div>
                        </div>

                        <!-- Navigation Links - Right Side -->
                        <div class="hidden sm:flex sm:items-center sm:space-x-4">
                            <!-- Teacher Navigation -->
                            <template v-if="isTeacher">
                                <NavLink :href="route('teacher.dashboard')" :active="route().current('teacher.dashboard')">
                                    Dashboard
                                </NavLink>
                                <NavLink :href="route('teacher.jobs')" :active="route().current('teacher.jobs')">
                                    Jobs
                                </NavLink>
                                <NavLink :href="route('teacher.applications')" :active="route().current('teacher.applications')">
                                    Applications
                                </NavLink>

                                <!-- Teacher Dropdown -->
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                            My Profile
                                            <svg class="ms-1 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('teacher.profile')">
                                            Edit Profile
                                        </DropdownLink>
                                        <DropdownLink :href="route('teacher.appraisals')">
                                            My Appraisals
                                        </DropdownLink>
                                        <DropdownLink :href="route('teacher.reappraise')">
                                            New Appraisal
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </template>

                            <!-- Admin Navigation -->
                            <template v-else-if="isAdmin">
                                <NavLink :href="route('admin.dashboard')" :active="route().current('admin.dashboard')">
                                    Dashboard
                                </NavLink>

                                <!-- Users Dropdown -->
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                            Users
                                            <svg class="ms-1 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('admin.teachers')">
                                            Teachers
                                        </DropdownLink>
                                        <DropdownLink :href="route('admin.schools')">
                                            Schools
                                        </DropdownLink>
                                    </template>
                                </Dropdown>

                                <!-- Jobs Dropdown -->
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                            Jobs
                                            <svg class="ms-1 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('admin.jobs')">
                                            All Jobs
                                        </DropdownLink>
                                        <DropdownLink :href="route('admin.applications')">
                                            Applications
                                        </DropdownLink>
                                    </template>
                                </Dropdown>

                                <!-- Appraisals Dropdown -->
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                            Appraisals
                                            <svg class="ms-1 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('admin.appraisals')">
                                            All Appraisals
                                        </DropdownLink>
                                        <DropdownLink :href="route('admin.appraisals.report')">
                                            Reports
                                        </DropdownLink>
                                    </template>
                                </Dropdown>

                                <!-- Payments Dropdown -->
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                            Payments
                                            <svg class="ms-1 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('admin.payments')">
                                            All Payments
                                        </DropdownLink>
                                        <DropdownLink :href="route('admin.payments.revenue-report')">
                                            Revenue Report
                                        </DropdownLink>
                                    </template>
                                </Dropdown>

                                <!-- Settings -->
                                <NavLink :href="route('admin.settings.questions')" :active="route().current('admin.settings.questions')">
                                    Settings
                                </NavLink>
                            </template>

                            <!-- School Navigation -->
                            <template v-else-if="isSchool">
                                <NavLink :href="route('school.dashboard')" :active="route().current('school.dashboard')">
                                    Dashboard
                                </NavLink>
                                <NavLink :href="route('school.jobs')" :active="route().current('school.jobs')">
                                    My Jobs
                                </NavLink>
                                <NavLink :href="route('school.jobs.create')" :active="route().current('school.jobs.create')">
                                    Post Job
                                </NavLink>

                                <!-- School Dropdown -->
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                            Applications
                                            <svg class="ms-1 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('school.applications')">
                                            View Applications
                                        </DropdownLink>
                                        <DropdownLink :href="route('school.profile')">
                                            School Profile
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </template>

                            <!-- Teams Dropdown -->
                            <Dropdown v-if="jetstream.hasTeamFeatures" align="right" width="60">
                                <template #trigger>
                                    <span class="inline-flex rounded-md">
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                            {{ user.current_team.name }}

                                            <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                            </svg>
                                        </button>
                                    </span>
                                </template>

                                <template #content>
                                    <div class="w-60">
                                        <!-- Team Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            Manage Team
                                        </div>

                                        <!-- Team Settings -->
                                        <DropdownLink :href="route('teams.show', user.current_team)">
                                            Team Settings
                                        </DropdownLink>

                                        <DropdownLink v-if="jetstream.canCreateTeams" :href="route('teams.create')">
                                            Create New Team
                                        </DropdownLink>

                                        <!-- Team Switcher -->
                                        <template v-if="user.all_teams.length > 1">
                                            <div class="border-t border-gray-200" />

                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                Switch Teams
                                            </div>

                                            <template v-for="team in user.all_teams" :key="team.id">
                                                <form @submit.prevent="switchToTeam(team)">
                                                    <DropdownLink as="button">
                                                        <div class="flex items-center">
                                                            <svg v-if="team.id == user.current_team_id" class="me-2 size-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>

                                                            <div>{{ team.name }}</div>
                                                        </div>
                                                    </DropdownLink>
                                                </form>
                                            </template>
                                        </template>
                                    </div>
                                </template>
                            </Dropdown>

                            <!-- User Settings Dropdown -->
                            <div class="relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <button v-if="jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                            <img class="size-8 rounded-full object-cover" :src="user.profile_photo_url" :alt="user.name">
                                        </button>

                                        <span v-else class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                                {{ user.name }}

                                                <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <!-- Account Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            Manage Account
                                        </div>

                                        <DropdownLink :href="route('profile.show')">
                                            Profile
                                        </DropdownLink>

                                        <DropdownLink v-if="jetstream.hasApiFeatures" :href="route('api-tokens.index')">
                                            API Tokens
                                        </DropdownLink>

                                        <div class="border-t border-gray-200" />

                                        <!-- Authentication -->
                                        <form @submit.prevent="logout">
                                            <DropdownLink as="button">
                                                Log Out
                                            </DropdownLink>
                                        </form>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out" @click="showingNavigationDropdown = ! showingNavigationDropdown">
                                <svg
                                    class="size-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <!-- Teacher Mobile Menu -->
                        <template v-if="isTeacher">
                            <ResponsiveNavLink :href="route('teacher.dashboard')" :active="route().current('teacher.dashboard')">
                                Dashboard
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('teacher.jobs')" :active="route().current('teacher.jobs')">
                                Jobs
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('teacher.applications')" :active="route().current('teacher.applications')">
                                Applications
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('teacher.profile')" :active="route().current('teacher.profile')">
                                Edit Profile
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('teacher.appraisals')" :active="route().current('teacher.appraisals')">
                                My Appraisals
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('teacher.reappraise')" :active="route().current('teacher.reappraise')">
                                New Appraisal
                            </ResponsiveNavLink>
                        </template>

                        <!-- Admin Mobile Menu -->
                        <template v-else-if="isAdmin">
                            <ResponsiveNavLink :href="route('admin.dashboard')" :active="route().current('admin.dashboard')">
                                Dashboard
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('admin.teachers')" :active="route().current('admin.teachers')">
                                Teachers
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('admin.schools')" :active="route().current('admin.schools')">
                                Schools
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('admin.jobs')" :active="route().current('admin.jobs')">
                                Jobs
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('admin.applications')" :active="route().current('admin.applications')">
                                Applications
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('admin.appraisals')" :active="route().current('admin.appraisals')">
                                Appraisals
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('admin.payments')" :active="route().current('admin.payments')">
                                Payments
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('admin.settings.questions')" :active="route().current('admin.settings.questions')">
                                Settings
                            </ResponsiveNavLink>
                        </template>

                        <!-- School Mobile Menu -->
                        <template v-else-if="isSchool">
                            <ResponsiveNavLink :href="route('school.dashboard')" :active="route().current('school.dashboard')">
                                Dashboard
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('school.jobs')" :active="route().current('school.jobs')">
                                My Jobs
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('school.jobs.create')" :active="route().current('school.jobs.create')">
                                Post Job
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('school.applications')" :active="route().current('school.applications')">
                                Applications
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('school.profile')" :active="route().current('school.profile')">
                                School Profile
                            </ResponsiveNavLink>
                        </template>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            <div v-if="jetstream.managesProfilePhotos" class="shrink-0 me-3">
                                <img class="size-10 rounded-full object-cover" :src="user.profile_photo_url" :alt="user.name">
                            </div>

                            <div>
                                <div class="font-medium text-base text-gray-800">
                                    {{ user.name }}
                                </div>
                                <div class="font-medium text-sm text-gray-500">
                                    {{ user.email }}
                                </div>
                                <div class="text-xs text-gray-400 capitalize">
                                    {{ user.type }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.show')" :active="route().current('profile.show')">
                                Profile
                            </ResponsiveNavLink>

                            <ResponsiveNavLink v-if="jetstream.hasApiFeatures" :href="route('api-tokens.index')" :active="route().current('api-tokens.index')">
                                API Tokens
                            </ResponsiveNavLink>

                            <!-- Authentication -->
                            <form method="POST" @submit.prevent="logout">
                                <ResponsiveNavLink as="button">
                                    Log Out
                                </ResponsiveNavLink>
                            </form>

                            <!-- Team Management -->
                            <template v-if="jetstream.hasTeamFeatures">
                                <div class="border-t border-gray-200" />

                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    Manage Team
                                </div>

                                <!-- Team Settings -->
                                <ResponsiveNavLink :href="route('teams.show', user.current_team)" :active="route().current('teams.show')">
                                    Team Settings
                                </ResponsiveNavLink>

                                <ResponsiveNavLink v-if="jetstream.canCreateTeams" :href="route('teams.create')" :active="route().current('teams.create')">
                                    Create New Team
                                </ResponsiveNavLink>

                                <!-- Team Switcher -->
                                <template v-if="user.all_teams.length > 1">
                                    <div class="border-t border-gray-200" />

                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        Switch Teams
                                    </div>

                                    <template v-for="team in user.all_teams" :key="team.id">
                                        <form @submit.prevent="switchToTeam(team)">
                                            <ResponsiveNavLink as="button">
                                                <div class="flex items-center">
                                                    <svg v-if="team.id == user.current_team_id" class="me-2 size-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <div>{{ team.name }}</div>
                                                </div>
                                            </ResponsiveNavLink>
                                        </form>
                                    </template>
                                </template>
                            </template>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <!-- Simple Error Display -->
            <div v-if="flash.error"
                 class="fixed top-4 right-4 z-50 max-w-sm p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg shadow-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm text-red-800">{{ flash.error }}</span>
                </div>
            </div>

            <!-- Simple Success Display -->
            <div v-if="flash.success"
                 class="fixed top-4 right-4 z-50 max-w-sm p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-lg shadow-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-emerald-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="text-sm text-emerald-800">{{ flash.success }}</span>
                </div>
            </div>

            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
