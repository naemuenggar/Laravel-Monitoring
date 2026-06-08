<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import { ArrowLeft } from 'lucide-vue-next';

const props = defineProps({
    item: Object,
});

const form = useForm({
    name: props.item.name,
    category: props.item.category,
    description: props.item.description ?? '',
    status: props.item.status,
    quantity: props.item.quantity,
    date: props.item.date ? String(props.item.date).slice(0, 10) : '',
});

function submit() {
    form.put(route('monitoring-data.update', props.item.id));
}
</script>

<template>
    <Head title="Edit Data" />

    <AuthenticatedLayout title="Edit Monitoring Data">
        <div class="mx-auto max-w-2xl">
            <Link :href="route('monitoring-data.index')" class="mb-4 inline-flex items-center gap-2 text-sm text-gray-500 hover:text-indigo-600">
                <ArrowLeft class="h-4 w-4" /> Back to data
            </Link>

            <form @submit.prevent="submit" class="space-y-5 rounded-xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div>
                    <InputLabel for="name" value="Name" />
                    <TextInput id="name" v-model="form.name" type="text" class="mt-1 block w-full" />
                    <InputError :message="form.errors.name" class="mt-1" />
                </div>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div>
                        <InputLabel for="category" value="Category" />
                        <TextInput id="category" v-model="form.category" type="text" class="mt-1 block w-full" />
                        <InputError :message="form.errors.category" class="mt-1" />
                    </div>
                    <div>
                        <InputLabel for="status" value="Status" />
                        <select id="status" v-model="form.status" class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="pending">Pending</option>
                        </select>
                        <InputError :message="form.errors.status" class="mt-1" />
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div>
                        <InputLabel for="quantity" value="Quantity" />
                        <TextInput id="quantity" v-model="form.quantity" type="number" min="0" class="mt-1 block w-full" />
                        <InputError :message="form.errors.quantity" class="mt-1" />
                    </div>
                    <div>
                        <InputLabel for="date" value="Date" />
                        <TextInput id="date" v-model="form.date" type="date" class="mt-1 block w-full" />
                        <InputError :message="form.errors.date" class="mt-1" />
                    </div>
                </div>

                <div>
                    <InputLabel for="description" value="Description" />
                    <textarea id="description" v-model="form.description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200"></textarea>
                    <InputError :message="form.errors.description" class="mt-1" />
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <Link :href="route('monitoring-data.index')" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">
                        Cancel
                    </Link>
                    <button type="submit" :disabled="form.processing" class="rounded-lg bg-indigo-600 px-5 py-2 text-sm font-medium text-white hover:bg-indigo-700 disabled:opacity-50">
                        Update Data
                    </button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
