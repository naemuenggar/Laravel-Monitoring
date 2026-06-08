<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import { User, Lock, Palette, Bell } from 'lucide-vue-next';

const props = defineProps({
    user: Object,
});

const profileForm = useForm({
    name: props.user.name,
    email: props.user.email,
});

const passwordForm = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

function updateProfile() {
    profileForm.put(route('settings.profile'), { preserveScroll: true });
}

function updatePassword() {
    passwordForm.put(route('settings.password'), {
        preserveScroll: true,
        onSuccess: () => passwordForm.reset(),
    });
}

// Dark mode (persisted to localStorage)
const darkMode = ref(false);
const notifications = ref(true);

onMounted(() => {
    darkMode.value = localStorage.getItem('theme') === 'dark';
    applyDark();
});

function toggleDark() {
    darkMode.value = !darkMode.value;
    localStorage.setItem('theme', darkMode.value ? 'dark' : 'light');
    applyDark();
}

function applyDark() {
    document.documentElement.classList.toggle('dark', darkMode.value);
}
</script>

<template>
    <Head title="Settings" />

    <AuthenticatedLayout title="Settings">
        <div class="mx-auto max-w-3xl space-y-6">
            <!-- Profile -->
            <section class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="mb-4 flex items-center gap-2">
                    <User class="h-5 w-5 text-indigo-600" />
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Profile Information</h2>
                </div>
                <form @submit.prevent="updateProfile" class="space-y-4">
                    <div>
                        <InputLabel for="name" value="Name" />
                        <TextInput id="name" v-model="profileForm.name" type="text" class="mt-1 block w-full" />
                        <InputError :message="profileForm.errors.name" class="mt-1" />
                    </div>
                    <div>
                        <InputLabel for="email" value="Email" />
                        <TextInput id="email" v-model="profileForm.email" type="email" class="mt-1 block w-full" />
                        <InputError :message="profileForm.errors.email" class="mt-1" />
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" :disabled="profileForm.processing" class="rounded-lg bg-indigo-600 px-5 py-2 text-sm font-medium text-white hover:bg-indigo-700 disabled:opacity-50">
                            Save Changes
                        </button>
                    </div>
                </form>
            </section>

            <!-- Password -->
            <section class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="mb-4 flex items-center gap-2">
                    <Lock class="h-5 w-5 text-indigo-600" />
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Change Password</h2>
                </div>
                <form @submit.prevent="updatePassword" class="space-y-4">
                    <div>
                        <InputLabel for="current_password" value="Current Password" />
                        <TextInput id="current_password" v-model="passwordForm.current_password" type="password" class="mt-1 block w-full" />
                        <InputError :message="passwordForm.errors.current_password" class="mt-1" />
                    </div>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <InputLabel for="password" value="New Password" />
                            <TextInput id="password" v-model="passwordForm.password" type="password" class="mt-1 block w-full" />
                            <InputError :message="passwordForm.errors.password" class="mt-1" />
                        </div>
                        <div>
                            <InputLabel for="password_confirmation" value="Confirm Password" />
                            <TextInput id="password_confirmation" v-model="passwordForm.password_confirmation" type="password" class="mt-1 block w-full" />
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" :disabled="passwordForm.processing" class="rounded-lg bg-indigo-600 px-5 py-2 text-sm font-medium text-white hover:bg-indigo-700 disabled:opacity-50">
                            Update Password
                        </button>
                    </div>
                </form>
            </section>

            <!-- Appearance -->
            <section class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="mb-4 flex items-center gap-2">
                    <Palette class="h-5 w-5 text-indigo-600" />
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Appearance</h2>
                </div>
                <div class="flex items-center justify-between py-2">
                    <div>
                        <p class="text-sm font-medium text-gray-800 dark:text-gray-200">Dark Mode</p>
                        <p class="text-xs text-gray-500">Toggle the dashboard theme.</p>
                    </div>
                    <button
                        type="button"
                        @click="toggleDark"
                        :class="['relative inline-flex h-6 w-11 items-center rounded-full transition', darkMode ? 'bg-indigo-600' : 'bg-gray-300']"
                    >
                        <span :class="['inline-block h-4 w-4 transform rounded-full bg-white transition', darkMode ? 'translate-x-6' : 'translate-x-1']"></span>
                    </button>
                </div>
            </section>

            <!-- Notifications -->
            <section class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="mb-4 flex items-center gap-2">
                    <Bell class="h-5 w-5 text-indigo-600" />
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Notifications</h2>
                </div>
                <div class="flex items-center justify-between py-2">
                    <div>
                        <p class="text-sm font-medium text-gray-800 dark:text-gray-200">Email Notifications</p>
                        <p class="text-xs text-gray-500">Receive activity updates via email (demo).</p>
                    </div>
                    <button
                        type="button"
                        @click="notifications = !notifications"
                        :class="['relative inline-flex h-6 w-11 items-center rounded-full transition', notifications ? 'bg-indigo-600' : 'bg-gray-300']"
                    >
                        <span :class="['inline-block h-4 w-4 transform rounded-full bg-white transition', notifications ? 'translate-x-6' : 'translate-x-1']"></span>
                    </button>
                </div>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
