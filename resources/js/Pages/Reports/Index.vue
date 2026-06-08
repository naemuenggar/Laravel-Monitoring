<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { debounce } from '@/utils/debounce';
import StatCard from '@/Components/StatCard.vue';
import ChartCard from '@/Components/ChartCard.vue';
import DataTable from '@/Components/DataTable.vue';
import Badge from '@/Components/Badge.vue';
import { FileBarChart, CheckCircle2, Clock, XCircle, Download, Search } from 'lucide-vue-next';

const props = defineProps({
    reports: Object,
    filters: Object,
    summary: Object,
    typeChart: Object,
});

const search = ref(props.filters.search ?? '');
const status = ref(props.filters.status ?? '');
const from = ref(props.filters.from ?? '');
const to = ref(props.filters.to ?? '');

const columns = [
    { key: 'title', label: 'Title' },
    { key: 'type', label: 'Type' },
    { key: 'status', label: 'Status' },
    { key: 'created_at', label: 'Created At' },
];

watch(
    [search, status, from, to],
    debounce(() => {
        router.get(
            route('reports.index'),
            { search: search.value, status: status.value, from: from.value, to: to.value },
            { preserveState: true, replace: true },
        );
    }, 300),
);

function formatDate(value) {
    return new Date(value).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
}

function exportDummy() {
    alert('Export started (demo only). In production this would generate a file.');
}
</script>

<template>
    <Head title="Reports" />

    <AuthenticatedLayout title="Reports">
        <div class="space-y-6">
            <!-- Summary cards -->
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
                <StatCard title="Total Reports" :value="summary.total" :icon="FileBarChart" color="indigo" />
                <StatCard title="Completed" :value="summary.completed" :icon="CheckCircle2" color="emerald" />
                <StatCard title="Pending" :value="summary.pending" :icon="Clock" color="amber" />
                <StatCard title="Failed" :value="summary.failed" :icon="XCircle" color="sky" />
            </div>

            <div class="grid grid-cols-1 gap-5 lg:grid-cols-3">
                <ChartCard
                    title="Reports by Type"
                    type="bar"
                    label="Reports"
                    :labels="typeChart.labels"
                    :data="typeChart.data"
                    class="lg:col-span-1"
                />

                <!-- Filters + table -->
                <div class="space-y-4 lg:col-span-2">
                    <div class="flex flex-col gap-3 rounded-xl border border-gray-100 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:flex-row sm:flex-wrap sm:items-end">
                        <div class="relative flex-1">
                            <Search class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
                            <input v-model="search" type="text" placeholder="Search title..." class="w-full rounded-lg border-gray-300 pl-9 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200" />
                        </div>
                        <select v-model="status" class="rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                            <option value="">All Status</option>
                            <option value="completed">Completed</option>
                            <option value="pending">Pending</option>
                            <option value="failed">Failed</option>
                        </select>
                        <input v-model="from" type="date" class="rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200" />
                        <input v-model="to" type="date" class="rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200" />
                        <button @click="exportDummy" class="inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700">
                            <Download class="h-4 w-4" /> Export
                        </button>
                    </div>
                </div>
            </div>

            <DataTable :columns="columns" :rows="reports.data" :links="reports.links" :meta="reports">
                <template #cell-status="{ value }">
                    <Badge :value="value" />
                </template>
                <template #cell-created_at="{ value }">
                    {{ formatDate(value) }}
                </template>
            </DataTable>
        </div>
    </AuthenticatedLayout>
</template>
