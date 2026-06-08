<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import { ArrowLeft } from 'lucide-vue-next';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: 'user',
    status: 'active',
});

function submit() {
    form.post(route('users.store'));
}
</script>

<template>
    <Head title="Add User" />

    <AuthenticatedLayout title="Add User">
        <div class="mx-auto max-w-2xl">
            <Link :href="route('users.index')" class="mb-4 inline-flex items-center gap-2 text-sm text-gray-500 hover:text-indigo-600">
                <ArrowLeft class="h-4 w-4" /> Back to users
            </Link>

            <form @submit.prevent="submit" class="space-y-5 rounded-xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div>
                    <InputLabel for="name" value="Name" />
                    <TextInput id="name" v-model="form.name" type="text" class="mt-1 block w-full" />
                    <InputError :message="form.errors.name" class="mt-1" />
                </div>

                <div>
                    <InputLabel for="email" value="Email" />
                    <TextInput id="email" v-model="form.email" type="email" class="mt-1 block w-full" />
                    <InputError :message="form.errors.email" class="mt-1" />
                </div>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div>
                        <InputLabel for="role" value="Role" />
                        <select id="role" v-model="form.role" class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                            <option value="admin">Admin</option>
                            <option value="editor">Editor</option>
                            <option value="user">User</option>
                        </select>
                        <InputError :message="form.errors.role" class="mt-1" />
                    </div>
                    <div>
                        <InputLabel for="status" value="Status" />
                        <select id="status" v-model="form.status" class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <InputError :message="form.errors.status" class="mt-1" />
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div>
                        <InputLabel for="password" value="Password" />
                        <TextInput id="password" v-model="form.password" type="password" class="mt-1 block w-full" />
                        <InputError :message="form.errors.password" class="mt-1" />
                    </div>
                    <div>
                        <InputLabel for="password_confirmation" value="Confirm Password" />
                        <TextInput id="password_confirmation" v-model="form.password_confirmation" type="password" class="mt-1 block w-full" />
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <Link :href="route('users.index')" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">
                        Cancel
                    </Link>
                    <button type="submit" :disabled="form.processing" class="rounded-lg bg-indigo-600 px-5 py-2 text-sm font-medium text-white hover:bg-indigo-700 disabled:opacity-50">
                        Save User
                    </button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
