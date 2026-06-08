<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { debounce } from '@/utils/debounce';
import DataTable from '@/Components/DataTable.vue';
import Badge from '@/Components/Badge.vue';
import ModalForm from '@/Components/ModalForm.vue';
import { Plus, Pencil, Trash2, Search } from 'lucide-vue-next';

const props = defineProps({
    items: Object,
    filters: Object,
    categories: Array,
});

const search = ref(props.filters.search ?? '');
const category = ref(props.filters.category ?? '');
const status = ref(props.filters.status ?? '');

const columns = [
    { key: 'name', label: 'Name' },
    { key: 'category', label: 'Category' },
    { key: 'status', label: 'Status' },
    { key: 'quantity', label: 'Quantity' },
    { key: 'date', label: 'Date' },
];

watch(
    [search, category, status],
    debounce(() => {
        router.get(
            route('monitoring-data.index'),
            { search: search.value, category: category.value, status: status.value },
            { preserveState: true, replace: true },
        );
    }, 300),
);

const showDelete = ref(false);
const target = ref(null);
const deleteForm = useForm({});

function confirmDelete(item) {
    target.value = item;
    showDelete.value = true;
}

function destroy() {
    deleteForm.delete(route('monitoring-data.destroy', target.value.id), {
        preserveScroll: true,
        onSuccess: () => (showDelete.value = false),
    });
}

function formatDate(value) {
    if (!value) return '-';
    return new Date(value).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
}
</script>

<template>
    <Head title="Monitoring Data" />

    <AuthenticatedLayout title="Monitoring Data">
        <div class="space-y-5">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex flex-1 flex-col gap-3 sm:flex-row">
                    <div class="relative sm:w-64">
                        <Search class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
                        <input
                            v-model="search"
                            type="text"
                            placeholder="Search data..."
                            class="w-full rounded-lg border-gray-300 pl-9 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200"
                        />
                    </div>
                    <select v-model="category" class="rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                        <option value="">All Categories</option>
                        <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
                    </select>
                    <select v-model="status" class="rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
                <Link
                    :href="route('monitoring-data.create')"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-700"
                >
                    <Plus class="h-4 w-4" /> Add Data
                </Link>
            </div>

            <DataTable :columns="columns" :rows="items.data" :links="items.links" :meta="items">
                <template #cell-status="{ value }">
                    <Badge :value="value" />
                </template>
                <template #cell-date="{ value }">
                    {{ formatDate(value) }}
                </template>
                <template #actions="{ row }">
                    <div class="flex items-center justify-end gap-2">
                        <Link :href="route('monitoring-data.edit', row.id)" class="rounded-md p-1.5 text-gray-500 hover:bg-gray-100 hover:text-indigo-600 dark:hover:bg-gray-700">
                            <Pencil class="h-4 w-4" />
                        </Link>
                        <button @click="confirmDelete(row)" class="rounded-md p-1.5 text-gray-500 hover:bg-gray-100 hover:text-red-600 dark:hover:bg-gray-700">
                            <Trash2 class="h-4 w-4" />
                        </button>
                    </div>
                </template>
            </DataTable>
        </div>

        <ModalForm :show="showDelete" title="Delete Data" @close="showDelete = false">
            <p class="text-sm text-gray-600 dark:text-gray-300">
                Are you sure you want to delete <span class="font-semibold">{{ target?.name }}</span>?
            </p>
            <template #footer>
                <button @click="showDelete = false" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">
                    Cancel
                </button>
                <button @click="destroy" :disabled="deleteForm.processing" class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 disabled:opacity-50">
                    Delete
                </button>
            </template>
        </ModalForm>
    </AuthenticatedLayout>
</template>
